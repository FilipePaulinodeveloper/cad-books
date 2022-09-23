<?php

use App\Http\Controllers\Auth\LoginJwtController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PublishCompanyController;
use App\Models\BookPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



// Route::post('/auth/login', [AuthController::class , 'login']);

// Route::prefix('v1')->group(function(){ 
//     Route::post('login', [LoginJwtController::class, 'login' ])->name('login');
//     Route::get('logout', [LoginJwtController::class, 'logout' ])->name('logout');
//     Route::get('refresh', [LoginJwtController::class, 'refresh' ])->name('refresh');
// });
Route::post('/user' , [AuthController::class, 'register']);
Route::post('v1/auth/login', [AuthController::class , 'login'])->name('login');
Route::post('/logout', [AuthController::class , 'logout'])->name('logout');


Route::middleware('auth:api')->prefix('v1')->group(function(){



    Route::name('books')->group(function(){
       Route::resource('book', BookController::class);
       Route::get('book/edit/{id}' , [BookController::class , 'showEdit']);

        Route::get('bookfiltertitle/{title}/books' , [BookController::class , 'bookfiltertitle']);
      //  Route::get('bookfilterauthor/{id}/books' , [BookController::class , 'bookfilterauthor']);
    });

    Route::name('authors')->group(function(){
        Route::get('author/{id}/books', [AuthorController::class , 'books']);
        


        Route::get('authorfiltername/{name}/author' , [AuthorController::class , 'authorfiltername']);

        Route::resource('author', AuthorController::class);
    });

    Route::name('publishCompanies')->group(function(){
        Route::get('publishCompany/{id}/books', [PublishCompanyController::class , 'books']);

        Route::get('publishcompanyfiltername/{name}/publishcompany' , [publishcompanyController::class , 'publishcompanyfiltername']);
        
        Route::resource('publishCompany', PublishCompanyController::class);      
    });

    Route::name('categories')->group(function(){
        Route::get('category/{id}/books', [CategoryController::class , 'books']);

        Route::get('categoryfiltername/{title}/category' , [categoryController::class , 'categoryfiltername']);

        Route::resource('category', CategoryController::class);  
    });     
});



