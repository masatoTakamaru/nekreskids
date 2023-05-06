<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

/**
 *  -------------------- ルーティングの説明 --------------------
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
 *  3階層   例  /dir/company/user-delete
 *      コントローラー：Dir/CompanyController
 *      メソッド：user_delete
 *      3階層構成の場合は第1階層がディレクトリ名となる
 * 
 * 認証が必要なページについて
 * 
 * 例えば認証が必要なページをadminディレクトリ配下に置く場合、admin
 * の1つ下の階層を1階層とする。
 * 
 *  ----------------------------------------------------------
 */

$authDir = 'admin';     //認証が必要なディレクトリ

$branchTunnel = function (Request $request) use ($authDir) {
    $arrUrl = explode('?', request()->getRequestUri());
    $arrUrl = explode('/', $arrUrl[0]);
    $action = 'index';
    $path = 'App\Http\Controllers\\';

    if (!empty($arrUrl[1]) && $arrUrl[1] === $authDir) {
        array_shift($arrUrl);
        $path = 'App\Http\Controllers\\' . Str::studly($authDir) . '\\';
    }

    switch (true) {
        case empty($arrUrl[1]):
            //0階層構成
            $path .= 'IndexController';
            break;
        case !empty($arrUrl[1]) && empty($arrUrl[2]):
            //1階層構成
            $path .= Str::studly($arrUrl[1]) . 'Controller';
            break;
        case !empty($arrUrl[2]) && empty($arrUrl[3]):
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

    return app()->call("$path@$action");
};

require __DIR__ . '/auth.php';

Route::prefix($authDir)->middleware('auth')
    ->group(function () use ($branchTunnel) {

        Route::any('/{url}', $branchTunnel)->where('url', '.*');

        return;
    });

Route::any('/{url}', $branchTunnel)->where('url', '.*');
