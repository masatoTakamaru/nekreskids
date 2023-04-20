@if($paginator->hasPages())
<div class="pager">
  <div class="pager__button -prev">
    <a class="button__link" href="{{ $paginator->url(1) }}"></a>
  </div>
  @if($paginator->currentPage() > 1)
  <div class="pager__button -prev">
    <a class="button__link" href="{{ $paginator->url($paginator->currentPage() - 1) }}"></a>
  </div>
  @else
  <div class="pager__button -prev">
    <a class="button__link" href="{{ $paginator->url(1) }}"></a>
  </div>
  @endif
  @for ($i = 1; $i <= $paginator->lastPage(); $i++)
    @if($i == $paginator->currentPage())
    <div class="pager__num{{ $i === 1 ? ' -first' : '' }}">
      <span class="-current">{{ $i }}</span>
    </div>
    @elseif(
    ($i <= $paginator->currentPage() + 2 || $i - 1 < 5) && ($i>= $paginator->currentPage() - 2 ||
        $paginator->lastPage() - $i < 5)) <div class="pager__num{{ $i === 1 ? ' -first' : '' }}">
          <a class="button__link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
</div>
@endif
@endfor
@if($paginator->currentPage() < $paginator->lastPage())
  <div class="pager__button1 -next">
    <a class="button__link" href="{{ $paginator->url($paginator->currentPage() + 1) }}"></a>
  </div>
  @else
  <div class="pager__button1 -next">
    <a class="button__link" href="{{ $paginator->url($paginator->currentPage()) }}"></a>
  </div>
  @endif
  <div class="pager__button2 -next">
    <a class="button__link" href="{{ $paginator->url($paginator->lastPage()) }}"></a>
  </div>
  </div>
  <div class="pager__counter">{{ $paginator->total() }}件中{{($paginator->currentPage() - 1) *
    $paginator->perPage() + 1}}～{{ ($paginator->currentPage() - 1) * $paginator->perPage() + $paginator->count() }}件表示
  </div>
  @endif