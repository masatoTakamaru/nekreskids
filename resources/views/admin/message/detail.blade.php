<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>メッセージ詳細</h2>
      </header>
      @if (!empty($objData))
        <section>
          <div>
            <form action="/admin/message/detail?id={{ $objData->id }}" method="post">
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
                <th>送信者</th>
                <td>{{ $objData->sender_name }}</td>
              </tr>
              <tr>
                <th>受信者</th>
                <td>{{ $objData->recipient_name }}</td>
              </tr>
              <tr>
                <th>メッセージ</th>
                <td>{{ $objData->message }}</td>
              </tr>
              <tr>
                <th>既読</th>
                <td>{{ $objData->read_flg }}</td>
              </tr>
            </tbody>
          </table>
        </section>
      @endif
    </div>
  </article>
</x-admin-layout>
<script>
  deleteConfirm('deleteButton');
  deleteConfirm('form__delbutton');
</script>
