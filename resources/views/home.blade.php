@extends('layouts.default')

@section('content')
    <!-- Begin Site Title
    ================================================== -->
    <div class="container">
        <div class="mainheading">
            <h1 class="sitetitle">{{ config('blog.title') }}</h1>
            <p class="lead">
                {{ config('blog.description') }}
            </p>
        </div>
    <!-- End Site Title
    ================================================== -->

        <!-- Begin List Posts
        ================================================== -->
        <section class="recent-posts">
        <div class="section-title">
            <h2><span>All posts</span></h2>
        </div>
            <div class="card-columns listrecent">

                <!-- begin posts -->
                @foreach ($articles as $article)
                <div class="card">
                    <a href="{{ route('post.show', [$article->id, $article->slug]) }}">
                        <img class="img-fluid" src="{{ $article->article_image }}" alt="">
                    </a>
                    <div class="card-block">
                        <h2 class="card-title"><a href="{{ route('post.show', [$article->id, $article->slug]) }}">{{ $article->title }}</a></h2>
                        <h4 class="card-text">{{ str_limit(strip_tags($article->content), 100) }}</h4>
                        <div class="metafooter">
                            <div class="wrapfooter">
                                <span class="meta-footer-thumb">
                                    <a href="https://github.com/{{ $article->author }}"><img class="author-thumb" src="{{ $article->author_image }}" alt="{{ $article->auhtor }}"></a>
                                </span>
                                <span class="author-meta">
                                    <span class="post-name">{{ $article->author }}</span><br/>
                                    <span class="post-date">{{ now()->createFromTimestamp($article->created_at)->format('d F Y') }}</span>
                                </span>
                                <span class="post-read-more">
                                <a href="{{ route('post.edit', [$article->id]) }}" title="Edit Article">
                                    <svg class="svgIcon-use" width="25" height="25" viewbox="0 0 25 25">
                                        <image xlink:href="{{ asset('img/edit.svg') }}" width="20" height="20"/>    
                                    </svg>
                                </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- end posts -->

            </div>
        </section>
        <!-- End List Posts
        ================================================== -->

        @include('components.footer')

    </div>
    <!-- /.container -->

@endsection
