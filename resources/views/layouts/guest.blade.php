<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="stylesheet" href="/asset/bootstrap-5.0.2-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/asset/css/common.css">
  <link rel="stylesheet" href="/asset/css/front.css">
  <script src="/asset/js/jquery-3.6.4.min.js"></script>
</head>

<body>
  <header class="app_header">
    <div>
      <a href="/">ネクレスキッズ</a>
    </div>
    <div>
      @auth
        <div>
          <div>
            {{ auth()->user()->email }}
          </div>
          <form action="/logout" method="post">
            @csrf
            <input type="submit" value="ログアウト">
          </form>
        </div>
      @endauth
      @guest
        <div>
          <a href="/login">ログイン</a>
        </div>
        <div>
          <a href="/select">新規ユーザー登録</a>
        </div>
      @endguest
    </div>
  </header>
  <main class="container">
    <main>
      {{ $slot }}
    </main>
  </main>
  <script src="/asset/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript"
    src="//jpostal-1006.appspot.com/jquery.jpostal.js"></script>
    <script src="/asset/js/common.js"></script>
    <script src="/asset/js/guest.js"></script>
</body>

</html>
