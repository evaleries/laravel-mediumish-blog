@extends('layouts.default')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush

@section('content')

    <!-- Begin Site Title
    ================================================== -->
    <div class="container">
        <div class="mainheading">
            <h1 class="sitetitle">Edit Artikel - {{ $article->title }}<h1>
            <p class="lead">
                Ubah artikel
            </p>
        </div>
    <!-- End Site Title
    ================================================== -->

        <!-- Begin List Posts
        ================================================== -->
        <section class="recent-posts">
        <div class="section-title">
            <h2><span>Ubah Artikel</span></h2>
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
                    <form method="post" id="edit-form" action="{{ route('post.update', $article->id) }}">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" class="form-control" id="author" name="author" aria-describedby="authorHelp" placeholder="evaleries" value="{{ old('author', $article->author) }}" required>
                            <small id="authorHelp" class="form-text text-muted">Gunakan username github.</small>
                        </div>
                        <div class="form-group">
                            <label for="author_image">Author Image</label>
                            <input type="text" class="form-control" name="author_image" id="author_image" aria-describedby="authorImageHelp" placeholder="https://avatars1.githubusercontent.com/u/48923153?s=50&v=4" value="{{ old('author_image', $article->author_image) }}" required>
                            <small id="authorImageHelp" class="form-text text-muted">Masukkan link gambar dari profile github anda.</small>
                        </div>
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Judul artikel" value="{{ old('title', $article->title) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="article_image">Gambar Artikel</label>
                            <input type="text" class="form-control" name="article_image" id="article_image" placeholder="Gambar artikel" value="{{ old('article_image', $article->article_image) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="author_image">Konten</label>
                            <textarea id="summernote" name="content" rows="20" class="form-control"></textarea>
                        </div>
                        <button type="submit" role="button" class="btn btn-primary">Save</button>
                        <button type="button" role="button" id="delete" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
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
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana', 'Merriweather'],
            fontNamesIgnoreCheck: ['Merriweather']
        });
        $('#summernote').summernote('fontName', 'Merriweather');
        $('#summernote').summernote('code', '{!! $article->content !!}');
        $('#delete').on('click', function (e) {
            if (confirm('Yakin ingin menghapus artikel?')) {
                $('input[name=_method]').val('DELETE');
                $('#edit-form').attr('action', '{{ route('post.destroy', $article->id) }}');
                document.getElementById('edit-form').submit();
            }
        });
    });
    </script>
@endpush
