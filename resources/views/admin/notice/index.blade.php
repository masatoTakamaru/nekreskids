<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>お知らせ一覧</h2>
      </header>
      <div class="search__wrapper">
        <form action="/admin/notice/index" method="get">
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
                  <a href="/admin/notice/show?id={{ $item->id }}">
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
