<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/utility.css') }}">
</head>

<body>

    @if ($paginator->hasPages())
    <ol class="product__pagination u-flex">

        {{-- Prev --}}
        @if ($paginator->onFirstPage())
        <li class="product__pagination-item product__pagination-item--disabled">
            <span class="product__pagination-link">
                <
            </span>
        </li>
        @else
        <li class="product__pagination-item product__pagination-item--prev">
            <a href="{{ $paginator->previousPageUrl() }}" class="product__pagination-link">
                <
            </a>
        </li>
        @endif

        {{-- Page numbers --}}
        @foreach ($elements as $element)

        @if (is_string($element))
        <li class="product__pagination-item product__pagination-item--disabled">
            <span class="product__pagination-link">{{ $element }}</span>
        </li>
        @endif

        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="product__pagination-item product__pagination-item--current">
            <span class="product__pagination-link">{{ $page }}</span>
        </li>
        @else
        <li class="product__pagination-item">
            <a href="{{ $url }}" class="product__pagination-link">{{ $page }}</a>
        </li>
        @endif
        @endforeach
        @endif

        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
        <li class="product__pagination-item product__pagination-item--next">
            <a href="{{ $paginator->nextPageUrl() }}" class="product__pagination-link">></a>
        </li>
        @else
        <li class="product__pagination-item product__pagination-item--disabled">
            <span class="product__pagination-link">></span>
        </li>
        @endif

    </ol>
    @endif

</body>

</html>