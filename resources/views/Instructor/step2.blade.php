<x-guest-layout>
  <article class="">
    <div class="">
      <header>
        <h2>指導員ユーザー登録</h2>
        <h3>ステップ2</h3>
      </header>
      <div>
        <form action="/instructor/step2" method="post">
          @csrf
          <div>
            <label for="zip" class="">郵便番号</label>
            <input type="text" name="zip" class="" placeholder="1638001" value="{{ old('zip', $instructor['zip'])}}">
          </div>
          <div>
            <label for="" class="pref">都道府県</label>
            <input type="text" name="pref" class="" placeholder="東京都">
          </div>
          <div>
            <label for="" class="city">市区町村</label>
            <input type="text" name="city" class="" placeholder="新宿区">
          </div>
          <div>
            <label for="address" class="">町域・番地・建物名など</label>
            <input type="text" name="address" class="" placeholder="西新宿２－８－１">
          </div>
          <div>
            <label for="tel" class="">電話番号</label>
            <input type="text" name="tel" class="" placeholder="08012345678">
          </div>
          <div>
            <button type="submit" name="transition" class="" value="back">前に戻る</button>
            <button type="submit" name="transition" class="" value="forward">次に進む</button>
          </div>
          <input type="hidden" name="jsonData" value="{{ old('jsonData', $jsonData) }}">
        </form>
      </div>
    </div>
  </article>
</x-guest-layout>