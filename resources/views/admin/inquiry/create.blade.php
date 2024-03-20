<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>問い合わせ登録</h2>
      </header>
      <div>
        <form action="/admin/inquiry/create" method="post">
          @csrf
          <div class="edit__item">
            <label for="email" class="editLabel">メールアドレス</label>
            <input type="text" name="email" id="email" class="editInput"
              value="{{ old('email') }}">
            @error('email')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div class="edit__item">
            <label for="message" class="editLabel">内容</label>
            <textarea name="message" class="editInput" rows="10" cols="40">{{ old('name') }}</textarea>
            @error('name')
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
