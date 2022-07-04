<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController; 
use App\Http\Controllers\UserController; 
use App\Http\Controllers\TableController; 
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| 
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::redirect('/', 'login');

Route::get('/home', [HomeController::class, 'index'])->name('home');

// // Route::get('/', [HomeController::class, 'login'])->name('auth.login');
// Route::post('/login', [HomeController::class, 'checkLogin'])->name('check.login');

Route::get('/dashboard', [HomeController::class, 'showDashboard'])->name('dashboard');

Route::group(['middleware' => ['auth' , 'permission:add|edit|delete|details']], function() {

    
    // resources/views/admin/table/tableFilter.blade.php   

    /*===================Dynamic Table========================*/ 

    Route::get('table/{table}', [TableController::class, 'tableShow'])->name('table.show')->middleware(['permission:details|add|edit']);
    Route::get('table/{table}/get', [TableController::class, 'getTableData'])->name('product.get')->middleware('permission:details');
    Route::get('table/{table}/add', [TableController::class, 'tableAdd'])->name('product.add')->middleware('permission:add');
    Route::post('table/{table}/add/save', [TableController::class, 'tableSave'])->name('product.add.save')->middleware('permission:add');
    Route::get('table/{table}/edit/{id?}', [TableController::class, 'editTableList'])->name('product.edit')->middleware('permission:edit');
    Route::post('table/{table}/edit/update', [TableController::class, 'updateTableList'])->name('product.update')->middleware('permission:edit');
    Route::get('table/{table}/delete/{id?}', [TableController::class, 'deleteTableList'])->name('product.delete')->middleware('permission:delete');
    Route::get('table/{table}/getrow', [TableController::class, 'getrow']);
    Route::get('table/filter/{table}/', [TableController::class, 'filter'])->name('filter');
    Route::post('table/filter-search/{table}/', [TableController::class, 'filterSearch'])->name('filter.search');
    // Route::get('table/{table}/filter-result', function(){return view('admin.table.tableFilter');})->name('filter.result');
    Route::get('export/csv/{table}', [TableController::class, 'exportCsv'])->name('export.csv');



    /*===================Role========================*/ 
    // Route::group(['middleware' => 'role:super admin'], function() {

    Route::get('/activity-log', [TableController::class, 'activityLog'])->name('activity_log');
    Route::get('/activity-log/getAjax', [TableController::class, 'getactivityLog'])->name('activity_log.show');
    
    
    Route::get('/roles/index', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/role-list-ajax', [RoleController::class, 'getRoleList'])->name('roles.list');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/edit/{id?}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/roles/update', [RoleController::class, 'update'])->name('roles.update');
    Route::get('/roles/delete/{id?}', [RoleController::class, 'delete'])->name('roles.delete');
    Route::post('/roles/delete/selected', [RoleController::class, 'deleteSelected'])->name('roles.delete.selected');
    Route::get('/roles/manage-permission/{id?}', [RoleController::class, 'managePermission'])->name('roles.permission');
    Route::post('/roles/update/manage-permission', [RoleController::class, 'updatePermission'])->name('roles.permission.update');
    Route::get('/roles/delete/manage-permission/{rid?}/{pid?}', [RoleController::class, 'deletePermission'])->name('roles.permission.delete');


    // /*===================Permission========================*/ 

    Route::get('/permission/index', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('/permission/permission-list-ajax', [PermissionController::class, 'getPermissionList'])->name('permission.list');
    Route::get('/permission/permission-table-list-ajax', [PermissionController::class, 'getTableList'])->name('permission.table.list');
    Route::get('/permission/create', [PermissionController::class, 'create'])->name('permission.create');
    Route::post('/permission/store', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('/permission/edit/{id?}', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::post('/permission/update', [PermissionController::class, 'update'])->name('permission.update');
    Route::get('/permission/delete/{id?}', [PermissionController::class, 'delete'])->name('permission.delete');
   
    // /*===================User========================*/ 

    Route::get('/user/index', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/user-list-ajax', [UserController::class, 'getUserList'])->name('user.list');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{id?}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
    // Route::post('/user/{id?}/roles/{id?}/delete', [UserController::class, 'userRoleDelete'])->name('user.role.delete');
    Route::get('/user/delete/{id?}', [UserController::class, 'delete'])->name('user.delete');
    Route::post('/user/delete/selected', [UserController::class, 'deleteUserSelected'])->name('user.delete.selected');
    
    // });

    Route::get('user-profile-ajax/{id}', [UserController::class, 'getuserProfile']);
    Route::post('profile', [UserController::class, 'userProfile'])->name('user.profile');
    Route::post('avatar', [UserController::class, 'userAvatar'])->name('user.avatar');

});