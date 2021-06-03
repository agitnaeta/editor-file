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
                        <form action="{{ route('document.update', $id) }}" method='POST'>
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title">Judul</label>
                                <input type="text" class="form-control" name="title" id="title" value="">
                            </div>
                            <div class="form-group">
                                <label for="content">Konten</label>
                                <textarea class="form-control" id="content" name="content"></textarea>
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
        $(document).ready(function() {
            $.get( "{{ route('document.get', $id) }}", function( data ) {
                $('#title').val(data.title);
                CKEDITOR.instances.content.insertHtml(data.content);
            });
        });
    </script>
@endsection