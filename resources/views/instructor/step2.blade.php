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
            <label for="zip" class="edit__label">郵便番号</label>
            <input type="text" name="zip" id="zip" class=""
              placeholder="1638001" value="{{ old('zip', $objData->zip) }}">
            @error('zip')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="pref" class="edit__label">都道府県</label>
            <select name="pref" id="pref" class="edit__select"></select>
            @error('pref')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="city" class="edit__label">市区町村</label>
            <select name="city" id="city" class="edit__select"></select>
            @error('city')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="address" class="edit__label">町域・番地・建物名など</label>
            <input type="text" name="address" id="address" class=""
              placeholder="西新宿２－８－１" value="{{ old('address', $objData->address) }}">
            @error('address')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="tel" class="edit__label">電話番号</label>
            <input type="text" name="tel" class="" placeholder="08012345678"
              value="{{ old('tel', $objData->tel) }}">
            @error('tel')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <button type="submit" name="action" class=""
              value="draft">下書き保存</button>
            <button type="submit" name="transit" class=""
              value="step1">前に戻る</button>
            <button type="submit" name="transit" class=""
              value="step3">次に進む</button>
          </div>

          <input type="hidden" name="jsonData" value="{{ old('jsonData', $jsonData) }}">
        </form>
      </div>
    </div>
  </article>
</x-guest-layout>
<script>
  setPrefCity({
    prefElem: 'pref',
    cityElem: 'city',
    defaultPref: '{{ old('pref', $objData->pref) }}',
    defaultCity: '{{ old('city', $objData->city) }}',
    arrPref: @json($jsonPref),
    arrCity: @json($jsonCity)
  });
</script>
