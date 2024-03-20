<x-user-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>募集詳細</h2>
      </header>
      @if (!empty($item))
        <table class="index__table">
          <tbody>
            <tr class="index_item">
              <label class="index__label">ID</label>
              <td class="index__value">{{ $item->id }}</td>
            </tr>
            <tr class="index_item">
              <label class="index__label">件名</label>
              <td class="index__value">{{ $item->header }}</td>
            </tr>
            <tr class="index_item">
              <label class="index__label">PR文</label>
              <td class="index__value">{{ $item->pr }}</td>
            </tr>
            <tr class="index_item">
              <label class="index__label">募集種別</label>
              <td class="index__value">{{ $item->recruit_type }}</td>
            </tr>
            <tr class="index_item">
              <label class="index__label">活動</label>
              <td class="index__value">{{ $item->activities }}</td>
            </tr>
            <tr class="index_item">
              <label class="index__label">時間</label>
              <td class="index__value">{{ $item->ontime }}</td>
            </tr>
            <tr class="index_item">
              <label class="index__label">支払い種別</label>
              <td class="index__value">{{ $item->payment_type }}</td>
            </tr>
            <tr class="index_item">
              <label class="index__label">金額</label>
              <td class="index__value">{{ $item->payment }}</td>
            </tr>
            <tr class="index_item">
              <label class="index__label">通勤種別</label>
              <td class="index__value">{{ $item->commutation_type }}</td>
            </tr>
            <tr class="index_item">
              <label class="index__label">通勤費</label>
              <td class="index__value">{{ $item->commutation }}</td>
            </tr>
            <tr class="index_item">
              <label class="index__label">募集人数</label>
              <td class="index__value">{{ $item->number }}</td>
            </tr>
            <tr class="index_item">
              <label class="index__label">期限</label>
              <td class="index__value">{{ $item->end_date->format('Y-m-d') }}
              </td>
            </tr>
            <tr class="index_item">
              <label class="index__label">お気に入り登録数</label>
              <td class="index__value">{{ $item->keep }}</td>
            </tr>
            <tr class="index_item">
              <label class="index__label">学校名</label>
              <td class="index__value">{{ $item->name }}</td>
            </tr>
            <tr class="index_item">
              <label class="index__label">所在地</label>
              <td class="index__value">{{ $item->address }}</td>
            </tr>
          </tbody>
        </table>
      @endif
    </div>
  </article>
</x-user-layout>
<script>
  onchangeSubmit('select__end_date');
</script>
