@if ($paginator->hasPages())
    <div class="flex justify-between">
        {{-- 前のページ --}}
        @if ($paginator->onFirstPage())
            <span class="disabled" aria-disabled="true">&#9664;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">&#9664;</a>
        @endif

        {{-- ページ番号 --}}
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="current">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- 次のページ --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">&#9654;</a>
        @else
            <span class="disabled" aria-disabled="true">&#9654;</span>
        @endif
    </div>
@endif
