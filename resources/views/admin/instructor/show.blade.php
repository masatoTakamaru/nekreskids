<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>指導員ユーザー詳細</h2>
      </header>
      <section>
        <div>
          <a href="/admin/instructor/edit?id={{ $objData->id }}"
            class="edit__link">編集する</a>
          <form action="/admin/instructor/show?id={{ $objData->id }}" method="post">
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
              <td class="detail__data">{{ $objData->email }}</td>
            </tr>
            <tr>
              <th class="detail__header">パスワード</th>
              <td class="detail__data">セキュリティのため非表示</td>
            </tr>
            <tr>
              <th class="detail__header">名前</th>
              <td class="detail__data">{{ $objData->name }}</td>
            </tr>
            <tr>
              <th class="detail__header">名前カナ</th>
              <td class="detail__data">{{ $objData->name_kana }}</td>
            </tr>
            <tr>
              <th class="detail__header">アバター</th>
              <td class="detail__data"><img src="{{ $objData->avatar_url }}"></td>
            </tr>
            <tr>
              <th class="detail__header">自己紹介</th>
              <td class="detail__data">{{ $objData->pr }}</td>
            </tr>
            <tr>
              <th class="detail__header">指導できる活動</th>
              <td class="detail__data">{{ $objData->activities }}</td>
            </tr>
            <tr>
              <th class="detail__header">指導できる活動<br>（その他）</th>
              <td class="detail__data">{{ $objData->other_activities }}</td>
            </tr>
            <tr>
              <th class="detail__header">指導できる<br>曜日や時間帯</th>
              <td class="detail__data">{{ $objData->ontime }}</td>
            </tr>
            <tr>
              <th class="detail__header">指導できる<br>地域</th>
              <td class="detail__data">{{ $objData->act_areas }}</td>
            </tr>
            <tr>
              <th class="detail__header">生年月日</th>
              <td class="detail__data">{{ $objData->birth }}</td>
            </tr>
            <tr>
              <th class="detail__header">所有資格</th>
              <td class="detail__data">{{ $objData->cert }}</td>
            </tr>
            <tr>
              <th class="detail__header">性別</th>
              <td class="detail__data">{{ $objData->gender }}</td>
            </tr>
            <tr>
              <th class="detail__header">郵便番号</th>
              <td class="detail__data">{{ $objData->zip }}</td>
            </tr>
            <tr>
              <th class="detail__header">都道府県</th>
              <td class="detail__data">{{ $objData->pref }}</td>
            </tr>
            <tr>
              <th class="detail__header">市区町村</th>
              <td class="detail__data">{{ $objData->city }}</td>
            </tr>
            <tr>
              <th class="detail__header">町域・番地・<br>建物名など</th>
              <td class="detail__data">{{ $objData->address }}</td>
            </tr>
            <tr>
              <th class="detail__header">電話番号</th>
              <td class="detail__data">{{ $objData->tel }}</td>
            </tr>
            <tr>
              <th class="detail__header">気になるリスト<br>登録数</th>
              <td class="detail__data">{{ $objData->keep }}</td>
            </tr>
            <tr>
              <th class="detail__header">ステータス</th>
              <td class="detail__data">{{ $objData->status }}</td>
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
