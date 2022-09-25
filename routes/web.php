<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//認証機能
Auth::routes();

//ページ認証機能
Route::group(['middleware' => 'auth'], function () {

    //ホームページ
    Route::get('/', [HomeController::class, 'index'])->name('home');

    //フォルダ作成ページ
    //フォルダ作成処理
    Route::get('/folders/create', [FolderController::class, 'showCreateForm'])->name('folders.create');
    Route::post('/folders/create', [FolderController::class, 'create']);

    //認可機能
    Route::group(['middleware' => 'can:view,folder'], function () {

        //フォルダ/タスク一覧ページ表示
        Route::get('/folders/{folder}/tasks', [TaskController::class, 'index'])->name('tasks.index');

        //タスク作成ページ表示
        //タスク作成処理
        Route::get('/folders/{folder}/tasks/create', [TaskController::class, 'showCreateForm'])->name('tasks.create');
        Route::post('/folders/{folder}/tasks/create', [TaskController::class, 'create']);

        //タスク編集ページ表示
        //タスク編集機能
        Route::get('/folders/{folder}/tasks/{task}/edit', [TaskController::class, 'showEditForm'])->name('tasks.edit');
        Route::post('/folders/{folder}/tasks/{task}/edit', [TaskController::class, 'edit']);
    });
});
