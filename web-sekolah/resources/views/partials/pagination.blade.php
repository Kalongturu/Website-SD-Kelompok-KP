@if ($paginator->hasPages())
    <nav class="pagination-nav" aria-label="Navigasi Halaman">
        {{-- Tombol Sebelumnya --}}
        @if ($paginator->onFirstPage())
            <span class="page-btn disabled" aria-disabled="true">&#8249;</span>
        @else
            <a class="page-btn" href="{{ $paginator->previousPageUrl() }}" aria-label="Halaman Sebelumnya">&#8249;</a>
        @endif

        {{-- Nomor Halaman --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="page-btn dots">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-btn active" aria-current="page">{{ $page }}</span>
                    @else
                        <a class="page-btn" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Tombol Berikutnya --}}
        @if ($paginator->hasMorePages())
            <a class="page-btn" href="{{ $paginator->nextPageUrl() }}" aria-label="Halaman Berikutnya">&#8250;</a>
        @else
            <span class="page-btn disabled" aria-disabled="true">&#8250;</span>
        @endif
    </nav>
@endif
