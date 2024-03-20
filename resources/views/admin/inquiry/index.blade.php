<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>問い合わせ一覧</h2>
      </header>
      <div class="search__wrapper">
        <form action="/admin/inquiry/index" method="get">
          <span>絞り込み検索：</span><input type="search" class="search__input"
            name="keyword" value="{{ $keyword }}">
          <button type="submit" class="search__submit">検索</button>
        </form>
        @if (session('flash'))
          <div class="alert alert-success">
            {{ session('flash') }}
          </div>
        @endif
        <a href="/admin/inquiry/create">新規登録</a>
      </div>
      @if ($objData->count())
        <table class="index__table">
          <tbody>
            <tr>
              <th class="index__label">ID</th>
              <th class="index__label">メールアドレス</th>
              <th class="index__label">内容</th>
            </tr>
            @foreach ($objData as $item)
              <tr class="index_item">
                <td class="index__value"><a
                    href="/admin/inquiry/detail?id={{ $item->id }}">{{ $item->id }}</a>
                </td>
                <td class="index__value">{{ $item->email }}</td>
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
