<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>指導員ユーザー編集</h2>
      </header>
      <div>
        <form action="/admin/instructor/edit?id={{ $objData->id }}"
          method="post">
          @method('patch')
          @csrf

          <div class="edit__item">
            <label for="email" class="edit__label">メールアドレス</label>
            <input type="text" name="email" id="email" class="editInput"
              value="{{ old('email', $objData->email) }}">
            @error('email')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
            <label for="password" class="edit__label">パスワード</label>
            <input type="password" name="password" id="password"
              class="edit__input" value="" disabled>
            @error('password')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
            <label for="name" class="edit__label">氏名</label>
            <input type="text" name="name" class="editInput"
              value="{{ old('name', $objData->name) }}">
            @error('name')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
            <label for="name_kana" class="edit__label">氏名カナ</label>
            <input type="text" name="name_kana" class="editInput"
              value="{{ old('name_kana', $objData->name_kana) }}">
            @error('name_kana')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
            <label for="" class="edit__label">生年月日</label>
            <select class="editSelect" id="birth1"></select>
            <select class="editSelect" id="birth2"></select>
            <select class="editSelect" id="birth3"></select>
            <input type="hidden" name="birth" id="birth"
              value="{{ old('birth', $objData->birth) }}">
          </div>
          <div class="edit__item">
            <span class="edit__label">性別</span>
            @foreach ($arrGender as $key => $value)
              <input type="radio" name="gender" id="{{ $key }}"
                class="editRadio" value="{{ $key }}"
                @checked(old('gender', $objData->gender) === $key)>
              <label for="{{ $key }}"
                class="">{{ $value }}</label>
            @endforeach
            @error('gender')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
            <label for="avatar_preview" class="edit__label">アバター画像</label>
            <div id="avatar_preview"></div>
            @error('avatar_url')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
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
          </div>
          <div>
            <label for="city" class="edit__label">市区町村</label>
            <select name="city" id="city" class="edit__select"></select>
          </div>
          <div class="edit__item">
            <label for="address" class="edit__label">町域・番地・建物名など</label>
            <input type="text" name="address" id="address" class=""
              placeholder="西新宿２－８－１"
              value="{{ old('address', $objData->address) }}">
            @error('address')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
            <label for="tel" class="edit__label">電話番号</label>
            <input type="text" name="tel" class=""
              placeholder="08012345678"
              value="{{ old('tel', $objData->tel) }}">
            @error('tel')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>

          <div class="edit__item">
            <span class="edit__label">指導できる活動</span>
            <div class="edit__checkboxWrapper" id="checkboxWrapper">
              <div class="edit__checkbox">
                @foreach ($arrActivities as $key => $value)
                  <div class="edit__checkboxItem">
                    <input type="checkbox" name="activities[]"
                      id="{{ $key }}" class="edit__checkbox"
                      value="{{ $key }}"
                      @checked(old('activities') === $key || in_array($key, $objData->activities))>
                    <label for="{{ $key }}"
                      class="">{{ $value }}</label>
                  </div>
                @endforeach
              </div>
              @error('activities')
                <p class="edit__alert">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div class="edit__item">
            <label for="other_activities"
              class="edit__label">指導できる活動<br>（その他）</label>
            <input type="text" name="other_activities" class=""
              value="{{ old('other_activities', $objData->other_activities) }}">
          </div>
          <div class="edit__item">
            <label for="ontime" class="edit__label">指導できる曜日<br>や時間帯</label>
            <input type="text" name="ontime" class=""
              placeholder="平日１７：００～１９：００など"
              value="{{ old('ontime', $objData->ontime) }}">
          </div>
          <div class="edit__item">
            <label for="actAreas" class="edit__label">指導できる地域</label>
            <div class="edit__actPrefCities" id="actAreas">
              @for ($i = 1; $i <= 5; $i++)
                <div>
                  <select id="pref{{ $i }}"
                    name="act_areas[{{ $i }}][pref]"></select>
                  <select id="city{{ $i }}"
                    name="act_areas[{{ $i }}][city]"></select>
                </div>
              @endfor
            </div>
          </div>
          <div class="edit__item">
            <label for="cert" class="edit__label">所有資格</label>
            <input type="text" name="cert" class=""
              value="{{ old('cert', $objData->cert) }}">
          </div>
          <div class="edit__item">
            <label for="pr" class="edit__label">自己紹介</label>
            <div>
              <textarea name="pr" class="pr__content" id="pr__content" cols="50"
                rows="10">{{ old('pr', $objData->pr) }}</textarea>
              <p class="edit__prCount" id="pr__count"></p>
            </div>
          </div>
          <div class="edit__item">
            <label for="name" class="edit__label">ステータス</label>
            @foreach ($arrStatus as $key => $value)
              <input type="radio" name="status" id="{{ $key }}"
                class="editRadio" value="{{ $key }}"
                @checked(old('status', $objData->status) === $key)>
              <label for="{{ $key }}"
                class="">{{ $value }}</label>
            @endforeach
            @error('status')
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
<script src="/asset/js/sendResizedImg.js"></script>
<script>
  editPassword('password');
  setDate({
    yearId: 'birth1',
    monthId: 'birth2',
    dayId: 'birth3',
    dateId: 'birth',
  });

  const sri = new sendResizedImg('avatar_preview', 'avatar');
  sri.create({
    mode: 'crop', //モード(nocrop|crop|original)
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

  setPrefCity({
    prefElem: 'pref',
    cityElem: 'city',
    defaultPref: '{{ old('pref', $objData->pref) }}',
    defaultCity: '{{ old('city', $objData->city) }}',
    arrPref: @json($jsonPref),
    arrCity: @json($jsonCity)
  });

  @for ($i = 1; $i <= 5; $i++)
    setPrefCity({
      prefElem: 'pref{{ $i }}',
      cityElem: 'city{{ $i }}',
      defaultPref: '{{ old("act_areas[$i]['pref']", $objData->act_areas[$i]['pref']) }}',
      defaultCity: '{{ old("act_areas[$i]['city']", $objData->act_areas[$i]['city']) }}',
      arrPref: @json($jsonPref),
      arrCity: @json($jsonCity)
    });
  @endfor

  setCounter({
    textArea: 'pr__content',
    count: 'pr__count',
    limit: 200,
  });
</script>
