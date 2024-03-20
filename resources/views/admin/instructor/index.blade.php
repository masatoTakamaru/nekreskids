<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>指導員ユーザー一覧</h2>
      </header>
      <div class="search__wrapper">
        <form action="/admin/instructor/index" method="get">
          <span>絞り込み検索：</span><input type="search" class="search__input"
            name="keyword" value="{{ $keyword }}">
          <button type="submit" class="search__submit">検索</button>
        </form>
        <a href="/admin/instructor/create">新規登録</a>
      </div>
      @if (session('flash'))
        <div class="alert alert-success">
          {{ session('flash') }}
        </div>
      @endif
      @if ($objData->count())
        <table class="index__table">
          <tbody>
            <tr>
              <th class="index__label">ID</th>
              <th class="index__label">名前</th>
              <th class="index__label">メールアドレス</th>
              <th class="index__label">住所</th>
            </tr>
            @foreach ($objData as $item)
              <tr class="index_item">
                <td class="index__value">{{ $item->id }}</td>
                <td class="index__value">
                  <a
                    href="/admin/instructor/detail?id={{ $item->id }}">{{ $item->name }}</a>
                </td>
                <td class="index__value">{{ $item->email }}</td>
                <td class="index__value">{{ $item->pref }}{{ $item->city }}
                </td>
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
