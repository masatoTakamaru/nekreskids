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
            <input type="text" name="zip" id="zip" class="" placeholder="1638001"
              value="{{ old('zip', $arrData['zip'])}}">
            @error('zip') <p class="alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="" class="pref">都道府県</label>
            <input type="text" name="pref" id="pref" class="" placeholder="東京都"
              value="{{ old('pref', $arrData['pref'])}}">
            @error('pref') <p class="alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="" class="city">市区町村</label>
            <input type="text" name="city" id="city" class="" placeholder="新宿区"
              value="{{ old('city', $arrData['city'])}}">
            @error('city') <p class="alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="address" class="">町域・番地・建物名など</label>
            <input type="text" name="address" id="address" class="" placeholder="西新宿２－８－１"
              value="{{ old('address', $arrData['address'])}}">
            @error('address') <p class="alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="tel" class="">電話番号</label>
            <input type="text" name="tel" class="" placeholder="08012345678"
              value="{{ old('tel', $arrData['tel'])}}">
            @error('tel') <p class="alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <button type="submit" name="transition" class="" value="prev">前に戻る</button>
            <button type="submit" name="transition" class="" value="next">次に進む</button>
          </div>
          <input type="hidden" name="jsonData" value="{{ old('jsonData', $jsonData) }}">
        </form>
      </div>
    </div>
  </article>
</x-guest-layout>
<script type="text/javascript" src="//jpostal-1006.appspot.com/jquery.jpostal.js"></script>
<script>
  $(window).on('load', ()=> {
    $('#zip').jpostal({
      postcode : ['#zip'],
      address : {'#pref' : '%3', "#city" : '%4', '#address' : '%5'}
    });
  });
</script>