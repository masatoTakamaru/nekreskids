<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>指導員ユーザー一覧</h2>
      </header>
      <div class="search__wrapper">
        <form action="/admin/instructor/index" method="get">
          <span>絞り込み検索：</span><input class="search__input" name="keyword" value="{{ $keyword }}">
          <button type="submit" class="search__submit">検索</button>
        </form>
        <a href="/admin/instructor/create">新規登録</a>
      </div>
      <table class="index__table">
        <tbody>
          <tr>
            <th class="index__label">ID</th>
            <th class="index__label">名前</th>
            <th class="index__label">メールアドレス</th>
            <th class="index__label">住所</th>
          </tr>
          @if(!empty($objData))
          @foreach($objData as $item)
          <tr class="index_item">
            <td class="index__value">{{$item->id}}</td>
            <td class="index__value">
              <a href="/admin/instructor/detail?id={{ $item->id }}">{{$item->name}}</a>
            </td>
            <td class="index__value">{{$item->email}}</td>
            <td class="index__value">{{$item->pref}}{{$item->city}}</td>
          </tr>
          @endforeach
          @endif
        </tbody>
      </table>
      <div>
        @if(!empty($objData))
        {{ $objData->links('pagination.pagination') }}
        @endif
      </div>
    </div>
  </article>
</x-admin-layout>