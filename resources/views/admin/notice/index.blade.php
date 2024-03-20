<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>お知らせ一覧</h2>
      </header>
      <div class="search__wrapper">
        <form action="/admin/notice/index" method="get">
          <span>絞り込み検索：</span>
          <input type="search" name="keyword" class="search__input"
            value="{{ $keyword }}">
          <button type="submit" class="search__submit">検索</button>
        </form>
        <a href="/admin/notice/create">新規登録</a>
      </div>
      @if ($objData->count())
        <table class="index__table">
          <tbody>
            <tr>
              <th class="index__label">ID</th>
              <th class="index__label">見出し</th>
              <th class="index__label">本文</th>
              <th class="index__label">告知日</th>
              <th class="index__label">公開状況</th>
            </tr>
            @foreach ($objData as $item)
              <tr class="index_item">
                <td class="index__value">
                  <a href="/admin/notice/detail?id={{ $item->id }}">
                    {{ $item->id }}
                  </a>
                </td>
                <td class="index__value">{{ $item->header }}</td>
                <td class="index__value">{{ $item->content }}</td>
                <td class="index__value">{{ $item->publish_date }}</td>
                <td class="index__value">{{ $item->status }}</td>
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
