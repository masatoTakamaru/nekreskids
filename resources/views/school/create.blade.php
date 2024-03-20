<x-guest-layout>
  <article class="">
    <div class="">
      <header>
        <h2>学校ユーザー登録</h2>
      </header>
      <div>
        <form action="/school/create" method="post">
          @csrf

          <div>
            <label for="email" class="editLabel">メールアドレス</label>
            <input type="text" name="email" id="email" class="editInput"
              value="{{ old('email') }}">
            @error('email') <p class="edit__alert">{{ $message }}</p> @enderror
          </div>
          <div class="edit__item">
            <label for="password" class="editLabel">パスワード</label>
            <input type="password" name="password" id="password" class="editInput"
              value="{{ old('password') }}">
            @error('password') <p class="edit__alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="zip" class="">学校名</label>
            <input type="text" name="name" id="name" class=""
              placeholder="○○小学校" value="{{ old('name') }}">
            @error('zip') <p class="edit__alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="zip" class="">郵便番号</label>
            <input type="text" name="zip" id="zip" class=""
              placeholder="1638001" value="{{ old('zip') }}">
            @error('zip') <p class="edit__alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="" class="pref">都道府県</label>
            <input type="text" name="pref" id="pref" class=""
              placeholder="東京都" value="{{ old('pref') }}">
            @error('pref') <p class="edit__alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="" class="city">市区町村</label>
            <input type="text" name="city" id="city" class=""
              placeholder="新宿区" value="{{ old('city') }}">
            @error('city') <p class="edit__alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="address" class="">町域・番地・建物名など</label>
            <input type="text" name="address" id="address" class=""
              placeholder="西新宿２－８－１" value="{{ old('address') }}">
            @error('address') <p class="edit__alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="tel1" class="">電話番号１</label>
            <input type="text" name="tel1" class="" placeholder="08012345678"
              value="{{ old('tel1') }}">
            @error('tel1') <p class="edit__alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="tel2" class="">電話番号２</label>
            <input type="text" name="tel2" class="" placeholder="08012345678"
              value="{{ old('tel2') }}">
            @error('tel2') <p class="edit__alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="charge" class="">担当者名</label>
            <input type="text" name="charge" class="" placeholder=""
              value="{{ old('charge') }}">
            @error('charge') <p class="edit__alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <button type="submit" name="action" class=""
              value="draft">下書き保存</button>
            <button type="submit" name="transit" class=""
              value="confirm">次に進む</button>
          </div>
          <input type="hidden" name="jsonData"
            value="{{ old('jsonData', $jsonData) }}">
        </form>
      </div>
    </div>
  </article>
</x-guest-layout>
<script>
  togglePassIcon('password');
  setJpostal({
    zip: 'zip',
    pref: 'pref',
    city: 'city',
    address: 'address',
  });
</script>
