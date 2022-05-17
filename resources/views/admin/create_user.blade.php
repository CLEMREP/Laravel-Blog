<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} > Création d'un utilisateur
        </h2>
    </x-slot>

    @include('partials.userform', ['action' => route('admin.users.store'), 'user' => null])
</x-app-layout>