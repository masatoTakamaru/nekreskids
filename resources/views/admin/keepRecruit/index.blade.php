<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>気になるリスト：募集一覧</h2>
      </header>
      <div class="search__wrapper">
        <form action="/admin/message/index" method="get">
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
