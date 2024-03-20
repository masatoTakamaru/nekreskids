<x-guest-layout>
  <article class="">
    <div class="">
      <header>
        <h2>学校ユーザー登録情報の確認</h2>
      </header>
      <div>
        <div class="detail__item">
          <span class="">メールアドレス</span>
          <span class="">{{ $objData->email }}</span>
        </div>
        <div class="detail__item">
          <span class="">問い合わせ内容</span>
          <span class="">{{ $objData->message }}</span>
        </div>
        <form action="/inquiry/confirm" method="post">
          @csrf
          <div>
            <button type="submit" name="transit" class=""
              value="create">前に戻る</button>
            <button type="submit" name="transit" class=""
              value="complete">登録する</button>
          </div>
          <input type="hidden" name="jsonData" value="{{ old('jsonData', $jsonData) }}">
        </form>
      </div>
    </div>
  </article>
</x-guest-layout>
