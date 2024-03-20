<x-guest-layout>
  <article class="">
    <div class="">
      <header>
        <h2>指導員ユーザー登録</h2>
        <h3>ステップ3</h3>
      </header>
      <div>
        <form action="/instructor/step3" method="post">
          @csrf

          <div class="edit__item">
            <span class="edit__label">指導できる活動</span>
            <div class="edit__checkboxWrapper" id="checkboxWrapper">
              <div class="edit__checkbox">
                @foreach ($arrActivities as $key => $value)
                  <div class="edit__checkboxItem">
                    <input type="checkbox" name="activities[]"
                      id="{{ $key }}" class="edit__checkbox"
                      value="{{ $key }}"
                      @checked(old('activities') === $key)>
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
            <label for="other_activities" class="edit__label">指導できる活動<br>（その他）</label>
            <div>
              <input type="text" name="other_activities" class=""
                value="{{ old('other_activities', $objData->other_activities) }}">
              @error('other_activities')
                <p class="edit__alert">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <div class="edit__item">
            <label for="ontime" class="edit__label">指導できる曜日<br>や時間帯</label>
            <div>
              <input type="text" name="ontime" class=""
                placeholder="平日１７：００～１９：００など"
                value="{{ old('ontime', $objData->ontime) }}">
              @error('ontime')
                <p class="edit__alert">{{ $message }}</p>
              @enderror
            </div>
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
            <div>
              <input type="text" name="cert" class=""
                value="{{ old('cert', $objData->cert) }}">
              @error('cert')
                <p class="edit__alert">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <div class="edit__item">
            <label for="pr" class="edit__label">自己紹介</label>
            <div>
              <textarea name="pr" class="pr__content" id="pr__content" cols="50"
                rows="10">{{ old('pr_content', $objData->pr) }}</textarea>
              <p class="edit__prCount" id="pr__count"></p>
            </div>
          </div>
      </div>
      <div>
        <button type="submit" name="action" class="" value="draft">下書き保存</button>
        <button type="submit" name="transit" class="" value="step2">前に戻る</button>
        <button type="submit" name="transit" class=""
          value="confirm">確認画面へ</button>
      </div>
      <input type="hidden" name="jsonData" value="{{ old('jsonData', $jsonData) }}">
      </form>
    </div>
    </div>
  </article>
</x-guest-layout>
<script>
  @for ($i = 1; $i <= 5; $i++)
    setPrefCity({
      prefElem: 'pref{{ $i }}',
      cityElem: 'city{{ $i }}',
      defaultPref: '{{ old("act_areas[$i]['pref']") }}',
      defaultCity: '{{ old("act_areas[$i]['city']") }}',
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
