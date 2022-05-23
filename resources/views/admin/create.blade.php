<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} > Création d'un article
        </h2>
    </x-slot>

    @include('partials.postform', ['action' => route('admin.posts.store'), 'post' => null])
</x-app-layout>