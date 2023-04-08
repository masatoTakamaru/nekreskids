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
            <p for="" class="">指導できる活動</p>
            <div class="actWrapper" id="actWrapper">
              @foreach($arrActivities as $key => $value)
              <input type="checkbox" name="activities[]" id="{{ $key }}" class="edit__checkbox" value="{{ $key }}"
                @if(old('activities', $objData['activities'])===$key) checked="checked" @endif>
              <label for="{{ $key }}" class="">{{ $value }}</label>
              @endforeach
              @error('activities') <p class="alert">{{ $message }}</p> @enderror
            </div>
          </div>
          <div>
            <label for="" class="">指導できる活動（その他）</label>
            <input type="text" name="" class="">
          </div>
          <div>
            <label for="" class="">指導できる時間帯</label>
            <input type="text" name="" class="" placeholder="平日１７：００～１９：００など">
          </div>
          <div>
            <p class="">指導できる都道府県</p>
            <div class="accordion__container">
              @foreach($arrAreas as $areaKey => $areaValue)
              <div class="accordion__title js-accordion-title">{{ $areaValue }}</div>
              <div class="accordion__content">
                @foreach($arrPrefs[$areaKey] as $prefKey => $prefValue)
                <div class="accordion__title accordion-pref js-accordion-title">{{ $prefValue }}</div>
                <div class="accordion__content accordion-city">
                  @foreach($arrCities[$prefKey] as $cityKey => $cityValue)
                  <input id="{{ $prefKey . $cityKey }}" type="checkbox"
                    class="accordon__content-item" value="{{ $cityKey }}">
                  <label for="{{ $prefKey . $cityKey }}">{{ $cityValue }}</label>
                  @endforeach
                </div>
                @endforeach
              </div>
              @endforeach
            </div>
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
            <button type="submit" name="transition" class="" value="prev">前に戻る</button>
            <button type="submit" name="transition" class="" value="confirm">確認画面へ</button>
          </div>
          <input type="hidden" name="jsonData" value="{{ old('jsonData', $jsonData) }}">
        </form>
      </div>
    </div>
  </article>
</x-guest-layout>