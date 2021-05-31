@extends('layout')
@section('title','Edit Document')
@section('content')

    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Document</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('document.update', $document->id) }}" method='POST'>
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title">Judul</label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ $document->title }}">
                            </div>
                            <div class="form-group">
                                <label for="editor">Konten</label>
                                <textarea class="form-control" id="editor" name="content">{!! $document->content !!}</textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary">Edit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
@section('script')
    <script>
        CKEDITOR.replace('content', {
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endsection