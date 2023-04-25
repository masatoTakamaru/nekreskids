<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>学校ユーザー一覧</h2>
      </header>
      <div class="search__wrapper">
        <form action="/admin/school/index" method="post">
          @csrf
          <span>絞り込み検索：</span><input class="search__input" value="{{$keywords}}">
          <button type="submit" class="search__submit">検索する</button>
        </form>
      </div>
      <table class="index__table">
        <tbody>
          <tr class="index_item">
            <th class="index__label">ID</th>
            <td class="index__value">{{$objData->id}}</td>
          </tr>
          <tr class="index_item">
            <th class="index__label">学校名</th>
            <td class="index__value">
              <a href="/admin/school/detail?id={{ $objData->id }}">{{$objData->name}}</a>
            </td>
          </tr>
          <tr class="index_item">
            <th class="index__label">メールアドレス</th>
            <td class="index__value">{{$objData->email}}</td>
          </tr>
          <tr class="index_item">
            <th class="index__label">住所</th>
            <td class="index__value">{{$objData->pref}}{{$objData->city}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </article>
</x-admin-layout>