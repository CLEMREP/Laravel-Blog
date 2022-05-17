<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} > Édition de {{ $user->email }}
        </h2>
    </x-slot>

    @include('partials.userform', ['action' => route('admin.users.update', ['user' => $user])])
</x-app-layout>