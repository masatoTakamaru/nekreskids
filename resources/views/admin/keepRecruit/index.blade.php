<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>気になるリスト：募集一覧</h2>
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
              <th class="index__label">件名</th>
              <th class="index__label">登録数</th>
            </tr>
            @foreach ($objData as $item)
              <tr>
                <td class="index__value">{{ $item->header }}</td>
                <td class="index__value">{{ $item->count }}</td>
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
