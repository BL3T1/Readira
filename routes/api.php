<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Books\BookController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\User\CommentsController;
use App\Http\Controllers\Admin\ProgressController;
use App\Http\Controllers\User\CollectionController;
use App\Http\Controllers\Google\GoogleDriveController;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::post('add', [\App\Http\Controllers\CoolController::class, 'add']);

Route::group([
    'middleware'=>['api'],
    'prefix'=>'auth',
],function($router){
Route::post('/register',[AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::post('/verifyUserEmail', [AuthController::class,'verifyUserEmail']);
Route::post('/resendEmailVerficationLink', [AuthController::class,'resendEmailVerficationLink']);
Route::post('/logout',[AuthController::class,'logout']);
Route::get('/userProfile',[AuthController::class,'userProfile']);
Route::post('/resetPassword',[AuthController::class,'resetPassword']);

});

Route::middleware(['jwtVerfiy'])->group(function(){

 Route::post('/blockUser',[AuthController::class,'blockUser'])->middleware('Admin');
 Route::get('/findUser',[AuthController::class,'findUser']);



});

Route::middleware(['changeLang', 'jwtVerfiy'])
    -> group(function (){
        Route::prefix('book')
            -> group(function (){
                Route::post('add', [BookController::class, 'add']);
                Route::delete('delete', [BookController::class, 'delete']);
                Route::post('update', [BookController::class, 'update']);
                Route::get('get_all_books', [BookController::class, 'getAllBooks']);
                Route::post('rateBook', [BookController::class, 'rateBook']);
                Route::get('get_book', [BookController::class, 'getBook']);
                Route::post('search', [BookController::class, 'searchForBook']);
                Route::get('findFavorite', [BookController::class, 'findFavorite']);
                Route::get('buy_book', [BookController::class, 'buyBook']);
                Route::get('show_category', [BookController::class, 'showCategory']);
                Route::get('show_categories', [BookController::class, 'showCategories']);
                Route::get('topten', [BookController::class, 'topTen']);
            });
        Route::prefix('admin')
            -> group(function (){
                Route::prefix('progress')
                    -> group(function (){
                        Route::post('start_read', [ProgressController::class, 'startRead']);
                        Route::post('end_read', [ProgressController::class, 'endRead']);
                        Route::get('show_progresses', [ProgressController::class, 'showProgresses']);
                        Route::get('show_user_progress', [ProgressController::class, 'showUserProgress']);
                        Route::get('predict_progress', [ProgressController::class, 'predictProgress']);
                        Route::get('get_reports', [ReportController::class, 'getReport']);
                        Route::get('get_report', [ReportController::class, 'getReports']);
                        Route::delete('delete_reports', [ReportController::class, 'delete']);
                        Route::get('show_user_current_book', [ProgressController::class, 'showProgressForUser']);
                        Route::get('show_book_progress', [ProgressController::class, 'showProgressForBook']);
                        Route::get('predict_progress', [ProgressController::class, 'predictProgress']);
                        Route::post('add_book_mark', [ProgressController::class, 'addBookMark']);
                        Route::post('show_book_mark', [ProgressController::class, 'showBookMark']);
                        Route::post('get_book_marks', [ProgressController::class, 'getBookMarks']);
                        Route::delete('delete_book_mark', [ProgressController::class, 'removeBookMark']);
                    });
                Route::post('add_to_wallet', [ProgressController::class, 'addToWallet'])->middleware('admin');
                Route::resource('upload', GoogleDriveController::class);
            });
        Route::prefix('user')
            -> group(function (){
                Route::prefix('comment')
                    -> group(function (){
                        Route::post('report', [ReportController::class, 'report']);
                        Route::post('comment', [CommentsController::class, 'comment']);
                        Route::post('like', [CommentsController::class, 'like']);
                        Route::delete('delete', [CommentsController::class, 'delete']);//for jenny and aous
                        Route::post('reply', [CommentsController::class, 'reply']);
                        Route::post('update', [CommentsController::class, 'update']);
                        Route::get('get_comments', [CommentsController::class, 'getComments']);

                    });
                Route::prefix('collection')
                    -> group(function (){
                        Route::post('make_collection', [CollectionController::class, 'makeCollection']);
                        Route::post('add_to_collection', [CollectionController::class, 'addToCollection']);
                        Route::get('get_collections', [CollectionController::class, 'getCollections']);
                        Route::get('get_collection_content', [CollectionController::class, 'getCollectionContent']);
                        Route::delete('remove_from_collection', [CollectionController::class, 'removeFromCollection']);
                        Route::delete('remove_collection', [CollectionController::class, 'removeCollection']);
                    });
                Route::prefix('favorite')
                    -> group(function (){
                        Route::post('add_to_favorite',[CollectionController::class, 'addToFavorite']);
                        Route::get('get_favorite',[CollectionController::class, 'getFavorite']);
                        Route::delete('remove_from_favorite',[CollectionController::class, 'removeFromFavorite']);
                    });
            });
    });
