<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} > Mon compte
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white flex justify-center items-center">
                <div class="w-full">
                    <form class="bg-white p-10 rounded-lg shadow-lg min-w-full" action="{{ route('admin.account.update') }}" method="POST">
                        @csrf
                        <h1 class="text-center text-2xl mb-6 text-gray-600 font-bold font-sans">Mon compte</h1>
                        <div>
                            <label class="text-gray-800 font-semibold block my-3 text-md" for="username">Username</label>
                            <input class="@error('username') border-red-500 @enderror w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="text" name="username" id="username" placeholder="Username" value="{{ $user->name }}" />
                            @error('username')
                                <div class="mt-2 flex flex-row items-center justify-start font-medium text-red-500 mb-6">
                                    <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg> 
                                    <div>
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label class="text-gray-800 font-semibold block my-3 text-md" for="email">E-Mail</label>
                            <input class="@error('email') border-red-500 @enderror w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="text" name="email" id="email" placeholder="E-Mail" value="{{ $user->email }}" />
                            @error('email')
                                <div class="mt-2 flex flex-row items-center justify-start font-medium text-red-500 mb-6">
                                    <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg> 
                                    <div>
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label class="text-gray-800 font-semibold block my-3 text-md" for="password">Password</label>
                            <input class="@error('password') border-red-500 @enderror w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="password" name="password" id="password" placeholder="Password" value="{{ old('password') }}" />
                            @error('password')
                                <div class="mt-2 flex flex-row items-center justify-start font-medium text-red-500 mb-6">
                                    <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg> 
                                    <div>
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label class="text-gray-800 font-semibold block my-3 text-md" for="password_confirmation">Confirm Password</label>
                            <input class="@error('password_confirmation') border-red-500 @enderror w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="password" name="password_confirmation" id="confirm" placeholder="Password Confirmation" value="{{ old('password_confirmation') }}" />
                            @error('password_confirmation')
                                <div class="mt-2 flex flex-row items-center justify-start font-medium text-red-500 mb-6">
                                    <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg> 
                                    <div>
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="w-full mt-6 bg-indigo-600 hover:bg-indigo-700 rounded-lg px-4 py-2 text-lg text-white tracking-wide font-semibold font-sans">Modifier mon compte</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>