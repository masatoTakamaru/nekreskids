<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>指導員募集編集</h2>
      </header>
      @if ($objData->count())
        <div>
          <form action="/admin/recruit/edit" method="post">
            @method('patch')
            @csrf

            <input type="hidden" name="id" value="{{ $objData->id }}">

            <div class="edit__item">
              <label for="header" class="edit__label">件名</label>
              <input type="text" name="header" id="header"
                class="edit__input"
                value="{{ old('header', $objData->header) }}">
              @error('header')
                <p class="edit__alert">{{ $message }}</p>
              @enderror
            </div>

            <div class="edit__item">
              <label for="pr" class="edit__label">紹介文</label>
              <div>
                <textarea name="pr" class="pr__content" id="pr__content" cols="50"
                  rows="10">{{ old('pr_content', $objData->pr) }}</textarea>
                <p class="edit__prCount" id="pr__count"></p>
              </div>
            </div>

            <div class="edit__item">
              <label for="recruit_type" class="edit__label">募集種別</label>
              <select name="recruit_type" class="edit__select">
                @foreach ($arrRecruitType as $key => $value)
                  <option class="edit__option" value="{{ $key }}"
                    @selected(old('recruit_type', $objData->recruit_type) === $key)>{{ $value }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="edit__item">
              <label for="activities" class="edit__label"></label>
              <div class="row">
                @foreach ($arrActivities as $key => $value)
                  <div class="col-4">
                    <input type="checkbox" name="activities[]"
                      id="activities_{{ $key }}" class="edit__checkbox"
                      value="{{ $key }}" @checked(in_array($key, old('activities') ?? $objData->activities))>
                    <label for="activities_{{ $key }}"
                      class="edit__label">{{ $value }}</label>
                  </div>
                @endforeach
              </div>
              @error('activities')
                <p class="edit__alert">{{ $message }}</p>
              @enderror
            </div>

            <div class="edit__item">
              <label for="other_activities"
                class="edit__label">募集する活動<br>（その他）</label>
              <input type="text" name="other_activities"
                id="other_activities" class="edit__input"
                value="{{ old('other_activities', $objData->other_activities) }}">
              @error('other_activities')
                <p class="edit__alert">{{ $message }}</p>
              @enderror
            </div>

            <div class="edit__item">
              <label for="ontime" class="edit__label">募集する日時</label>
              <input type="text" name="ontime" id="ontime"
                class="edit__input"
                value="{{ old('ontime', $objData->ontime) }}">
              @error('ontime')
                <p class="edit__alert">{{ $message }}</p>
              @enderror
            </div>

            <div class="edit__item">
              <label for="payment_type" class="edit__label">支払い種別</label>
              <select name="payment_type" id="payment_type"
                class="edit__select">
                @foreach ($arrPaymentType as $key => $value)
                  <option class="edit__option" value="{{ $key }}"
                    @selected(old('payment_type') ?? $objData->payment_type === $key)>{{ $value }}
                  </option>
                @endforeach
              </select>
              @error('payment_type')
                <p class="edit__alert">{{ $message }}</p>
              @enderror
            </div>

            <div class="edit__item">
              <label for="payment" class="edit__label">給与額（円）</label>
              <input type="number" name="payment" id="payment"
                class="edit__input"
                value="{{ old('payment', $objData->payment) }}">
              @error('payment')
                <p class="edit__alert">{{ $message }}</p>
              @enderror
            </div>

            <div class="edit__item">
              <label for="commutation_type" class="edit__label">交通費の支給</label>
              <select name="commutation_type" id="commutation_type"
                class="edit__select">
                @foreach ($arrCommutationType as $key => $value)
                  <option class="edit__option" value="{{ $key }}"
                    @selected(old('commutation_type', $objData->commutation_type) === $key)>{{ $value }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="edit__item">
              <label for="commutation" class="edit__label">交通費（円）</label>
              <input type="number" name="commutation" id="commutation"
                class="edit__input"
                value="{{ old('commutation', $objData->commutation) }}">
              @error('commutation')
                <p class="edit__alert">{{ $message }}</p>
              @enderror
            </div>

            <div class="edit__item">
              <label for="number" class="edit__label">募集人数（人）</label>
              <input type="number" name="number" id="number"
                class="edit__input"
                value="{{ old('number', $objData->number) }}">
              @error('number')
                <p class="edit__alert">{{ $message }}</p>
              @enderror
            </div>

            <div class="edit__item">
              <label for="status" class="edit__label">公開状況</label>
              <select name="status" class="edit__select">
                @foreach ($arrStatus as $key => $value)
                  <option class="edit__option" value="{{ $key }}"
                    @selected(old('status', $objData->status) === $key)>{{ $value }}</option>
                @endforeach
              </select>
            </div>

            <div class="edit__item">
              <label for="end_date" class="edit__label">募集期限日</label>
              <input type="date" name="end_date" id="end_date"
                class="edit__input"
                value="{{ old('end_date', $objData->end_date) }}">
              @error('end_date')
                <p class="edit__alert">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <button type="submit" class="edit__submit">登録する</button>
            </div>

            <input type="hidden" value="{{ $objData->school_id }}">
          </form>
        </div>
      @endif
    </div>
  </article>
</x-admin-layout>
<script>
  setCounter({
    textArea: 'pr__content',
    count: 'pr__count',
    limit: 100,
  });
  toggleDisabled({
    select: 'payment_type',
    condition: ['free'],
    target: 'payment',
  });
  toggleDisabled({
    select: 'commutation_type',
    condition: ['flex', 'none'],
    target: 'commutation',
  });
</script>
