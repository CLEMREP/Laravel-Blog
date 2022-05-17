<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ mix('js/app.js') }}" defer></script>
        <title>Laravel Blog - {{!empty($title) ? $title : ''}}</title>
    </head>
    <body>
        <main class="bg-white font-montserrat">
            <header class="h-24 sm:h-32 flex items-center">
                <div class="container mx-auto px-6 sm:px-12 flex items-center justify-between">
                    <div class="text-black font-black text-2xl flex items-center">
                        <span class="w-6 h-6 rounded-full bg-blue-500 mr-4"></span> Laravel Blog
                    </div>
                    <div class="flex items-center">
                        <nav class="text-black text-lg hidden lg:flex items-center">
                            <a href="{{ route('index') }}" class="py-2 px-6 flex hover:text-blue-500">
                                Accueil
                            </a>
                            <a href="{{ route('posts.index') }}" class="py-2 px-6 flex hover:text-blue-500">
                                Blog
                            </a>
                            @if (Auth::check())
                                <a href="{{ route('account.edit') }}" class="py-2 px-6 flex text-blue-500">
                                    Bonjour, {{ Auth::user()->name }} !
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="py-2 px-6 flex text-blue-500">
                                    Connexion
                                </a>
                            @endif
                        </nav>
                        <button class="lg:hidden flex flex-col">
                            <span class="w-6 h-px bg-gray-900 mb-1"></span>
                            <span class="w-6 h-px bg-gray-900 mb-1"></span>
                            <span class="w-6 h-px bg-gray-900 mb-1"></span>
                        </button>
                    </div>
                </div>
            </header>
            @yield('content')
        </main>
    </body>
</html>
