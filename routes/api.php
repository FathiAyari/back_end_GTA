<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\NotifController;
use App\Http\Controllers\PopulationConfigController;
use App\Http\Controllers\PreOrderController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\StockHistoryController;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PlanningController;
use App\Http\Controllers\PopulationController;
use App\Http\Controllers\ActiviteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//authentication
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

//plannings tous bien fonctionne
Route::get('/getplannings', [PlanningController::class, 'getplannings']);
Route::get('/getplanning/{id}', [PlanningController::class, 'getplanning']);
Route::get('/myplans/{id}', [PlanningController::class, 'myPlans']);
Route::post('/create_planning', [PlanningController::class, 'createPlanning']);
Route::delete('/deleteplanning/{id}', [PlanningController::class, 'deletePlanning']);
Route::put('/updateplanning/{id}', [PlanningController::class,'update']);
Route::put('/updatestatus/{id}', [PlanningController::class,'updatestatus']);
Route::get('/start_planning/{id}/{user_id}', [PlanningController::class,'startPlan']);
Route::get('/finish_planning/{id}/{user_id}', [PlanningController::class,'finishPlanning']);

//activites tous bien fonctionne
Route::get('/getactivites', [ActiviteController::class, 'getactivites']);
Route::get('/activities/{status}', [ActiviteController::class, 'getUnassignedActivites']);
Route::post('/postactivites', [ActiviteController::class, 'postactivites']);
Route::post('/updateactivity/{id}', [ActiviteController::class, 'updateActivity']);
Route::delete('/deleteactivity/{id}', [ActiviteController::class, 'deleteActivity']);


//users tous bien fonctionne
Route::get('/getusers/{id}', [Controller::class, 'getusers']);
Route::delete('/deleteuser/{id}', [Controller::class, 'deleteusers']);
Route::post('/createuser', [Controller::class, 'createuser']);
Route::post('/updateuser/{id}', [Controller::class, 'updateuser']);


//population tous bien fonctionne
Route::post('/createpopulation', [PopulationController::class, 'createpopulation']);
Route::delete('/deletepopulation/{id}', [PopulationController::class, 'deletepopulation']);
Route::put('/updatepopulation/{id}', [PopulationController::class, 'updatepopulation']);
Route::post('/create_plage', [PopulationConfigController::class, 'createplagehoraire']);
Route::get('/getpopulations', [PopulationController::class, 'getpopulations']);
Route::delete('/delete_config/{id}', [PopulationConfigController::class, 'deleteConfig']);
Route::put('/update_config/{id}', [PopulationConfigController::class, 'updateplagehoraire']);


//company tous bien fonctionne
Route::get('/getsociete', [ActiviteController::class, 'getsociete']);
Route::post('/postsociete', [ActiviteController::class, 'postsociete']);
Route::put('/updatesociete/{id}', [ActiviteController::class, 'updatesociete']);
Route::delete('/deletesociete/{id}', [ActiviteController::class, 'deletesociete']);


// stats tous bien fonctionne
Route::get('/stuff_stat', [StatsController::class, 'stuffStats']);
Route::get('/products_stat', [StatsController::class, 'productsStats']);
Route::get('/orders_stats', [StatsController::class, 'ordersStats']);
Route::get('/planning_stats', [StatsController::class, 'planningStats']);

// products
Route::get('/products', [ProductsController::class, 'getProducts']);
Route::post('/create_product', [ProductsController::class, 'addProduct']);
Route::post('/supply', [ProductsController::class, 'supplyProduct']);
Route::get('/order/{id}/{cmp}', [ProductsController::class, 'order']);
Route::get('/product/{id}', [ProductsController::class, 'getProduct']);

// companies
Route::get('/companies', [CompanyController::class, 'getCompanies']);
Route::post('/create_company', [CompanyController::class, 'addCompany']);
Route::delete('/delete_company/{id}', [CompanyController::class, 'deleteCompany']);
Route::post('/update_company/{id}', [CompanyController::class, 'updateCompany']);


//stock history
Route::get('/stock_history', [StockHistoryController::class, 'getStockHistory']);


// general history
Route::get('/general_history', [\App\Http\Controllers\HistoryController::class, 'getGeneralHistory']);


//orders
Route::get('/preorders/{id}', [PreOrderController::class, 'getPrOrders']);
Route::post('/add_order', [PreOrderController::class, 'addPreOrder']);
Route::post('/update_order/{id}', [PreOrderController::class, 'updatePreOrder']);
Route::delete('/delete_order/{id}', [PreOrderController::class, 'deletePreOrder']);


// holidays
Route::post('/holidays', [HolidayController::class, 'getHolidays']);
Route::post('/create_holiday', [HolidayController::class, 'createHoliday']);
Route::post('/update_request', [HolidayController::class, 'updateHoliday']);
Route::delete('/delete_request/{id}', [HolidayController::class, 'deleteRequest']);


// notifs
Route::get('/notifications', [NotifController::class, 'getMynotifs']);
Route::get('/see', [NotifController::class, 'seeNotif']);
