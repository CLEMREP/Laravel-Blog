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
                <img src="{{ asset($post->image->path) }}" class="w-full object-cover lg:rounded" style="height: 28em;"/>
              @endif
            </div>
      
            <div class="flex flex-col">
      
              <div class="px-4 lg:px-0 mt-12 text-gray-700 text-lg leading-relaxed w-full mb-4">
                
                {!! $post->content !!}
      
              </div>
              <h2 class="mt-8 font-medium text-2xl mb-4">Les commentaires ({{ $post->comments->count() }})</h2>
              @if (Auth::check())
                <div> 
                  <form class="mb-4" action={{ route('comments.store', ['post' => $post]) }} method="POST">
                    @csrf
                    <div class="flex flex-row w-full">
                      <textarea name="content" class="@error('content') border-red-500 @enderror w-full rounded-l-lg p-2 border-t mr-0 border-b border-l text-gray-800 border-gray-200 bg-white" placeholder="Votre commentaire ...">{{ old('content') }}</textarea>
                      <button class="px-8 rounded-r-lg bg-blue-400  text-gray-800 font-bold p-4 uppercase border-blue-500 border-t border-b border-r">Publier</button>
                    </div>
                    @error('content')
                      <div class="mt-2 flex flex-row items-center justify-start font-medium text-red-500 mb-6">
                          <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg> 
                          <div>
                              {{ $message }}
                          </div>
                      </div>
                    @enderror
                  </form>
                </div>
              @else
              <div class="mt-2 flex flex-row items-center justify-start font-medium text-red-500 mb-6">
                <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg> 
                <div>
                    Vous devez être connecté pour publier un commentaire.
                </div>
            </div>
              @endif
              @foreach ($post->comments as $comment)
                <div class="mt-4 relative grid grid-cols-1 gap-4 p-4 mb-4 border rounded-lg bg-white shadow-lg">
                  <div class="relative flex gap-4">
                      <img src="https://icons.iconarchive.com/icons/diversity-avatars/avatars/256/charlie-chaplin-icon.png" class=" rounded-lg -top-8 -mb-4 bg-white border h-11 w-11" alt="" loading="lazy">
                      <div class="flex flex-col w-full">
                          <div class="flex flex-row justify-between">
                              <p class="relative text-xl whitespace-nowrap truncate overflow-hidden">Clément REPEL</p>
                              <a class="text-gray-500 text-xl" href="#"><i class="fa-solid fa-trash"></i></a>
                          </div>
                          <p class="text-gray-400 text-sm">Commenté le {{ $comment->created_at->format('d M Y') }} à {{ $comment->created_at->format('H\hi') }}</p>
                      </div>
                  </div>
                  <p class="mt-0.5 text-gray-500">{{ $comment->content }}</p>
                </div>
              @endforeach

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
                  <p class="mt-2 font-semibold text-gray-600 text-xs"> Publié le {{ $post->created_at->format('d M Y') }} à {{ $post->created_at->format('H\hi') }} </p>
                </div>
              </div>
      
            </div>
  </main>
@endsection
