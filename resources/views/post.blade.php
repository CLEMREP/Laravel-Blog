@extends('layouts.app_blog')

@section('content')
<main class="mt-10">

    <div class="mb-4 md:mb-0 w-full max-w-screen-md mx-auto relative" style="height: 24em;">
      

            <div class="mb-4 md:mb-0 w-full mx-auto relative">
              <div class="px-4 lg:px-0">
                <h2 class="text-4xl font-semibold text-gray-800 leading-tight mb-4">
                  {{ $post->title }}
                </h2>
                {{-- <a 
                  href="#"
                  class="py-2 text-green-700 inline-flex items-center justify-center mb-2"
                >
                  Cryptocurrency
                </a> --}}
              </div>
              @if (!is_null($post->image))
                <img src="{{ '../' . $post->image->path }}" class="w-full object-cover lg:rounded" style="height: 28em;"/>
              @endif
            </div>
      
            <div class="flex flex-col">
      
              <div class="px-4 lg:px-0 mt-12 text-gray-700 text-lg leading-relaxed w-full mb-4">
                
                {!! $post->content !!}
      
              </div>
      
              <div class="w-full mb-8">
                <div class="p-4 flex flex-col w-1/3 py-2 border-t border-b md:border md:rounded">
                    <div class="flex flex-row">
                        <img src="https://randomuser.me/api/portraits/men/97.jpg"
                        class="h-10 w-10 rounded-full mr-2 object-cover" />
                      <div>
                        <p class="font-semibold text-gray-700 text-sm"> Mike Sullivan </p>
                        <p class="font-semibold text-gray-600 text-xs"> Editor </p>
                      </div>
                    </div>
                  <p class="mt-2 font-semibold text-gray-600 text-xs"> Crée le {{ $post->created_at->format('d/m/y') }} à {{ $post->created_at->format('H:i') }} </p>
                </div>
              </div>
      
            </div>
  </main>
@endsection