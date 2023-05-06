<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>申し込み一覧</h2>
      </header>
      <div class="search__wrapper">
        <form action="/admin/application/index" method="get">
          <span>絞り込み検索：</span>
          <input type="search" name="keyword" class="search__input"
            value="{{ $keyword }}">
          <button type="submit" class="search__submit">検索</button>
        </form>
      </div>
      @if (!empty($objData))
        <table class="index__table">
          <tbody>
            <tr>
              <th class="index__label">ID</th>
              <th class="index__label">募集ID</th>
              <th class="index__label">指導員ID</th>
              <th class="index__label">メッセージ</th>
            </tr>
            @foreach ($objData as $item)
              <tr class="index_item">
                <td class="index__value">{{ $item->id }}
                </td>
                <td class="index__value">
                  <a href="/admin/recruit/detail?id={{ $item->recruit_id }}">
                    {{ $item->recruit_header }}
                  </a>
                </td>
                <td class="index__value">
                  <a href="/admin/instructor/detail?id={{ $item->instructor->user->id }}">
                    {{ $item->instructor_name }}
                  </a>
                </td>
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
</x-admin-layout>
