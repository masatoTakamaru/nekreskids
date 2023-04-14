<x-guest-layout>
  <article class="contents">
    <div class="contentsInner">
      <header>
        <h2>指導員ユーザー登録</h2>
        <h3>ステップ1</h3>
      </header>
      <div>
        @if(!empty($objData))
        <form action="/instructor/step1" method="post" enctype="multipart/form-data">
          @csrf
          <div class="editTableList">
            <label for="email" class="editLabel">メールアドレス</label>
            <input type="text" name="email" id="email" class="editInput" value="{{ old('email', $objData->email) }}">
            @error('email') <p class="alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="password" class="editLabel">パスワード</label>
            <input type="password" name="password" class="editInput" value="{{ old('password', $objData->password) }}">
            @error('password') <p class="alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="name" class="editLabel">氏名</label>
            <input type="text" name="name" class="editInput" value="{{ old('name', $objData->name) }}">
            @error('name') <p class="alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="name_kana" class="editLabel">氏名カナ</label>
            <input type="text" name="name_kana" class="editInput" value="{{ old('name_kana', $objData->name_kana) }}">
            @error('name_kana') <p class="alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="" class="editLabel">生年月日</label>
            <select class="editSelect" id="birth1"></select>
            <select class="editSelect" id="birth2"></select>
            <select class="editSelect" id="birth3"></select>
            <input type="hidden" name="birth" id="birth" value="{{ old('birth', $objData['birth']) }}">
          </div>
          <div>
            <span class="editLabel">性別</span>
            @foreach($genders as $key => $value)
            <input type="radio" name="gender" id="{{ $key }}" class="editRadio" value="{{ $key }}" @if(old('gender',
              $objData->gender)===$key) checked="checked" @endif>
            <label for="{{ $key }}" class="">{{ $value }}</label>
            @endforeach
            @error('gender') <p class="alert">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="avatar_preview" class="editLabel">アバター画像</label>
            <div id="avatar_preview"></div>
            <div id="avatar_upload">
              <input type="hidden" name="avatar" id="avatar" value="{{ old('avatar', $objData->avatar) }}">
              @error('avatar') <p class="alert">{{ $message }}</p> @enderror
            </div>
          </div>
          <div>
            <button type="submit" name="transit" class="editSubmit" value="step2">次に進む</button>
          </div>
          <input type="hidden" name="jsonData" value="{{ old('jsonData', $jsonData) }}">
        </form>
        @endif
      </div>
    </div>
  </article>
</x-guest-layout>
<script>
  setBirthday();
</script>
<script src="/asset/js/sendResizedImg.js"></script>
<script>
  setResizedImg();
</script>