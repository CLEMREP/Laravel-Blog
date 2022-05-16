@extends('layouts.app_blog')

@section('content')
<div class="px-6 py-8">
    <div class="container flex justify-between mx-auto">
        <div class="w-full lg:w-8/12">
            @foreach ($posts as $post)
                <div x-data="{ 'showModal': false }" x-cloak class="mt-6">
                    <div class="max-w-4xl px-10 py-6 mx-auto bg-white rounded-lg shadow-md">
                        <div class="flex items-center justify-between">
                            <span class="font-light text-gray-600">{{ $post->created_at }}</span>
                            <div class="flex items-center">
                                @if ($post->published)
                                    <span class="px-2 py-1 font-bold text-green-100 bg-green-600 rounded hover:bg-green-500 mr-2">ON</span>
                                @else
                                    <span class="px-2 py-1 font-bold text-red-100 bg-red-600 rounded hover:bg-red-500 mr-2">OFF</span>
                                @endif
                                
                                <a href="{{ route('admin.posts.edit', $post) }}" class="px-2 py-1 font-bold text-gray-100 bg-gray-600 rounded hover:bg-gray-500 mr-2">Edit</a>
                                <button @click="showModal = true" class="block text-white bg-red-700 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-red-300 px-2 py-1 font-bold text-red-100 bg-red-600 rounded hover:bg-red-500" type="button">
                                    Delete
                                </button>
                            
                                <div x-show="showModal" tabindex="-1" class="z-10 overflow-y-auto overflow-x-hidden fixed flex justify-center items-center z-50 md:inset-0 h-modal md:h-full">
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST">
                                        @csrf
                                        <div class="relative p-4 w-full max-w-md h-full md:h-auto"
                                        x-show="showModal" @click.away="showModal = true">
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                <button @click="showModal = false" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="popup-modal">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                                                </button>
                                                <div class="p-6 text-center">
                                                    <svg class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete "{{ $post->title }}" post?</h3>
                                                    
                                                        <button role="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                            Yes, I'm sure
                                                        </button>
                                                    <button @click="showModal = false" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4"><a href="{{ route('admin.posts.show', ['post' => $post]) }}" class="text-2xl font-bold text-gray-700 hover:underline">{{ $post->title }}</a>
                        </div>
                        <div class="flex items-center justify-between mt-4"><a href="#"
                                class="text-blue-500 hover:underline">En savoir plus</a>
                            <div><a href="#" class="flex items-center"><img
                                        src="https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=731&amp;q=80"
                                        alt="avatar" class="hidden object-cover w-10 h-10 mx-4 rounded-full sm:block">
                                    <h1 class="font-bold text-gray-700 hover:underline">Alex John</h1>
                                </a></div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="mt-8">
                <div class="flex">
                    {{ $posts->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
        <div class="hidden w-4/12 -mx-8 lg:block">
            <div class="px-8">
                <h1 class="mb-4 text-xl font-bold text-gray-700">Authors</h1>
                <div class="flex flex-col max-w-sm px-6 py-4 mx-auto bg-white rounded-lg shadow-md">
                    <ul class="-mx-4">
                        <li class="flex items-center"><img
                                src="https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=731&amp;q=80"
                                alt="avatar" class="object-cover w-10 h-10 mx-4 rounded-full">
                            <p><a href="#" class="mx-1 font-bold text-gray-700 hover:underline">Alex John</a><span
                                    class="text-sm font-light text-gray-700">Created 23 Posts</span></p>
                        </li>
                        <li class="flex items-center mt-6"><img
                                src="https://images.unsplash.com/photo-1464863979621-258859e62245?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=333&amp;q=80"
                                alt="avatar" class="object-cover w-10 h-10 mx-4 rounded-full">
                            <p><a href="#" class="mx-1 font-bold text-gray-700 hover:underline">Jane Doe</a><span
                                    class="text-sm font-light text-gray-700">Created 52 Posts</span></p>
                        </li>
                        <li class="flex items-center mt-6"><img
                                src="https://images.unsplash.com/photo-1531251445707-1f000e1e87d0?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=281&amp;q=80"
                                alt="avatar" class="object-cover w-10 h-10 mx-4 rounded-full">
                            <p><a href="#" class="mx-1 font-bold text-gray-700 hover:underline">Lisa Way</a><span
                                    class="text-sm font-light text-gray-700">Created 73 Posts</span></p>
                        </li>
                        <li class="flex items-center mt-6"><img
                                src="https://images.unsplash.com/photo-1500757810556-5d600d9b737d?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=735&amp;q=80"
                                alt="avatar" class="object-cover w-10 h-10 mx-4 rounded-full">
                            <p><a href="#" class="mx-1 font-bold text-gray-700 hover:underline">Steve Matt</a><span
                                    class="text-sm font-light text-gray-700">Created 245 Posts</span></p>
                        </li>
                        <li class="flex items-center mt-6"><img
                                src="https://images.unsplash.com/photo-1502980426475-b83966705988?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=373&amp;q=80"
                                alt="avatar" class="object-cover w-10 h-10 mx-4 rounded-full">
                            <p><a href="#" class="mx-1 font-bold text-gray-700 hover:underline">Khatab
                                    Wedaa</a><span class="text-sm font-light text-gray-700">Created 332 Posts</span>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="px-8 mt-10">
                <h1 class="mb-4 text-xl font-bold text-gray-700">Categories</h1>
                <div class="flex flex-col max-w-sm px-4 py-6 mx-auto bg-white rounded-lg shadow-md">
                    <ul>
                        <li><a href="#" class="mx-1 font-bold text-gray-700 hover:text-gray-600 hover:underline">-
                                AWS</a></li>
                        <li class="mt-2"><a href="#"
                                class="mx-1 font-bold text-gray-700 hover:text-gray-600 hover:underline">-
                                Laravel</a></li>
                        <li class="mt-2"><a href="#"
                                class="mx-1 font-bold text-gray-700 hover:text-gray-600 hover:underline">- Vue</a>
                        </li>
                        <li class="mt-2"><a href="#"
                                class="mx-1 font-bold text-gray-700 hover:text-gray-600 hover:underline">-
                                Design</a></li>
                        <li class="flex items-center mt-2"><a href="#"
                                class="mx-1 font-bold text-gray-700 hover:text-gray-600 hover:underline">-
                                Django</a></li>
                        <li class="flex items-center mt-2"><a href="#"
                                class="mx-1 font-bold text-gray-700 hover:text-gray-600 hover:underline">- PHP</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection