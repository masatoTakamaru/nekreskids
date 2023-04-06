<x-guest-layout>
  <article class="">
    <div class="">
      <header>
        <h2>指導員ユーザー登録</h2>
        <h3>ステップ3</h3>
      </header>
      <div>
        <form action="/instructor/step3" method="post">
          @csrf
          <div>
            <label for="" class="">指導できる活動</label>
            <input type="text" name="" class="">
          </div>
          <div>
            <label for="" class="">指導できる活動（その他）</label>
            <input type="text" name="" class="">
          </div>
          <div>
            <label for="" class="">指導できる時間帯</label>
            <input type="text" name="" class="">
          </div>
          <div>
            <label for="" class="">指導できる都道府県</label>
            <input type="text" name="" class="">
          </div>
          <div>
            <label for="" class="">指導できる市区町村</label>
            <input type="text" name="" class="">
          </div>
          <div>
            <label for="" class="">所有資格</label>
            <input type="text" name="" class="">
          </div>
          <div>
            <label for="" class="">自己紹介</label>
            <input type="file" name="" class="">
          </div>
          <div>
            <button type="submit" name="transition" class="" value="back">前に戻る</button>
            <button type="submit" name="transition" class="" value="confirm">確認画面へ</button>
          </div>
          <input type="hidden" name="jsonData" value="{{ old('jsonData', $jsonData) }}">
        </form>
      </div>
    </div>
  </article>
</x-guest-layout>