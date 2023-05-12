<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>お知らせ詳細</h2>
      </header>
      @if (!empty($objData))
        <section>
          <div>
            <form action="/admin/notice/detail?id={{ $objData->id }}" method="post">
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
                <th class="detail__header">見出し</th>
                <td>{{ $objData->header }}</td>
              </tr>
              <tr>
                <th class="detail__header">本文</th>
                <td>{{ $objData->content }}</td>
              </tr>
              <tr>
                <th class="detail__header">告知日</th>
                <td>{{ $objData->publish_date }}</td>
              </tr>
              <tr>
                <th class="detail__header">公開状況</th>
                <td>{{ $objData->status }}</td>
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
