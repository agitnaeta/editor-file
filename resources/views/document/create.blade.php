@extends('layout')
@section('title','Tambah Document')
@section('content')

    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Document</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('document.store') }}" method='POST'>
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title">Judul</label>
                                <input type="text" class="form-control" name="title" id="title">
                            </div>
                            <div class="form-group">
                                <label for="content">Konten</label>
                                <textarea class="form-control" id="content" name="content"></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary">Tambah</button>
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
        // CKEDITOR.replace('content', {
        //     filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
        //     filebrowserUploadMethod: 'form'
        // });

        $( 'textarea#content' ).ckeditor({
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        
        // $(document).ready(function() {
        //     $( 'textarea#content' ).val( `<video width="320" height="240" controls>
        //             <source src="{{ asset('video/mov_bbb.mp4') }}" type="video/mp4">
        //             Your browser does not support the video tag.
        //             </video>` );
        // });

    </script>
@endsection