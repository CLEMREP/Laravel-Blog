@extends('layouts.app')

@section('content')
    @include('partials.postform', ['action' => route('posts.update', ['post' => $post])])
@endsection
    