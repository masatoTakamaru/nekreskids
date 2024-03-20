@if ($paginator->hasPages())
  @php
    $pagerSide = 2; //現在のページ番号の左右に表示するページの数
    $pagerCurrent = $paginator->currentPage();
    $pagerLast = $paginator->lastPage();
    $pagerPrev = 1;
    $pagerPrev = max(1, $pagerCurrent - 1);
    $pagerNext = min($pagerCurrent + 1, $pagerLast);
    $pagerTotal = $paginator->total();
    $pagerBegin = ($pagerCurrent - 1) * $paginator->perPage() + 1;
    $pagerEnd = $pagerBegin + $paginator->count() - 1;
    $pagerCountText = "{$pagerTotal}件中{$pagerBegin}～{$pagerEnd}件表示";
  @endphp
  <div class="pager">
    <div class="pager__button-first">
      <a class="pager__link" href="{{ $paginator->url(1) }}">最初</a>
    </div>
    <div class="pager__button-prev">
      <a class="pager__link" href="{{ $paginator->url($pagerPrev) }}">前へ</a>
    </div>
    @for ($i = 1; $i <= $pagerLast; $i++)
      @if ($i === $pagerCurrent)
        <div class="pager__button-current">
          <span class="pager__link">{{ $i }}</span>
        </div>
      @elseif (
          ($i >= $pagerCurrent - $pagerSide && $i <= $pagerCurrent + $pagerSide) ||
              ($i <= $pagerSide * 2 + 1 || $pagerLast - $i < $pagerSide * 2 + 1))
        <div class="pager__button">
          <a class="pager__link"
            href="{{ $paginator->url($i) }}">{{ $i }}</a>
        </div>
      @endif
    @endfor
    <div class="pager__button-next">
      <a class="pager__link" href="{{ $paginator->url($pagerNext) }}">次へ</a>
    </div>
    <div class="pager__button-last">
      <a class="pager__link" href="{{ $paginator->url($pagerLast) }}">最後</a>
    </div>
  </div>
  <div class="pager__counter">
    <span class="pager__counter-text">{{ $pagerCountText }}</span>
  </div>
@endif
