<x-admin-layout>
  <article class="contents">
    <div class="contents__inner">
      <header>
        <h2>問い合わせ編集</h2>
      </header>
      <div>
        <form action="/admin/inquiry/edit?id={{ $objData->id }}" method="post">
          @method('patch')
          @csrf
          <div>
            <label for="email" class="edit__label">メールアドレス</label>
            <input type="text" name="email" id="email" class="edit__input"
              value="{{ old('email', $objData->email) }}">
            @error('email')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="message" class="edit__label">内容</label>
            <textarea name="message" id="message" class="" rows="10"
              cols="40">{{ old('message', $objData->message) }}</textarea>
            @error('message')
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
