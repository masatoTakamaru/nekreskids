<x-guest-layout>
  <article>
    <div>
      welcome!
    </div>
    @if (!empty($objData))
      @foreach ($objData as $item)
        <img src="{{ $item->url }}">
      @endforeach
    @endif
  </article>
</x-guest-layout>
