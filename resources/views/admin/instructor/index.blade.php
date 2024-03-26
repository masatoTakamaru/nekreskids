<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>指導員ユーザー一覧</h2>
      </header>
      <form action="/admin/instructor/index" method="get">
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
      <a class="btn btn-primary mb-3" href="/admin/instructor/create">新規登録</a>
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
                  href="/admin/instructor/show?id={{ $item->id }}">{{ $item->name }}</a>
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
