@extends('client.layouts.app')
@section('content')
<div class="header_height"></div>
<div class="breadcrumb_section">
   <div class="container">
      <div class="grid">
         <div class="grid__item one-whole">
            <div class="breadcrumb_item">
               <ul>
                  <li><a href="{{ route("client.home") }}" title="Back to the frontpage">Home</a></li>
                  <li><a class="text-black" href="" title="">Blog</a></li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="content">
    <!-- Content Start -->
    <div class="container">
       <div class="grid">
          <div class="grid__item three-twelfths small--one-whole medium--one-whole">
             <!-- /snippets/blog-sidebar.liquid -->
             <div class="sidebar_section">
                <div class="sidebar_item">
                   <h1>Search</h1>
                   <form action="/search" method="get" role="search">
                      <input type="search" id="search-input_blog" name="q" value="" placeholder="search..." required="">
                      <input type="hidden" name="type" value="article">
                   </form>
                </div>
                <div class="sidebar_item medium-down--hide">
                   <h1>Categories</h1>
                   <ul>
                    <li>
                        <a class="active" href="{{ route("client.blog","all") }}">All</a>
                    </li>
                        @if ($blog_categories->isNotEmpty())
                            @foreach ($blog_categories as $blog_category)
                                <li>
                                    <a class="{{ $categorySelected ==$blog_category->id ? 'active' : '' }}" href="{{ route("client.blog", $blog_category->slug) }}">{{ $blog_category->name }}</a>
                                </li>
                            @endforeach
                        @endif
                   </ul>
                </div>
             </div>
          </div>
          <div class="grid__item nine-twelfths small--one-whole medium--one-whole">
             <div class="blog_listing">
                <div class="blog_grid_list grid">
                    @if ($blogs->isNotEmpty())
                        @foreach ($blogs as $blog)
                            <div class="grid__item one-half small--one-whole medium--one-whole">
                                <div class="blog_item">
                                    <a href="{{ route("client.blogDetail", $blog->id) }}" class="blog_img">
                                        @if (!empty($blog->image))
                                            <img src="{{ asset('uploads/blog/thumb/'.$blog->image) }}"  >
                                        @else
                                            <img src="{{ asset('admin-asset/img/default-150x150.png') }}">
                                        @endif
                                    </a>
                                    <div class="blog_desc">
                                        <a href="{{ route("client.blogDetail", $blog->id) }}">{{ $blog->title }}</a>
                                        <h6>By <span>{{ $blog->author }}</span> On <span>{{ \Carbon\Carbon::parse($blog->created_at)->format('d-m-Y') }}</h6>
                                        <div class="content-blog-blog_page"> {!! $blog->content !!}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
             </div>
             <div class="pagination">
                {{ $blogs->withQueryString()->links('vendor.pagination.custom') }}
             </div>
             <!-- Pagination End -->
          </div>
       </div>
    </div>
</div>
@endsection
@section('customJs')

@endsection
