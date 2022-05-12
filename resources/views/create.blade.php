@extends('layouts.app')

@section('content')
    @include('partials.postform', ['action' => route('posts.store'), 'post' => null])
@endsection