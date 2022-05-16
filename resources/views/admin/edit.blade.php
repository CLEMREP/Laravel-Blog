@extends('layouts.app_blog')

@section('content')
    @include('partials.postform', ['action' => route('posts.update', ['post' => $post])])
@endsection
    