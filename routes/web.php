<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 *  ■□■□■□■□■□■□ ルーティング ■□■□■□■□■□■□ 
 *  ＊対応は3階層まで
 *  ＊ルーティングにアンダーバーは使わない。ハイフンかつ英数小文字で
 *  0階層   /
 *      コントローラー：IndexController
 *      メソッド：index
 *  1階層   例  /about-us
 *      コントローラー：AboutUsController
 *      メソッド：index
 *  2階層   例  /user/create
 *      コントローラー：UserController
 *      メソッド：create
 *  3階層   例  /admin/company/user-delete
 *      コントローラー：Admin/CompanyController
 *      メソッド：user_delete
 *      3階層構成の場合は第1階層がディレクトリ名となる
 * 
 * ■□■□■□■□■□■□■□■□■□■□■■□■□■□■□■□■□■□■□■
 */

Route::any('/{url}', function () {
    $arrUrl = explode('/', request()->getRequestUri());
    $action = 'index';
    $path = 'App\Http\Controllers\\';

    //middlewareが必要な項目はここで除外
    if ($arrUrl[1] === 'user' || $arrUrl[1] === 'admin') return;
    //ここまで

    switch (true) {
        case empty($arrUrl[1]):
            //0階層構成
            $path .= 'IndexController';
            break;
        case !empty($arrUrl[1]) && empty($arrUrl[2]):
            //1階層構成
            $path .= $arrUrl[1] . 'Controller';
            break;
        case !empty($arrUrl[2]):
            //2階層構成
            $path .= Str::studly($arrUrl[1]) . 'Controller';
            $action = Str::replace('-', '_', $arrUrl[2]);
            break;
        case !empty($arrUrl[3]) && empty($arrUrl[4]):
            //3階層構成
            $path .= Str::studly($arrUrl[1]) . '\\' . Str::studly($arrUrl[2]) . 'Controller';
            $action = Str::replace('-', '_', $arrUrl[3]);
            break;
        default:
            abort(404);
            break;
    }

    return app()->call($path . '@' . $action);
})->where('url', '.*');

require __DIR__ . '/auth.php';
