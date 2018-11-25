@if ($paginator->hasPages())
<div class="col d-flex align-items-center">
    <div class="mr-auto p-2">
        <span class="display-items"></span>
    </div>
    <div class="p-2">
        <nav aria-label="...">
            <ul class="pagination">
              @if ($paginator->onFirstPage())
                <li class="page-item">
                    <a class="page-link" href="#"><i class="ion-chevron-left"></i></a>
                </li>
              @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}"><i class="ion-chevron-left"></i></a>
                </li>
              @endif

                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                              <li class="page-item active">
                                  <span class="page-link">{{ $page }}<span class="sr-only">(current)</span></span>
                              </li>
                            @else
                              <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                  <li class="page-item">
                      <a class="page-link" href="{{ $paginator->nextPageUrl() }}"><i class="ion-chevron-right"></i></a>
                  </li>
                @else
                  <li class="page-item">
                      <a class="page-link" href="#"><i class="ion-chevron-right"></i></a>
                  </li>
                @endif
            </ul>
        </nav>
    </div>
</div>
@endif
