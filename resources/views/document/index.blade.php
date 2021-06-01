@extends('layout')
@section('title','Document')
@section('content')
    
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4>Document</h4>
                        <a href="{{ route('document.create') }}" class="btn btn-primary">Tambah</a>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Judul</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documents as $document)
                                    <tr>
                                        <td>{{ $document->created_at }}</td>
                                        <td>{{ $document->title }}</td>
                                        <td>
                                            <a href="{{ route('document.show', $document->id) }}" class="btn btn-success">Lihat</a>
                                            <a href="{{ route('document.edit', $document->id) }}" class="btn btn-warning">Edit</a>
                                            <a href="{{ route('document.destroy', $document->id) }}" class="btn btn-danger">Hapus</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="container">
                            <div class="col-md-12 justify-content-center d-flex p-10">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <li class="page-item">
                                            <a class="page-link" href="{{$documents->links()->paginator->previousPageUrl()}}">
                                                <i class="fa fa-backward" aria-hidden="true"></i>
                                            </a>
                                        </li>

                                        @foreach($documents->links()->elements as $element)
                                        <!-- "Three Dots" Separator -->
                                            @if (is_string($element))
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="#">{{$element}}</a>
                                                </li>
                                            @endif

                                        <!-- Array Of Links -->
                                            @if (is_array($element))
                                                @foreach ($element as $page => $url)
                                                    @if ($page == $documents->links()->paginator->currentPage())
                                                        <li class="page-item active">
                                                            <a class="page-link" href="#">{{$page}}</a>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a class="page-link" href="{{$url}}">{{$page}}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach

                                        @if($documents->links()->paginator->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{$documents->links()->paginator->nextPageUrl()}}">
                                                    <i class="fa fa-forward"></i>
                                                </a>
                                            </li>
                                        @endif

                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
@endsection