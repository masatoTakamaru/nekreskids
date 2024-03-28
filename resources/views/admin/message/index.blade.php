<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>メッセージ一覧</h2>
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
        <table class="table table-striped">
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
                  <a href="/admin/message/show?id={{ $item->id }}">
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
