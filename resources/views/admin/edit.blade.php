<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} > Édition de "{{ $post->title }}"
        </h2>
    </x-slot>

    @include('partials.postform', ['action' => route('admin.posts.update', ['post' => $post])])
</x-app-layout>