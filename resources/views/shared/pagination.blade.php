<?php
/**
 * Billing Cinerama.
 *
 * @author  Muzaffardjan Karaev
 * @link    https://karaev.uz
 * Created: 13.09.2019 / 19:10
 */
/**
 * @var \Illuminate\Pagination\LengthAwarePaginator $paginator
 */
?>

@if($paginator->hasPages())
    <ul class="pagination pagination-flat align-self-center mt-3 mb-3">
        @if($paginator->onFirstPage())
            <li class="page-item disabled">
                <a href="javascript:void(0);" class="page-link" aria-label="Предыдущий">
                    <i class="icon-arrow-left12"></i>
                    Предыдущий
                </a>
            </li>
        @else
            <li class="page-item">
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link" aria-label="Предыдущий">
                    <i class="icon-arrow-left12"></i>
                    Предыдущий
                </a>
            </li>
        @endif

        @foreach($elements as $element)
            @if(is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif

            @if(is_array($element))
                @foreach($element as $page => $url)
                    @if($paginator->currentPage() === $page)
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Следующий">
                    Следующий
                    <i class="icon-arrow-right13"></i>
                </a>
            </li>
        @else
            <li class="page-item disabled">
                <a class="page-link" href="javascript:void(0)" aria-label="Следующий">
                    Следующий
                    <i class="icon-arrow-right13"></i>
                </a>
            </li>
        @endif
    </ul>
@endif
