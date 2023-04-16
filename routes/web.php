<?php

use Illuminate\Http\Request;
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
 *  3階層   例  /admin/company/delete
 *      コントローラー：Admin/CompanyController
 *      メソッド：delete
 *      3階層構成の場合は第1階層がディレクトリ名となる
 * 
 * ■□■□■□■□■□■□■□■□■□■□■■□■□■□■□■□■□■□■□■
 */

//初期値
$uri = Request::capture()->path();
$arrUrl = explode('/', $uri);
$action = 'index';
$path = 'App\Http\Controllers\\';

//ミドルウェアauthが必要なディレクトリの処理
if ($arrUrl[0] === 'user' || $arrUrl[0] === 'admin') {
}

switch (true) {
    case empty($arrUrl[0]):
        //0階層構成
        $url = '';
        $path .= 'IndexController'::class;
        break;
    case !empty($arrUrl[0]) && empty($arrUrl[1]):
        //1階層構成
        $url = $arrUrl[0];
        $path .= $arrUrl[0] . 'Controller'::class;
        break;
    case !empty($arrUrl[1]):
        //2階層構成
        $url = $arrUrl[0] . '/' . $arrUrl[1];
        $path .= Str::studly($arrUrl[0]) . 'Controller'::class;
        $action = $arrUrl[1];
        break;
    case !empty($arrUrl[2]) && empty($arrUrl[3]):
        //3階層構成
        $url = $arrUrl[0] . '/' . $arrUrl[1] . '/' . $arrUrl[2];
        $path .= Str::studly($arrUrl[0]) . '\\' . Str::studly($arrUrl[1]) . 'Controller'::class;
        $action = $arrUrl[2];
        break;
    default:
        abort(404);
        break;
}

Route::any("/{$url}", [$path, $action]);

require __DIR__ . '/auth.php';
