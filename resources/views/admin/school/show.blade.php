<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>学校ユーザー詳細</h2>
      </header>
      <section>
        <div>
          <a href="/admin/school/edit?id={{ $objData->user_id }}" class="edit__link">編集する</a>
          <form action="/admin/school/show?id={{ $objData->user_id }}" method="post">
            @method('delete')
            @csrf
            <button type="submit" id="deleteButton" class="edit__submit">削除する</button>
          </form>
        </div>
      </section>
      <section>
        <table>
          <tbody>
            <tr>
              <th class="detail__header">メールアドレス</th>
              <td>{{ $objData->email }}</td>
            </tr>
            <tr>
              <th class="detail__header">パスワード</th>
              <td>セキュリティのため非表示</td>
            </tr>
            <tr>
              <th class="detail__header">学校名</th>
              <td>{{ $objData->name }}</td>
            </tr>
            <tr>
              <th class="detail__header">郵便番号</th>
              <td>{{ $objData->zip }}</td>
            </tr>
            <tr>
              <th class="detail__header">都道府県</th>
              <td>{{ $objData->pref }}</td>
            </tr>
            <tr>
              <th class="detail__header">市区町村</th>
              <td>{{ $objData->city }}</td>
            </tr>
            <tr>
              <th class="detail__header">町域・番地・建物名など</th>
              <td>{{ $objData->address }}</td>
            </tr>
            <tr>
              <th class="detail__header">電話番号１</th>
              <td>{{ $objData->tel1 }}</td>
            </tr>
            <tr>
              <th class="detail__header">電話番号２</th>
              <td>{{ $objData->tel2 }}</td>
            </tr>
            <tr>
              <th class="detail__header">担当者名</th>
              <td>{{ $objData->charge }}</td>
            </tr>
          </tbody>
        </table>
      </section>
    </div>
  </article>
</x-admin-layout>
<script>
  deleteConfirm('deleteButton');
  deleteConfirm('form__delbutton');
</script>
