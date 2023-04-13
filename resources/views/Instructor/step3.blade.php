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
            <p class="edit__label">指導できる活動</p>
            <div class="edit__checkboxWrapper" id="edit__checkboxWrapper">
              @foreach($arrActivities as $key => $value)
              <div class="edit__checkboxItem">
                <input type="checkbox" name="activities[]" id="{{ $key }}" class="edit__checkbox" value="{{ $key }}"
                  @if(old('activities')===$key||in_array($key, $objData->activities)) checked="checked" @endif>
                <label for="{{ $key }}" class="">{{ $value }}</label>
              </div>
              @endforeach
              @error('activities') <p class="alert">{{ $message }}</p> @enderror
            </div>
          </div>
          <div class="edit__item">
            <label for="other_activities" class="edit__label">指導できる活動<br>（その他）</label>
            <input type="text" name="other_activities" class="">
          </div>
          <div class="edit__item">
            <label for="ontime" class="edit__label">指導できる曜日<br>や時間帯</label>
            <input type="text" name="ontime" class="" placeholder="平日１７：００～１９：００など">
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
            <input type="text" name="cert" class="">
          </div>
          <div class="edit__item">
            <label for="pr" class="edit__label">自己紹介</label>
            <div>
              <textarea name="pr" class="pr_content" id="pr_content" cols="50" rows="10"></textarea>
              <p class="edit__prCount" id="pr_count"></p>
            </div>
          </div>
      </div>
      <div>
        <button type="submit" name="transition" class="" value="prev">前に戻る</button>
        <button type="submit" name="transition" class="" value="confirm">確認画面へ</button>
      </div>
      <input type="hidden" name="jsonData" value="{{ old('jsonData', $jsonData) }}">
      </form>
    </div>
    </div>
  </article>
  @php $arrActareas = old('act_areas') ?? $arrActAreas @endphp
  <script>
    const arrActAreas = <?php echo $arrActAreas; ?>;
    const arrPrefs = <?php echo $arrPrefs; ?>;
    const arrCities = <?php echo $arrCities; ?>;
  </script>
</x-guest-layout>