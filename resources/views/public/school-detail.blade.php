<x-user-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>学校詳細</h2>
      </header>
      <hr>
      @if ($objData->count())
        <div class="table__wrapper">
          <table class="index__table">
            <tbody>
              <tr>
                <label class="index__label">ID</label>
                <td class="index__value">{{ $objData->id }}</td>
              </tr>
              <tr>
                <label class="index__label">学校名</label>
                <td class="index__value">{{ $objData->name }}</td>
              </tr>
              <tr>
                <label class="index__label">郵便番号</label>
                <td class="index__value">{{ $objData->zip }}</td>
              </tr>
              <tr>
                <label class="index__label">住所</label>
                <td class="index__value">{{ $objData->full_address }}</td>
              </tr>
              <tr>
                <label class="index__label">電話番号</label>
                <td class="index__value">{{ $objData->full_tel }}</td>
              </tr>
              <tr>
                <label class="index__label">担当者名</label>
                <td class="index__value">{{ $objData->charge }}</td>
              </tr>
              <tr>
                <label class="index__label">評価点</label>
                <td class="index__value">{{ $objData->score }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <hr>
        <header>
          <h2>募集中の活動</h2>
        </header>
        <div class="table__wrapper">
          <table class="index__table">
            <tbody>
              <tr>
                <th class="index__label">ID</th>
                <th class="index__label">期限</th>
                <th class="index__label">件名</th>
              </tr>
              @foreach ($objData->recruits as $item)
                <tr>
                  <td class="index__value">{{ $item->id }}</td>
                  <td class="index__value">{{ $item->end_date }}</td>
                  <td class="index__value">
                    <a
                      href="/public/recruit-show?id={{ $item->id }}">{{ $item->header }}</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </article>
</x-user-layout>
<script>
  onchangeSubmit('select__end_date');
</script>
