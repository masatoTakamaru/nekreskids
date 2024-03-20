<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>学校ユーザー編集</h2>
      </header>
      <div>
        <form action="/admin/school/edit?id={{ $objData->user_id }}" method="post">
          @method('patch')
          @csrf
          <div>
            <label for="email" class="edit__label">メールアドレス</label>
            <input type="text" name="email" id="email" class="edit__input"
              value="{{ old('email', $objData->email) }}">
            @error('email') <p class="edit__alert">{{ $message }}</p> @enderror
          </div>
          <div class="edit__item">
            <label for="password" class="edit__label">パスワード</label>
            <input type="password" name="password" id="password" class="edit__input"
              value="" disabled>
            @error('password') <p class="edit__alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="name" class="edit__label">学校名</label>
            <input type="text" name="name" id="name" class=""
              placeholder="○○小学校" value="{{ old('name', $objData->name) }}">
            @error('zip') <p class="edit__alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="zip" class="edit__label">郵便番号</label>
            <input type="text" name="zip" id="zip" class=""
              placeholder="1638001" value="{{ old('zip', $objData->zip) }}">
            @error('zip') <p class="edit__alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="pref" class="edit__label">都道府県</label>
            <input type="text" name="pref" id="pref" class=""
              placeholder="東京都" value="{{ old('pref', $objData->pref) }}">
            @error('pref') <p class="edit__alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="city" class="edit__label">市区町村</label>
            <input type="text" name="city" id="city" class=""
              placeholder="新宿区" value="{{ old('city', $objData->city) }}">
            @error('city') <p class="edit__alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="address" class="edit__label">町域・番地・建物名など</label>
            <input type="text" name="address" id="address" class=""
              placeholder="西新宿２－８－１" value="{{ old('address', $objData->address) }}">
            @error('address') <p class="edit__alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="tel1" class="edit__label">電話番号１</label>
            <input type="text" name="tel1" class="" placeholder="08012345678"
              value="{{ old('tel1', $objData->tel1) }}">
            @error('tel1') <p class="edit__alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="tel2" class="edit__label">電話番号２</label>
            <input type="text" name="tel2" class="" placeholder="08012345678"
              value="{{ old('tel2', $objData->tel2) }}">
            @error('tel2') <p class="edit__alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="charge" class="edit__label">担当者名</label>
            <input type="text" name="charge" class="" placeholder=""
              value="{{ old('charge', $objData->charge) }}">
            @error('charge') <p class="edit__alert">{{ $message }}</p> @enderror
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
  editPassword('password');
  setJpostal({
    zip: 'zip',
    pref: 'pref',
    city: 'city',
    address: 'address',
  });
</script>
