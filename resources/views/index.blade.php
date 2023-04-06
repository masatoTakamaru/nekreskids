<x-guest-layout>
  <div>
    Welcome!
  </div>
  <article class="index_notice">
    <div class="index_notice_inner">
      <header>お知らせ</header>
      <div>
        @foreach ($notices as $notice)
        <div>
          <div class="index_notice_header_wrap">
            <p class="index_notice_publish_date">{{ $notice->publish_date}}</p>
            <div>
              <p class="index_notice_header">{{ $notice->header }}</p>
              <p class="">{{ $notice->content}}</p>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </article>
</x-guest-layout>