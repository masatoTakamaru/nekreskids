<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>指導員ユーザー登録</h2>
      </header>
      <div>
        <form action="/admin/instructor/create" method="post">
          @csrf
          <div class="edit__item">
            <label for="email" class="editLabel">メールアドレス</label>
            <input type="text" name="email" id="email" class="editInput"
              value="{{ old('email') }}">
            @error('email')
              <p class="alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
            <label for="password" class="edit__label">パスワード</label>
            <input type="password" name="password" id="password" class="edit__password"
              value="{{ old('password') }}">
            @error('password')
              <p class="alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
            <label for="name" class="editLabel">氏名</label>
            <input type="text" name="name" class="editInput"
              value="{{ old('name') }}">
            @error('name')
              <p class="alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
            <label for="name_kana" class="editLabel">氏名カナ</label>
            <input type="text" name="name_kana" class="editInput"
              value="{{ old('name_kana') }}">
            @error('name_kana')
              <p class="alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
            <label for="" class="editLabel">生年月日</label>
            <select class="editSelect" id="birth1"></select>
            <select class="editSelect" id="birth2"></select>
            <select class="editSelect" id="birth3"></select>
            <input type="hidden" name="birth" id="birth"
              value="{{ old('birth') }}">
          </div>
          <div class="edit__item">
            <span class="editLabel">性別</span>
            @foreach ($genders as $key => $value)
              <input type="radio" name="gender" id="{{ $key }}"
                class="editRadio" value="{{ $key }}"
                @checked(old('gender') === $key)>
              <label for="{{ $key }}"
                class="">{{ $value }}</label>
            @endforeach
            @error('gender')
              <p class="alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
            <label for="avatar_preview" class="editLabel">アバター画像</label>
            <div id="avatar_preview"></div>
            <div id="avatar_upload">
              <input type="hidden" name="avatar" id="avatar"
                value="{{ old('avatar') }}">
              @error('avatar')
                <p class="alert">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <div class="edit__item">
            <label for="zip" class="">郵便番号</label>
            <input type="text" name="zip" id="zip" class=""
              placeholder="1638001" value="{{ old('zip') }}">
            @error('zip')
              <p class="alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
            <label for="" class="pref">都道府県</label>
            <input type="text" name="pref" id="pref" class=""
              placeholder="東京都" value="{{ old('pref') }}">
            @error('pref')
              <p class="alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
            <label for="" class="city">市区町村</label>
            <input type="text" name="city" id="city" class=""
              placeholder="新宿区" value="{{ old('city') }}">
            @error('city')
              <p class="alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
            <label for="address" class="">町域・番地・建物名など</label>
            <input type="text" name="address" id="address" class=""
              placeholder="西新宿２－８－１" value="{{ old('address') }}">
            @error('address')
              <p class="alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
            <label for="tel" class="">電話番号</label>
            <input type="text" name="tel" class=""
              placeholder="08012345678" value="{{ old('tel') }}">
            @error('tel')
              <p class="alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
            <p class="edit__label">指導できる活動</p>
            <div class="edit__checkboxWrapper" id="edit__checkboxWrapper">
              @foreach ($arrActivities as $key => $value)
                <div class="edit__checkboxItem">
                  <input type="checkbox" name="activities[]" id="{{ $key }}"
                    class="edit__checkbox" value="{{ $key }}"
                    @checked(old('activities') === $key)>
                  <label for="{{ $key }}"
                    class="">{{ $value }}</label>
                </div>
              @endforeach
              @error('activities')
                <p class="alert">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <div class="edit__item">
            <label for="other_activities" class="edit__label">指導できる活動<br>（その他）</label>
            <input type="text" name="other_activities" class=""
              value="{{ old('other_activities') }}">
          </div>
          <div class="edit__item">
            <label for="ontime" class="edit__label">指導できる曜日<br>や時間帯</label>
            <input type="text" name="ontime" class=""
              placeholder="平日１７：００～１９：００など" value="{{ old('ontime') }}">
          </div>
          <div class="edit__item">
            <label for="actAreas" class="edit__label">指導できる地域</label>
            <div class="edit__actPrefCities" id="actAreas"></div>
            <div class="edit__icon">
              <div id="edit__iconPrefAdd" class="edit__icon square_plus"></div>
              <div id="edit__iconPrefRemove" class="edit__icon square_minus"></div>
            </div>
          </div>
          <div class="edit__item">
            <label for="cert" class="edit__label">所有資格</label>
            <input type="text" name="cert" class=""
              value="{{ old('cert') }}">
          </div>
          <div class="edit__item">
            <label for="pr" class="edit__label">自己紹介</label>
            <div>
              <textarea name="pr" class="pr__content" id="pr__content" cols="50"
                rows="10">{{ old('pr_content') }}</textarea>
              <p class="edit__prCount" id="pr__count"></p>
            </div>
          </div>
          <div>
            <button type="submit" class="edit__submit">登録する</button>
          </div>
        </form>
      </div>
    </div>
  </article>
</x-admin-layout>
<script src="/asset/js/sendResizedImg.js"></script>
<script>
  togglePassIcon('password');
  setDate({
    yearId: 'birth1',
    monthId: 'birth2',
    dayId: 'birth3',
    dateId: 'birth',
  });
  setResizedImg();
  setJpostal({
    zip: 'zip',
    pref: 'pref',
    city: 'city',
    address: 'address',
  });
  setActArea({
    'actAreas': <?php echo old('act_areas', $jsonActAreas); ?>,
    'prefs': <?php echo $jsonPrefs; ?>,
    'cities': <?php echo $jsonCities; ?>
  });
  setCounter({
    textArea: 'pr__content',
    count: 'pr__count',
    limit: 200,
  });
</script>
