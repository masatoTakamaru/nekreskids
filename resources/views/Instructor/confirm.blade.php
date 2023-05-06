<x-guest-layout>
  <article class="">
    <div class="">
      <header>
        <h2>指導員ユーザー登録情報の確認</h2>
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
          <span class="">氏名</span>
          <span class="">{{ $objData->name }}</span>
        </div>
        <div class="detail__item">
          <span class="">氏名カナ</span>
          <span class="">{{ $objData->name_kana }}</span>
        </div>
        <div class="detail__item">
          <span class="">生年月日</span>
          <span class="">{{ $objData->birth }}</span>
        </div>
        <div class="detail__item">
          <span class="">性別</span>
          <span class="">{{ $objData->gender }}</span>
        </div>
        <div class="detail__item">
          <span class="">アバター画像</span>
          <img src="{{ $objData->avatar }}">
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
          <span class="">電話番号</span>
          <span class="">{{ $objData->tel }}</span>
        </div>
        <div class="detail__item">
          <span class="">指導できる活動</span>
          <span class="">{{ $objData->activities }}</span>
        </div>
        <div class="detail__item">
          <span class="">指導できる活動<br>（その他）</span>
          <span class="">{{ $objData->other_activities }}</span>
        </div>
        <div class="detail__item">
          <span class="">指導できる曜日<br>や時間帯</span>
          <span class="">{{ $objData->ontime }}</span>
        </div>
        <div class="detail__item">
          <span class="">指導できる地域</span>
          <span class="">{!! $objData->act_areas !!}</span>
        </div>
        <div class="detail__item">
          <span class="">所有資格</span>
          <span class="">{{ $objData->cert }}</span>
        </div>
        <div class="detail__item">
          <span class="">自己紹介</span>
          <span class="">{{ $objData->pr }}</span>
        </div>
        <form action="/instructor/confirm" method="post">
          @csrf
          <div>
            <button type="submit" name="action" class=""
              value="draft">下書き保存</button>
            <button type="submit" name="transit" class=""
              value="step3">前に戻る</button>
            <button type="submit" name="transit" class=""
              value="complete">登録する</button>
          </div>
          <input type="hidden" name="jsonData" value="{{ old('jsonData', $jsonData) }}">
        </form>
      </div>
    </div>
  </article>
</x-guest-layout>
