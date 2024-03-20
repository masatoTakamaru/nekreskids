<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>学校ユーザー登録</h2>
      </header>
      <div>
        <form action="/admin/school/create" method="post">
          @csrf
          <div>
            <label for="email" class="edit__label">メールアドレス</label>
            <input type="text" name="email" id="email" class="edit__input"
              value="{{ old('email') }}">
            @error('email')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
            <label for="password" class="edit__label">パスワード</label>
            <input type="password" name="password" id="password"
              class="edit__input" value="{{ old('password') }}">
            @error('password')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="name" class="edit__label">学校名</label>
            <input type="text" name="name" id="name"
              class="edit__input" placeholder="○○小学校"
              value="{{ old('name') }}">
            @error('zip')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="zip" class="edit__label">郵便番号</label>
            <input type="text" name="zip" id="zip"
              class="edit__input" placeholder="1638001"
              value="{{ old('zip') }}">
            @error('zip')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="pref" class="edit__label">都道府県</label>
            <select name="pref" id="pref" class="edit__select">
              @foreach ($arrPref as $key => $value)
                <option value="{{ $key }}"
                  @selected(old('pref') === $key)>
                  {{ $value }}
                </option>
              @endforeach
            </select>
          </div>
          <div>
            <label for="city" class="edit__label">市区町村</label>
            <select name="city" id="city" class="edit__select">
              <option value="">未選択</option>
            </select>
          </div>
          <div>
            <label for="address" class="edit__label">町域・番地・建物名など</label>
            <input type="text" name="address" id="address"
              class="edit__input" placeholder="西新宿２－８－１"
              value="{{ old('address') }}">
            @error('address')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="tel1" class="edit__label">電話番号１</label>
            <input type="text" name="tel1" class="edit__input"
              placeholder="08012345678" value="{{ old('tel1') }}">
            @error('tel1')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="tel2" class="edit__label">電話番号２</label>
            <input type="text" name="tel2" class="edit__input"
              placeholder="08012345678" value="{{ old('tel2') }}">
            @error('tel2')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="charge" class="edit__label">担当者名</label>
            <input type="text" name="charge" class="edit__input"
              placeholder="" value="{{ old('charge') }}">
            @error('charge')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="status" class="edit__label">ステータス</label>
            <select name="status" class="edit__select">
              @foreach ($status as $key => $value)
                <option class="edit__option" value="{{ $key }}"
                  @selected(old('status') === $key)>
                  {{ $value }}</option>
              @endforeach
            </select>
            @error('charge')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <button type="submit" class="edit__submit">登録する</button>
          </div>
        </form>
      </div>
    </div>
  </article>
</x-admin-layout>
<script>
  togglePassIcon('password');
  setPrefToCity({
    pref: 'pref',
    city: 'city',
    arrCity: @json($arrCity)
  });
</script>
