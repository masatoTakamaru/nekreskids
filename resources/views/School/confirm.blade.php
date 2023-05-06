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
          <span class="">パスワード</span>
          <span class="">セキュリティーのため非表示</span>
        </div>
        <div class="detail__item">
          <span class="">学校名</span>
          <span class="">{{ $objData->name }}</span>
        </div>
        <div class="detail__item">
          <span class="">郵便番号</span>
          <span class="">{{ $objData->zip }}</span>
        </div>
        <div class="detail__item">
          <span class="">住所</span>
          <span class="">{{ $objData->address }}</span>
        </div>
        <div class="detail__item">
          <span class="">電話番号１</span>
          <span class="">{{ $objData->tel1 }}</span>
        </div>
        <div class="detail__item">
          <span class="">電話番号２</span>
          <span class="">{{ $objData->tel2 }}</span>
        </div>
        <div class="detail__item">
          <span class="">担当者名</span>
          <span class="">{{ $objData->charge }}</span>
        </div>
        <form action="/school/confirm" method="post">
          @csrf
          <div>
            <button type="submit" name="action" class=""
              value="draft">下書き保存</button>
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
