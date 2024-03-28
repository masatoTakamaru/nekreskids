<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>学校ユーザー一覧</h2>
      </header>
      <div class="search__wrapper">
        <form action="/admin/school/index" method="get">
          <div class="d-flex mb-3">
            <div class="input-group">
              <input type="search" class="form-control col-4" id="search"
                name="keyword" value="{{ $keyword }}">
              <button type="submit" class="btn btn-primary col-2">検索</button>
            </div>
            <div class="col-6"></div>
          </div>
        </form>
        @if (session('flash'))
          <div class="alert alert-success">
            {{ session('flash') }}
          </div>
        @endif
        <a class="btn btn-primary mb-3" href="/admin/school/create">新規登録</a>
      </div>
      @if (session('flash'))
        <div class="alert alert-success">
          {{ session('flash') }}
        </div>
      @endif
      <table class="table table-striped">
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
                <td class="index__value">{{ $item->id }}</td>
                <td class="index__value">
                  <a
                    href="/admin/school/show?id={{ $item->id }}">{{ $item->name }}</a>
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
