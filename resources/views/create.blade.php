@extends('layouts.app_blog')

@section('content')
    @include('partials.postform', ['action' => route('posts.store'), 'post' => null])
@endsection