<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Button;
use Illuminate\Http\Response;
use Illuminate\Http\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductExport;
use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Models\Activiy;
use App\Helpers\LogActivity;
use Exception;
use Illuminate\Support\Facades\Session;

use function PHPUnit\Framework\returnSelf;

class TableController extends Controller
{
    public $table =  '';



    public function index()
    {
        return view('admin.dashboard.dashboard');
    }


    public function tableShow($tableName)
    {
        $columns = Schema::Connection('mysql2')->getColumnListing($tableName);
        $table_data = DB::connection('mysql2')->table($tableName)->paginate(5);
        return view('admin.table.tableDetails', compact('columns', 'table_data', 'tableName'));
    }




    public function getrow($tableName)
    {
        return Schema::Connection('mysql2')->getColumnListing($tableName);
    }


    public function getTableData($tableName)
    {
        $this->table = $tableName;
        $user = auth()->user();
        $table_data = DB::connection('mysql2')->table($tableName);

        $datatables =  Datatables::of($table_data)
            ->addColumn('action', function ($data) use ($user) {
                $btn = '';
                if ($user->can('edit')) {
                    $btn = '<a href=" ' . route('product.edit', [$this->table, $data->id]) . ' " class="edit btn btn-primary btn-sm">Edit</a>';
                    return $btn;
                }
            })

            ->rawColumns(['action'])
            ->make(true);
        return $datatables;
    }





    public function tableAdd($tableName)
    {
        $columnName = Schema::Connection('mysql2')->getColumnListing($tableName);
        return view('admin.table.add_table', ['data' => $columnName]);
    }


    public function tableSave(Request $request, $tableName)
    {
        try{
            $values = $request->except('_token');

            if ( !empty(array_filter($values))) {
                $query = DB::connection('mysql2')->table($tableName)->insert($values);

                if ($query) {
                    LogActivity::addToLog([
                        'table_name' => $tableName,
                        'description' => 'add',
                        'role_id' => auth()->user()->id,
                        'present_info' => json_encode([$values]),

                    ]);
                    return redirect()->route('table.show', $tableName);
                } else {
                    return redirect()->back()->with('msg', 'add error getting');
                }
            } else {
                return redirect()->back()->with('msg', 'Atleast one field is required');
            }
        }
        catch (Exception $e){
            return redirect()->back()->with('msg', json_encode($e->getMessage(), true));
        }
        
    }





    public function editTableList($tableName, $id)
    {
        $editDetails = DB::connection('mysql2')->table($tableName)->where('id', $id)->first();
        return view('admin.table.editProduct', ['data' => $editDetails]);
    }






    public function updateTableList(Request $request, $tableName)
    {
        try{
            $values = $request->except('_token');
            $tabledata = DB::connection('mysql2')->table($tableName)->where('id', $values['id'])->get();

            if ( !empty(array_filter($values))) {
                $query = DB::connection('mysql2')->table($tableName)
                        ->where('id', $values['id'])
                        ->update($values);

                if ($query) {
                    LogActivity::addToLog([
                        'table_name' => $tableName,
                        'description' => 'update',
                        'previous_info' => json_encode($tabledata),
                        'present_info' => json_encode([$values]),
                        'role_id' => auth()->user()->id,
                        ]);
                    return redirect()->route('table.show', $tableName);
                }else{
                    return redirect()->back()->with('msg', 'error getting');
                }
            }else{
                return redirect()->back()->with('msg', 'Atleast one field is required');
            }
        }catch(Exception $e){
            return redirect()->back()->with('msg', json_encode($e->getMessage(), true));
        }
    }




    public function deleteTableList($tableName, $id)
    {
        $query = DB::connection('mysql2')->table($tableName)
            ->where('id', $id)
            ->delete();
        if ($query) {
            return redirect()->route('table.show', $tableName);
        }
    }


    public function filter($tableName)
    {
        $columns = Schema::Connection('mysql2')->getColumnListing($tableName);
        return view('admin.table.filter', compact('columns'));
    }



    public function filterSearch(Request $request, $tableName)
    {
        if(empty(array_filter($request['select'])) ||empty(array_filter($request['column']))){
            return redirect()->back()->with('msg', "Fill atleast one field");
        }else{
            $columns = Schema::Connection('mysql2')->getColumnListing($tableName);
            $selects = $request['select'];
            $search_texts = $request['column'];

            $table_data = DB::connection('mysql2')->table($tableName)

                ->where(function ($table_data) use ($selects, $search_texts, $columns) {
                    foreach ($columns as $key => $column) {
                        if ($selects[$key] == 'like%...%') {
                            $table_data->orwhere($column, 'like',  '%' . $search_texts[$key] . '%');
                        } elseif ($selects[$key] == 'is_null') {
                            $table_data->orwhere($column, $search_texts[$key], 'IS NULL');
                        } elseif ($selects[$key] == 'is_not_null') {
                            $table_data->orwhere($column, $search_texts[$key], 'IS NOT NULL');
                        } else {
                            $table_data->orwhere($column, $selects[$key], $search_texts[$key]);
                        }
                    }
                })->get();

                return view('admin.table.tableDetails', compact('table_data', 'columns', 'tableName'));

        }
    }

    // public function filterResult($tableName){

    //     $columns = Schema::Connection('mysql2')->getColumnListing($tableName);
    //     return view('admin.table.tableFilter', compact('columns'));

    // }

    public function activityLog()
    {
        return view('admin.activity_log.activity_log');
    }

    public function getactivityLog()
    {
        $userActivity = DB::table('log_activities')->leftJoin('roles', 'roles.id', '=', 'log_activities.role_id')->select('table_name', 'description', 'roles.name as role_name', 'previous_info', 'present_info')->get();
        return DataTables::of($userActivity)
            ->addIndexColumn()
            ->addColumn('table_name', function ($data) {
                return $data->table_name;
            })
            ->addColumn('description', function ($data) {
                return $data->description;
            })
            ->addColumn('role_name', function ($data) {
                return $data->role_name;
            })
            ->addColumn('previous_info', function ($data) {

                $previous_info_row = "<div>";

                $previous_info = json_decode($data->previous_info, true);

                if (is_array($previous_info)) {
                    $x = array();
                    foreach ($previous_info as $key => $value) {
                        foreach ($value as $column => $val) {
                            $x[] = $column . ":" . $val;
                        }
                    }
                    $previous_info_row .= implode(',</br> ', $x) . "</div>";
                    // $previous_info_row .= "";

                } else {
                    $previous_info_row .= "No data Found </div>";
                }
                // }

                // }

                return $previous_info_row;
            })
            ->addColumn('present_info', function ($data) {

                $present_info_row = "<div>";

                $present_info = json_decode($data->present_info, true);
                if (is_array($present_info)) {
                    $x = array();
                    foreach ($present_info as $key => $value) {
                        foreach ($value as $column => $val) {
                            $x[] = $column . ":" . $val;
                        }
                    }
                    $present_info_row .= implode(',</br>', $x) . "</div>";
                } else {
                    $present_info_row .= "No data Found </div>";
                }
                // }

                // }

                return $present_info_row;
            })
            ->rawColumns(['table_name', 'description', 'present_info', 'previous_info', 'role_name'])
            ->make(true);
    }
}
