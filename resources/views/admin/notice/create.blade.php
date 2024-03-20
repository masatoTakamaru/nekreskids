<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>お知らせ登録</h2>
      </header>
      <div>
        <form action="/admin/notice/create" method="post">
          @csrf
          <div class="edit__item">
            <label for="header" class="edit__label">見出し</label>
            <input type="text" name="header" id="header" class="edit__input"
              value="{{ old('header') }}">
            @error('header')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
            <label for="content" class="edit__label">本文</label>
            <div>
              <textarea name="content" class="content__content" id="content__content"
                cols="50" rows="10">{{ old('content') }}</textarea>
              <p class="edit__content-count" id="content__count"></p>
            </div>
          </div>
          <div class="edit__item">
            <label for="publish_date" class="edit__label">告知日</label>
            <input type="date" name="publish_date" id="publish_date"
              class="" value="{{ old('publish_date') }}">
            @error('publish_date')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
            <label for="status" class="edit__label">公開状況</label>
            @foreach ($arrStatus as $key => $value)
              <input type="radio" name="status" id="{{ $key }}"
                class="editRadio" value="{{ $key }}"
                @checked(old('status', 'public') === $key)>
              <label for="{{ $key }}"
                class="">{{ $value }}</label>
            @endforeach
            @error('status')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <button type="submit" class="edit__submit">登録する</button>
          </div>
        </form>
      </div>
    </div>
  </article>
</x-admin-layout>
<script>
  setCounter({
    textArea: 'content__content',
    count: 'content__count',
    limit: 200,
  });
</script>
