<x-guest-layout>
  <article class="">
    <div class="">
      <header>
        <h2>指導員ユーザー登録情報の確認</h2>
      </header>
      <div>
        <div>
          <span class="">メールアドレス</span>
          <span class="">{{ $instructor['email'] }}</span>
        </div>
        <div>
          <span class="">パスワード</span>
          <span class="">{{ $instructor['password'] }}</span>
        </div>
        <div>
          <span class="">氏名</span>
          <span class="">{{ $instructor['name'] }}</span>
        </div>
        <div>
          <span class="">氏名カナ</span>
          <span class="">{{ $instructor['name_kana'] }}</span>
        </div>
        <div>
          <span class="">生年月日</span>
          <span class="">{{ $instructor['birth'] }}</span>
        </div>
        <div>
          <span class="">性別</span>
          <span class="">{{ $instructor['gender'] }}</span>
        </div>
        <div>
          <span class="">アバター画像</span>
          <span class="">{{ $instructor['avatar_url'] }}</span>
        </div>
        <form action="/instructor/confirm" method="post">
          @csrf
          <input type="hidden" name="data" value="{{ $data }}">
        </form>
      </div>
    </div>
  </article>
</x-guest-layout>