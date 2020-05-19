<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


//隐式路由绑定
Route::get('/userinfo/{user_info}',function (\App\Models\user_info $user_info){
    dd($user_info);
});

//频率限制
Route::middleware('throttle:rate_limit,1')->group(function (){
    Route::get('/user_info', function () {

        return '789465465';
        // 在 user_info 模型中设置自定义的 rate_limit 属性值
    });
});


//csrf验证
Route::get('task/{id}/delete', function ($id) {
    return '<form method="post" action="' . route('task.delete', [$id]) . '">
                <input type="hidden" name="_method" value="DELETE"> 
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <button type="submit">删除任务</button>
            </form>';
});

Route::delete('task/{id}', function ($id) {
    return 'Delete Task ' . $id;
})->name('task.delete');


Route::get('show',function (){

    return view('show');
});