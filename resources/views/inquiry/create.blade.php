<x-guest-layout>
  <article class="">
    <div class="">
      <header>
        <h2>問い合わせ</h2>
      </header>
      <div>
        <form action="/inquiry/create" method="post">
          @csrf

          <div>
            <label for="email" class="editLabel">メールアドレス</label>
            <input type="text" name="email" id="email" class="editInput"
              value="{{ old('email', $objData->email) }}">
            @error('email')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="message" class="">問い合わせ内容</label>
            <textarea name="message" id="message" class="" rows="10"
              cols="40">{{ old('message', $objData->message) }}</textarea>
            @error('message')
              <p class="edit__alert">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <button type="submit" name="transit" class=""
              value="confirm">次に進む</button>
          </div>
          <input type="hidden" name="jsonData"
            value="{{ old('jsonData', $jsonData) }}">
        </form>
      </div>
    </div>
  </article>
</x-guest-layout>
