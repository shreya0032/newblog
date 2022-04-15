<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class ProductExport implements FromCollection, WithHeadingRow
{
    private $tableNames;

    public function __construct()
    {
        $tableName = DB::connection('mysql2')->select('SHOW TABLES');
        foreach($tableName as $table){
            $this->tableNames = $table;
        }
        
    }

    // public function headings($tableName):array{
    //     $columns = Schema::Connection('mysql2')->getColumnListing($tableName);
    //     return $columns;
    // }
   
    // return $this->your_collection;
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return DB::connection('mysql2')->table($tableName)->get();
        return $this->tableNames;
;
    }
}
