@extends('layout')
@section('title', $document->title)
@section('content')

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>{{ $document->title }}</h3>
            </div>
            <div class="card-body">
                {!! $document->content !!}
            </div>
        </div>
    </div>

@endsection
@section('script')
@endsection