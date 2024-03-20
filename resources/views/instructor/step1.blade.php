<x-guest-layout>
  <article class="contents">
    <div class="contentsInner">
      <header>
        <h2>指導員ユーザー登録</h2>
        <h3>ステップ1</h3>
      </header>
      <div>
        <form action="/instructor/step1" method="post">
          @csrf

          <div>
            <label for="email" class="editLabel">メールアドレス</label>
            <input type="text" name="email" id="email" class="editInput"
              value="{{ old('email', $objData->email) }}">
            @error('email')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
            <label for="password" class="edit__label">パスワード</label>
            <input type="password" name="password" id="password"
              class="edit__input"
              value="{{ old('password', $objData->password) }}">
            @error('password')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="name" class="editLabel">氏名</label>
            <input type="text" name="name" class="editInput"
              value="{{ old('name', $objData->name) }}">
            @error('name')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="name_kana" class="editLabel">氏名カナ</label>
            <input type="text" name="name_kana" class="editInput"
              value="{{ old('name_kana', $objData->name_kana) }}">
            @error('name_kana')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="" class="editLabel">生年月日</label>
            <select class="editSelect" id="birth1"></select>
            <select class="editSelect" id="birth2"></select>
            <select class="editSelect" id="birth3"></select>
            <input type="hidden" name="birth" id="birth"
              value="{{ old('birth', $objData['birth']) }}">
          </div>
          <div>
            <span class="editLabel">性別</span>
            @foreach ($genders as $key => $value)
              <input type="radio" name="gender" id="{{ $key }}"
                class="editRadio" value="{{ $key }}"
                @if (old('gender', $objData->gender) === $key) checked="checked" @endif>
              <label for="{{ $key }}"
                class="">{{ $value }}</label>
            @endforeach
            @error('gender')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="avatar_preview" class="editLabel">アバター画像</label>
            <div id="avatar_preview"></div>
            @error('avatar_url')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
      </div>
      <div>
        <button type="submit" name="action" class=""
          value="draft">下書き保存</button>
        <button type="submit" name="transit" class="editSubmit"
          value="step2">次に進む</button>
      </div>
      <input type="hidden" name="jsonData"
        value="{{ old('jsonData', $jsonData) }}">
      </form>
    </div>
    </div>
  </article>
</x-guest-layout>
<script src="/asset/js/sendResizedImg.js"></script>
<script>
  togglePassIcon('password');
  setDate({
    yearId: 'birth1',
    monthId: 'birth2',
    dayId: 'birth3',
    dateId: 'birth',
  });
  const sri = new sendResizedImg('avatar_preview', 'avatar');
  sri.create({
    mode: "crop", //モード(nocrop|crop|original)
    preview: {
      maxWidth: 200, //プレビュー画像の最大幅
      maxHeight: 200, //プレビュー画像の最大高さ
      imgData: "{{ old('avatar', $objData->avatar) }}", //画像読み込み前の初期画像(ファイル名|base64文字列)
      //省略可。この場合デフォルト画像が表示される
    },
    send: {
      maxWidth: 200, //送信画像の最大幅
      maxHeight: 200, //送信画像の最大高さ
      format: "jpeg", //画像形式(jpeg|png)
      quality: 0.9, //画質(0.0～1.0)
    }
  });
</script>
