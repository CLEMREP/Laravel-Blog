@extends('layouts.app_blog')

@section('content')
    @include('partials.postform', ['action' => route('admin.posts.update', ['post' => $post])])
@endsection
    