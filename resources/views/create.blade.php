@extends('layouts.default')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush

@section('content')

    <!-- Begin Site Title
    ================================================== -->
    <div class="container">
        <div class="mainheading">
            <h1 class="sitetitle">Buat Artikel Baru - {{ config('blog.title') }}<h1>
            <p class="lead">
                Buat artikel baru untuk memperkaya konten diblog ini.
            </p>
        </div>
    <!-- End Site Title
    ================================================== -->

        <!-- Begin List Posts
        ================================================== -->
        <section class="recent-posts">
        <div class="section-title">
            <h2><span>Buat Artikel</span></h2>
        </div>
            <div class="row">
                <div class="col-12">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{ route('post.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" class="form-control" id="author" name="author" aria-describedby="authorHelp" placeholder="evaleries" value="{{ old('author', 'evaleries') }} " required>
                            <small id="authorHelp" class="form-text text-muted">Gunakan username github.</small>
                        </div>
                        <div class="form-group">
                            <label for="author_image">Author Image</label>
                            <input type="text" class="form-control" name="author_image" id="author_image" aria-describedby="authorImageHelp" placeholder="https://avatars1.githubusercontent.com/u/48923153?s=50&v=4" value="{{ old('author_image', 'https://avatars1.githubusercontent.com/u/48923153?s=50&v=4') }}" required>
                            <small id="authorImageHelp" class="form-text text-muted">Masukkan link gambar dari profile github anda.</small>
                        </div>
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Judul artikel" value="{{ old('title') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="article_image">Gambar Artikel</label>
                            <input type="text" class="form-control" name="article_image" id="article_image" placeholder="Gambar artikel" value="{{ old('article_image') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="author_image">Konten</label>
                            <textarea id="summernote" name="content" rows="20" class="form-control">{{ old('content') }}</textarea>
                        </div>
                        <button type="submit" role="button" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </section>
        <!-- End List Posts
        ================================================== -->

        @include('components.footer')

    </div>
    <!-- /.container -->

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 250,
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana', 'Righteous'],
            fontNamesIgnoreCheck: ['Merriweather']
        });
        $('#summernote').summernote('fontName', 'Merriweather');

    });
    </script>
@endpush
