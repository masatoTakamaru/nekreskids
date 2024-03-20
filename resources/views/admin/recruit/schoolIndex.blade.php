<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>学校ユーザー選択</h2>
      </header>
      <div class="search__wrapper">
        <form action="/admin/school/index" method="get">
          <span>絞り込み検索：</span><input type="search" name="keyword"
            class="search__input" value="{{ $keyword }}">
          <button type="submit" class="search__submit">検索</button>
        </form>
        <a href="/admin/school/create">新規登録</a>
      </div>
      @if (session('flash'))
        <div class="alert alert-success">
          {{ session('flash') }}
        </div>
      @endif
      <table class="index__table">
        <tbody>
          <tr>
            <th class="index__label">ID</th>
            <th class="index__label">学校名</th>
            <th class="index__label">メールアドレス</th>
            <th class="index__label">住所</th>
          </tr>
          @if ($objData->count())
            @foreach ($objData as $item)
              <tr class="index_item">
                <td class="index__value">{{ $item->school_id }}</td>
                <td class="index__value">
                  <a
                    href="/admin/recruit/create?school_id={{ $item->school_id }}">{{ $item->name }}</a>
                </td>
                <td class="index__value">{{ $item->email }}</td>
                <td class="index__value">{{ $item->address }}
                </td>
              </tr>
            @endforeach
          @endif
        </tbody>
      </table>
      <div>
        @if ($objData->count())
          {{ $objData->links('pagination.pagination') }}
        @endif
      </div>
    </div>
  </article>
</x-admin-layout>
