<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>指導員ユーザー登録</h2>
      </header>
      <div>
        <form action="/admin/instructor/create" method="post">
          @csrf

          <div class="">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="text" name="email" id="email"
              class="form-control" value="{{ old('email') }}">
            @error('email')
              <p class="text-danger">{{ $message }}</p>
            @enderror
          </div>
          <div class="">
            <label for="password" class="form-label">パスワード</label>
            <input type="password" name="password" id="password"
              class="form-control edit__password" value="{{ old('password') }}">
            @error('password')
              <p class="text-danger">{{ $message }}</p>
            @enderror
          </div>

          <div class="">
            <label for="name" class="form-label">氏名</label>
            <input type="text" name="name" class="form-control"
              value="{{ old('name') }}">
            @error('name')
              <p class="text-danger">{{ $message }}</p>
            @enderror
          </div>

          <div class="">
            <label for="name_kana" class="form-label">氏名カナ</label>
            <input type="text" name="name_kana" class="form-control"
              value="{{ old('name_kana') }}">
            @error('name_kana')
              <p class="text-danger">{{ $message }}</p>
            @enderror
          </div>

          <div class=" row">
            <label for="" class="form-label">生年月日</label>
            <div class="d-flex col-4 ms-1">
              <select class="form-select" id="birth1"></select>
              <select class="form-select" id="birth2"></select>
              <select class="form-select" id="birth3"></select>
            </div>
            <input type="hidden" name="birth" id="birth"
              value="{{ old('birth') }}">
          </div>

          <div class="">
            <span class="form-label">性別</span>
            @foreach ($arrGender as $key => $value)
              <input type="radio" name="gender" id="{{ $key }}"
                class="form-check-input" value="{{ $key }}"
                @checked(old('gender', 'male') === $key)>
              <label for="{{ $key }}"
                class="">{{ $value }}</label>
            @endforeach
            @error('gender')
              <p class="text-danger">{{ $message }}</p>
            @enderror
          </div>

          <div class="">
            <label for="avatar_preview" class="form-label">アバター画像</label>
            <div id="avatar_preview"></div>
          </div>

          <div class="">
            <label for="zip" class="form-label">郵便番号</label>
            <input type="text" name="zip" id="zip"
              class="form-control form-control-half" placeholder="1638001"
              value="{{ old('zip') }}">
            @error('zip')
              <p class="text-danger">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="pref" class="form-label">都道府県</label>
            <select name="pref" id="pref" class="form-select"></select>
            @error('pref')
              <p class="text-danger">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="city" class="form-label">市区町村</label>
            <select name="city" id="city" class="form-select"></select>
            @error('city')
              <p class="text-danger">{{ $message }}</p>
            @enderror
          </div>

          <div class="">
            <label for="address" class="form-label">町域・番地・建物名など</label>
            <input type="text" name="address" id="address"
              class="form-control" placeholder="西新宿２－８－１"
              value="{{ old('address') }}">
            @error('address')
              <p class="text-danger">{{ $message }}</p>
            @enderror
          </div>

          <div class="">
            <label for="tel" class="form-label">電話番号</label>
            <input type="text" name="tel" class="form-control"
              placeholder="08012345678" value="{{ old('tel') }}">
            @error('tel')
              <p class="text-danger">{{ $message }}</p>
            @enderror
          </div>

          <div class="">
            <span class="form-label">指導できる活動</span>
            <div class="edit__checkboxWrapper" id="checkboxWrapper">
              <div class="edit__checkbox">
                @foreach ($arrActivities as $key => $value)
                  <div class="edit__checkboxItem">
                    <input type="checkbox" name="activities[]"
                      id="{{ $key }}" class="form-check-input"
                      value="{{ $key }}"
                      @checked(old('activities') === $key)>
                    <label for="{{ $key }}"
                      class="form-check-label">{{ $value }}</label>
                  </div>
                @endforeach
              </div>
              @error('activities')
                <p class="text-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div class="">
            <label for="other_activities"
              class="form-label">指導できる活動<br>（その他）</label>
            <input type="text" name="other_activities"
              class="form-control" value="{{ old('other_activities') }}">
          </div>

          <div class="">
            <label for="ontime" class="form-label">指導できる曜日<br>や時間帯</label>
            <input type="text" name="ontime" class="form-control"
              placeholder="平日１７：００～１９：００など" value="{{ old('ontime') }}">
          </div>

          <div class=" d-flex">
            <label for="actAreas" class="form-label">指導できる地域</label>
            <div class="edit__actPrefCities ms-1" id="actAreas">
              @for ($i = 1; $i <= 5; $i++)
                <div>
                  <select id="pref{{ $i }}"
                    class="form-select form-select-half"
                    name="act_areas[{{ $i }}][pref]"></select>
                  <select id="city{{ $i }}"
                    class="form-select form-select-half"
                    name="act_areas[{{ $i }}][city]"></select>
                </div>
              @endfor
            </div>
          </div>

          <div class="">
            <label for="cert" class="form-label">所有資格</label>
            <input type="text" name="cert" class="form-control"
              value="{{ old('cert') }}">
          </div>

          <div class="">
            <label for="pr" class="form-label">自己紹介</label>
            <div>
              <textarea name="pr" class="pr__content form-control" id="pr__content"
                cols="50" rows="10">{{ old('pr_content') }}</textarea>
              <p class="edit__prCount" id="pr__count"></p>
            </div>
          </div>

          <div class="">
            <label for="name" class="form-label">ステータス</label>
            @foreach ($arrStatus as $key => $value)
              <input type="radio" name="status" id="{{ $key }}"
                class="form-check-input" value="{{ $key }}"
                @checked(old('status', 'public') === $key)>
              <label for="{{ $key }}"
                class="form-check-label">{{ $value }}</label>
            @endforeach
            @error('status')
              <p class="text-danger">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <button type="submit" class="btn btn-primary">登録する</button>
          </div>
        </form>
      </div>
    </div>
  </article>
</x-admin-layout>
<script src="/asset/js/sendResizedImg.js"></script>
<script>
  sysCommon.togglePassIcon('password');

  sysCommon.setDate({
    yearId: 'birth1',
    monthId: 'birth2',
    dayId: 'birth3',
    dateId: 'birth',
  });

  sysCommon.setPrefCity({
    prefElem: 'pref',
    cityElem: 'city',
    defaultPref: '{{ old('pref') }}',
    defaultCity: '{{ old('city') }}',
    arrPref: @json($jsonPref),
    arrCity: @json($jsonCity)
  });

  @for ($i = 1; $i <= 5; $i++)
    sysCommon.setPrefCity({
      prefElem: 'pref{{ $i }}',
      cityElem: 'city{{ $i }}',
      defaultPref: '{{ old("act_areas[$i]['pref']") }}',
      defaultCity: '{{ old("act_areas[$i]['city']") }}',
      arrPref: @json($jsonPref),
      arrCity: @json($jsonCity)
    });
  @endfor

  sysCommon.setCounter({
    textArea: 'pr__content',
    count: 'pr__count',
    limit: 200,
  });

  const sri = new sendResizedImg('avatar_preview', 'avatar');
  sri.create({
    mode: "crop", //モード(nocrop|crop|original)
    preview: {
      maxWidth: 200, //プレビュー画像の最大幅
      maxHeight: 200, //プレビュー画像の最大高さ
      imgData: "{{ old('avatar') }}", //画像読み込み前の初期画像(ファイル名|base64文字列)
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
