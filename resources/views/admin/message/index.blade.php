<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>メッセージ一覧</h2>
      </header>
      <div class="search__wrapper">
        <form action="/admin/message/index" method="get">
          <span>絞り込み検索：</span>
          <input type="search" name="keyword" class="search__input"
            value="{{ $keyword }}">
          <button type="submit" class="search__submit">検索</button>
        </form>
        @if (session('flash'))
          <div class="alert alert-success">
            {{ session('flash') }}
          </div>
        @endif
      </div>
      @if ($objData->count())
        <table class="index__table">
          <tbody>
            <tr>
              <th class="index__label">ID</th>
              <th class="index__label">送信者</th>
              <th class="index__label">受信者</th>
              <th class="index__label">メッセージ</th>
              <th class="index__label">既読</th>
            </tr>
            @foreach ($objData as $item)
              <tr class="index_item">
                <td class="index__value">
                  <a href="/admin/message/detail?id={{ $item->id }}">
                    {{ $item->id }}
                  </a>
                </td>
                <td class="index__value">{{ $item->sender_name }}</td>
                <td class="index__value">{{ $item->recipient_name }}</td>
                <td class="index__value">{{ $item->message }}</td>
                <td class="index__value">{{ $item->read_flg }}</td>
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
