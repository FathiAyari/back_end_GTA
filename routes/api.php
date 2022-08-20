<?php

use App\Http\Controllers\CompanyController;
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
Route::post('/postplannings', [PlanningController::class, 'store']);
Route::delete('/deleteplanning/{id}', [PlanningController::class, 'destroy']);
Route::put('/updateplanning/{id}', [PlanningController::class,'update']);
Route::put('/updatestatus/{id}', [PlanningController::class,'updatestatus']);

//activites tous bien fonctionne
Route::get('/getactivites', [ActiviteController::class, 'getactivites']);
Route::get('/activities/{status}', [ActiviteController::class, 'getUnassignedActivites']);
Route::post('/postactivites', [ActiviteController::class, 'postactivites']);
Route::post('/updateactivity/{id}', [ActiviteController::class, 'updateActivity']);
Route::delete('/deleteactivity/{id}', [ActiviteController::class, 'deleteActivity']);


//users tous bien fonctionne
Route::get('/getusers', [Controller::class, 'getusers']);
Route::delete('/deleteuser/{id}', [Controller::class, 'deleteusers']);
Route::post('/createuser', [Controller::class, 'createuser']);
Route::post('/updateuser/{id}', [Controller::class, 'updateuser']);


//population tous bien fonctionne
Route::post('/createpopulation', [PopulationController::class, 'createpopulation']);
Route::delete('/deletepopulation/{id}', [PopulationController::class, 'deletepopulation']);
Route::put('/updatepopulation/{id}', [PopulationController::class, 'updatepopulation']);
Route::post('/createplagehoraire/{id}', [PopulationController::class, 'createplagehoraire']);
Route::get('/getpopulations', [PopulationController::class, 'getpopulations']);


//societes tous bien fonctionne
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
Route::post('/order', [ProductsController::class, 'order']);
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
