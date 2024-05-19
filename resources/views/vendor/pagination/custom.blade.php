<style>
.pagination {
  text-align: center;
  margin-top: 25px;
}

.pagination ul {
  list-style: none;
  border-bottom: 2px solid #f0f0f0;
  padding-bottom: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  padding-left: 0;
}

.pagination ul li {
  width: 30px;
  margin: 0 5px; /* Adjust the margin as needed */
  display: flex;
  justify-content: center;
  align-items: center;
}

.pagination ul li a,
.pagination ul li span {
  display: block;
  padding: 8px 12px;
  text-align: center;
  color: #333;
  line-height: 28px;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.4s ease-in-out;
  border-radius: 4px;
  border: 1px solid transparent;
}
/* .pagination ul li a */
.pagination ul li.active_page > span {
    color: #d63612 !important;
    padding: 8px 12px;
    margin-left: -15px;
}
.pagination ul li a:hover {
  color: #d63612;
}

.pagination ul li a.active_page {
  padding: 8px 12px;
  color: #d63612 !important;
  border-color: #d63612;
  background-color: #f0f0f0; /* Optional: Add background color for active page */
}

.pagination ul li.disabled span {
  color: #ccc;
  cursor: not-allowed;
}

.pagination ul li a.prev_page,
.pagination ul li a.next_page {
  width: 25px;
  height: 25px;
  text-align: center;
  border-radius: 50%;
  border: 1px solid #efefef;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 12px;
}
.pagination ul li a.next_page {
    margin-left: -5px;
}

.pagination ul li a.prev_page:hover,
.pagination ul li a.next_page:hover {
  background: none;
  border-color: #d63612;

}

.pagination ul li a.prev_page i,
.pagination ul li a.next_page i {
  margin: 0;
}




</style>
@if ($paginator->hasPages())
    <div class="pagination">
        <ul>
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled"><span><i class="fa fa-angle-left"></i></span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" class="prev_page" rel="prev"><i class="fa fa-angle-left"></i></a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active_page"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li style="margin-left: -12px;"><a href="{{ $paginator->nextPageUrl() }}" class="next_page" rel="next"><i class="fa fa-angle-right"></i></a></li>
            @else
                <li class="disabled"><span><i class="fa fa-angle-right"></i></span></li>
            @endif
        </ul>
    </div>
@endif
