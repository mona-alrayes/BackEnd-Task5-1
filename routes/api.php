<?php



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Auth\ApiLoginRegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::controller(ApiLoginRegisterController::class)->group(function() {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});


Route::controller(BookController::class)->group(function() {
    Route::get('/books', 'index');
    Route::get('/books/{id}', 'show');
    Route::get('/books/search/{category}', 'searchByCategory');
    Route::get('/books/search2/{subcategory}', 'searchBySubCategory');
});


Route::middleware('auth:sanctum')->group( function () {
    Route::post('/logout', [ApiLoginRegisterController::class, 'logout']);
});

Route::middleware(['auth:sanctum' , 'role:admin'])->group( function () {
    Route::post('/books', [BookController::class , 'store']);
    Route::put('/books/{id}', [BookController::class , 'update']);
    Route::delete('/books/{id}', [BookController::class , 'destroy']);
 });

Route::middleware(['auth:sanctum' , 'role:member'])->group( function () {
    Route::get('/favorite/{id}', [FavoriteController::class , 'show']); 
    Route::get('/favorite', [FavoriteController::class , 'index']);
    Route::put('/rating/{id}', [RatingController::class , 'update']);
    Route::get('/rating', [RatingController::class , 'index']);
    Route::delete('/rating/{id}', [RatingController::class , 'destroy']);

 });

 Route::middleware(['auth:sanctum' , 'role:admin'])->group( function ()  {
    
    Route::resource('/users', UserController::class);

});
