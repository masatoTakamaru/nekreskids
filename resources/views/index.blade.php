<x-guest-layout>
  <div class="top__container">
    <div class="top__header">
      全国児童の部活指導員が見つかる
    </div>
    <article class="index_notice">
      <div class="index_notice_inner">
        <header>お知らせ</header>
        <div>
          @foreach ($notices as $notice)
            <div>
              <div class="index_notice_header_wrap">
                <p class="index_notice_publish_date">{{ $notice->publish_date }}
                </p>
                <div>
                  <p class="index_notice_header">{{ $notice->header }}</p>
                  <p class="index_notice_content">{{ $notice->content }}</p>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
  </div>
  </article>
  <div>
    <p><a href="/public/recruit">公開中の募集</a></p>
    <p><a href="/public/school">学校検索</a></p>
    <p><a href="/inquiry/create">問い合わせ</a></p>
  </div>
</x-guest-layout>
