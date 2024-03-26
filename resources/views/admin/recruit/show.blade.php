<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>指導員募集詳細</h2>
      </header>
      <section>
        <div>
          <a href="/admin/recruit/edit?id={{ $objData->id }}" class="edit__link">編集する</a>
          <form action="/admin/recruit/show?id={{ $objData->id }}" method="post">
            @method('delete')
            @csrf
            <button type="submit" id="deleteButton" class="edit__submit">削除する</button>
          </form>
        </div>
      </section>
      @if ($objData->count())
        <section>
          <table>
            <tbody>
              <tr>
                <th class="detail__header">学校名</th>
                <td>{{ $objData->name }}</td>
              </tr>
              <tr>
                <th class="detail__header">件名</th>
                <td>{{ $objData->header }}</td>
              </tr>
              <tr>
                <th class="detail__header">紹介文</th>
                <td>{{ $objData->pr }}</td>
              </tr>
              <tr>
                <th class="detail__header">募集種別</th>
                <td>{{ $objData->recruit_type }}</td>
              </tr>
              <tr>
                <th class="detail__header">募集する活動</th>
                <td>{{ $objData->activities }}</td>
              </tr>
              <tr>
                <th class="detail__header">募集する活動<br>（その他）</th>
                <td>{{ $objData->other_activities }}</td>
              </tr>
              <tr>
                <th class="detail__header">募集する日時</th>
                <td>{{ $objData->ontime }}</td>
              </tr>
              <tr>
                <th class="detail__header">支払い種別</th>
                <td>{{ $objData->payment_type }}</td>
              </tr>
              <tr>
                <th class="detail__header">給与額（円）</th>
                <td>{{ $objData->payment }}</td>
              </tr>
              <tr>
                <th class="detail__header">交通費の支給</th>
                <td>{{ $objData->commutation_type }}</td>
              </tr>
              <tr>
                <th class="detail__header">交通費</th>
                <td>{{ $objData->commutation }}</td>
              </tr>
              <tr>
                <th class="detail__header">募集人数</th>
                <td>{{ $objData->number }}</td>
              </tr>
              <tr>
                <th class="detail__header">公開状況</th>
                <td>{{ $objData->status }}</td>
              </tr>
              <tr>
                <th class="detail__header">募集期限日</th>
                <td>{{ $objData->end_date }}</td>
              </tr>
          </table>
        </section>
      @endif
    </div>
  </article>
</x-admin-layout>
