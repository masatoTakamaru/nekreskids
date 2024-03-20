<x-user-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>申し込み一覧</h2>
      </header>
      <div class="search__wrapper">
        <form action="/user/instructor/index" method="get">
          <span>絞り込み検索：</span>
          <input type="search" name="keyword" class="search__input"
            value="{{ $keyword }}">
          <button type="submit" class="search__submit">検索</button>
        </form>
        <form action="/user/instructor/index" method="get">
          <select name="end_date" id="select__end_date" class="edit__select">
            <option class="edit__option" value="all"
              @selected($end_date === 'all')>全て</option>
            <option class="edit__option" value="valid"
              @selected($end_date === 'valid')>募集中のみ</option>
          </select>
        </form>
      </div>
      <h2>応募中の募集一覧</h2>
      @if ($objData->count())
        <table class="index__table">
          <tbody>
            <tr>
              <th class="index__label">ID</th>
              <th class="index__label">期限</th>
              <th class="index__label">件名</th>
              <th class="index__label">メッセージ</th>
            </tr>
            @foreach ($objData as $item)
              <tr class="index_item">
                <td class="index__value">
                  <a href="/public/recruit-detail?id={{ $item->id }}">
                    {{ $item->id }}
                  </a>
                </td>
                <td class="index__value__nowrap">
                  {{ $item->end_date->format('Y-m-d') }}</td>
                <td class="index__value">{{ $item->header }}</td>
                <td class="index__value">{{ $item->message }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <div>
          {{ $objData->links('pagination.pagination') }}
        </div>
      @endif
    </div>
  </article>
</x-user-layout>
<script>
  onchangeSubmit('select__end_date');
</script>
