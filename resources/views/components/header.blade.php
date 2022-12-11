<nav class="navbar navbar-expand-md navbar-light shadow-sm samuraimart-header-container">
   <div class="container">
     <!--ホームへのリンク　ロゴマーク貼り付けてる  -->
     <a class="navbar-brand" href="{{ url('/') }}">
       <img src="{{asset('img/logo.jpg')}}">
     </a>
     <form class="row g-1">
       <div class="col-auto">
         <!--検索のテキストエリア　form-control でテキスト入力エリアを作れる？  -->
         <input class="form-control samuraimart-header-search-input">
       </div>
       <div class="col-auto">
         <!--検索ボタン　submitのbtm　<i class=....はFont Awesome の機能　虫眼鏡アイコン  -->
         <button type="submit" class="btn samuraimart-header-search-button"><i class="fas fa-search samuraimart-header-search-icon"></i></button>
       </div>
     </form>
     <!-- toggler　折りたたまれた時のボタン　jqueryの機能？？？ -->
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
       <span class="navbar-toggler-icon"></span>
     </button>
 
     <div class="collapse navbar-collapse" id="navbarSupportedContent">
       <!-- Right Side Of Navbar　の装飾 -->
       <ul class="navbar-nav ms-auto mr-5 mt-2">
         <!-- Authentication Links -->
         <!--ログインしてない場合の処理,@auth-@endauthはログインしてるとき  -->
         @guest
         <!-- 各リンク設定　__()はlocalにある言語選択 -->
         <li class="nav-item mr-5">
           <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
         </li>
         <li class="nav-item mr-5">
           <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
         </li>
         <hr>
         <li class="nav-item mr-5">
           <a class="nav-link" href="{{ route('login') }}"><i class="far fa-heart"></i></a>
         </li>
         <li class="nav-item mr-5">
           <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-shopping-cart"></i></a>
         </li>
         <!-- ログイン済みの処理 -->
         @else
         <li class="nav-item mr-5">
            <!-- クリックしたら 'logout-form'取得して送信し-->
           <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
             ログアウト
           </a>
            <!-- "display: none;"で見せてない　<li>内でformでroute飛んでる　POSTしてるdocument.getElementById('logout-form')を
                上のリンククリックしたらsubmitする内容がこれ　 -->
           <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
             @csrf
           </form>
         </li>
         @endguest
       </ul>
     </div>
   </div>
 </nav>