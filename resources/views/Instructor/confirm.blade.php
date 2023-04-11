<x-guest-layout>
  <article class="">
    <div class="">
      <header>
        <h2>指導員ユーザー登録情報の確認</h2>
      </header>
      <div>
        <div>
          <span class="">メールアドレス</span>
          <span class="">{{ $objData['email'] }}</span>
        </div>
        <div>
          <span class="">パスワード</span>
          <span class="">{{ $objData['password'] }}</span>
        </div>
        <div>
          <span class="">氏名</span>
          <span class="">{{ $objData['name'] }}</span>
        </div>
        <div>
          <span class="">氏名カナ</span>
          <span class="">{{ $objData['name_kana'] }}</span>
        </div>
        <div>
          <span class="">生年月日</span>
          <span class="">{{ $objData['birth'] }}</span>
        </div>
        <div>
          <span class="">性別</span>
          <span class="">{{ $objData['gender'] }}</span>
        </div>
        <div>
          <span class="">アバター画像</span>
          <span class="">{{ $objData['avatar_url'] }}</span>
        </div>
        <form action="/instructor/confirm" method="post">
          @csrf
          <input type="hidden" name="jsonData" value="{{ $jsonData }}">
        </form>
      </div>
    </div>
  </article>
</x-guest-layout>