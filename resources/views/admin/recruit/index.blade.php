<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>指導員募集一覧</h2>
      </header>
      <div class="search__wrapper">
        <form action="/admin/recruit/index" method="get">
          <span>絞り込み検索：</span><input type="search" name="keyword" class="search__input"
            value="{{ $keyword }}">
          <button type="submit" class="search__submit">検索</button>
        </form>
      </div>
      @if (!empty($objData))
        <table class="index__table">
          <tbody>
            <tr>
              <th class="index__label">ID</th>
              <th class="index__label">件名</th>
              <th class="index__label">学校名</th>
              <th class="index__label">募集活動</th>
              <th class="index__label">募集期限日</th>
              <th class="index__label">気になるリスト登録数</th>
            </tr>
            @foreach ($objData as $item)
              <tr class="index_item">
                <td class="index__value">{{ $item->id }}</td>
                <td class="index__value">
                  <a
                    href="/admin/recruit/detail?id={{ $item->id }}">{{ $item->header }}</a>
                </td>
                <td class="index__value">
                  <a
                    href="/admin/school/detail?id={{ $item->school->user->id }}">{{ $item->school_name }}</a>
                </td>
                <td class="index__value">{{ $item->activities }}</td>
                <td class="index__value">{{ $item->end_date }}</td>
                <td class="index__value">{{ $item->keep }}</td>
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
</x-admin-layout>
