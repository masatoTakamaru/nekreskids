<x-user-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>学校検索</h2>
      </header>
      <div class="search__wrapper">
        <form action="/user/school" method="get">
          <span>絞り込み検索：</span>
          <input type="search" name="keyword" class="search__input"
            value="{{ $keyword }}">
          <button type="submit" class="search__submit">検索</button>
        </form>
      </div>
      <hr>
      <a href="/public/school">全国</a>
      <div class="row">
        @foreach ($arrPref as $areaKey => $areaValue)
          <div class="prefTable__card col-md-2">
            <p class="prefTable__header">{{ $areaValue['area'] }}</p>
            @foreach ($areaValue['pref'] as $prefKey => $prefValue)
              <p class="prefTable__value">
                {{ $prefValue }}
                <span>(<a
                    href="/public/school?pref={{ $prefKey }}">{{ $arrSchool[$areaKey][$prefKey] }}</a>)</span>
              </p>
            @endforeach
          </div>
        @endforeach
      </div>
      <div class="table__wrapper">
        @if ($objData->count())
          <table class="index__table">
            <tbody>
              <tr>
                <th class="index__label">ID</th>
                <th class="index__label">学校名</th>
                <th class="index__label">住所</th>
              </tr>
              @foreach ($objData as $item)
                <tr class="index_item">
                  <td class="index__value">{{ $item->id }}</td>
                  <td class="index__value">
                    <a
                      href="/public/school-detail?id={{ $item->id }}">{{ $item->name }}</a>
                  </td>
                  <td class="index__value">{{ $item->address }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div>
            {{ $objData->links('pagination.pagination') }}
          </div>
        @endif
      </div>
    </div>
  </article>
</x-user-layout>
<script>
  onchangeSubmit('select__end_date');
</script>
