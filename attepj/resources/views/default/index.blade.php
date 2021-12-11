<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{asset('css/reset.css')}}">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <link rel="stylesheet" href="{{asset('css/index.css')}}">
  @stack('css')
  <title>@yield('title')</title>
</head>
<body>
  <header>
    <div class="header__item">
      <h1 class="header__title">Atte</h1>
      <nav class="nav__pc">
        <ul class="nav__pc__item">
          <li class="nav__pc__list"><a href="/">ホーム</a></li>
          <li class="nav__pc__list"><a href="/attendance">日付一覧</a></li>
          <li class="nav__pc__list"><a href="/logout">ログアウト</a></li>
        </ul>
      </nav>
      <div class="menu" id="menu">
        <span class="menu__top"></span>
        <span class="menu__middle"></span>
        <span class="menu__bottom"></span>
      </div>
      <nav class="nav__sp" id="nav">
        <ul class="nav__sp__list">
          <li><a href="/">ホーム</a></li>
          <li><a href="/attendance">日付一覧</a></li>
          <li><a href="/logout">ログアウト</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <main class="main">
    @yield('content')
  </main>
  <footer>
    <small class="small">Atte, inc.</small>
  </footer>
  <script src="{{asset('js/index.js')}}"></script>
  @stack('js')
</body>
</html>