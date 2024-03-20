<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>問い合わせ詳細</h2>
      </header>
      <section>
        <div>
          <a href="/admin/inquiry/edit?id={{ $objData->id }}"
            class="edit__link">編集する</a>
          <form action="/admin/inquiry/detail?id={{ $objData->id }}" method="post">
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
              <td for="email" class="detail__header">メールアドレス</td>
              <td class="detail__data">{{ $objData->email }}</td>
            </tr>
            <tr>
              <td for="message" class="detail__header">内容</td>
              <td class="detail__data">{{ $objData->message }}</td>
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
