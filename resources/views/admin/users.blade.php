<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} > Liste des utilisateurs
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white flex justify-center items-center">
                <div class="pb-4 px-4 rounded-md w-full">
                    <div class="flex items-center justify-between w-full pt-6 ">
                        <p class="ml-3"> Liste des utilisateurs</p>
                        <div class="flex justify-end px-2" x-data="{ 'showTri': false, 'showFilters' : false }" x-cloak>
                            <div class="flex flex-row items-center relative inline-block text-left">
                                <div class="inline-block relative mr-4">
                                    <form action="{{ route('admin.users.index', ['name' => Request::input('search_user')]) }}" method="get">
                                        <input type="text" name="search_user" class="leading-snug border border-gray-300 block w-full appearance-none bg-gray-100 text-sm text-gray-600 py-1 px-4 pl-8 rounded-lg" value="{{ Request::input('search_user') }}" placeholder="Search user" />
                                        <div class="pointer-events-none absolute pl-3 inset-y-0 left-0 flex items-center px-2 text-gray-300">
                                            <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.999 511.999">
                                                <path d="M508.874 478.708L360.142 329.976c28.21-34.827 45.191-79.103 45.191-127.309C405.333 90.917 314.416 0 202.666 0S0 90.917 0 202.667s90.917 202.667 202.667 202.667c48.206 0 92.482-16.982 127.309-45.191l148.732 148.732c4.167 4.165 10.919 4.165 15.086 0l15.081-15.082c4.165-4.166 4.165-10.92-.001-15.085zM202.667 362.667c-88.229 0-160-71.771-160-160s71.771-160 160-160 160 71.771 160 160-71.771 160-160 160z" />
                                            </svg>
                                        </div>
                                    </form>
                                </div>
                                <div class="mr-3">
                                  <button @click="showTri = true" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" id="menu-button" aria-expanded="true" aria-haspopup="true">
                                    Tri
                                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                      <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                  </button>
                                  <div x-show="showTri" tabindex="-1" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                        <div x-show="showTri" @click.away="showTri = false" class="py-1">
                                            @foreach ($filters as $filter)
                                                <a href="{{ route('admin.users.index', ['order' => $filter['order'], 'direction' => $filter['direction']]) }}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">{{ $filter['title'] }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <button @click="showFilters = true" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" id="menu-button" aria-expanded="true" aria-haspopup="true">
                                      Filtres
                                      <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                      </svg>
                                    </button>
                                    <div x-show="showFilters" tabindex="-1" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                          <div x-show="showFilters" @click.away="showFilters = false" class="py-1">
                                              <a href="{{ route('admin.users.index', ['admin' => '1']) }}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">Admin</a>
                                              <a href="{{ route('admin.users.index', ['admin' => '0']) }}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">Pas admin</a>
                                          </div>
                                      </div>
                                  </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto mt-6">
              
                        <table class="table-auto border-collapse w-full">
                            <thead>
                                <tr class="text-sm font-medium text-gray-700 text-left bg-gray-200" style="font-size: 0.9674rem">
                                    <th class="px-4 py-2">Username</th>
                                    <th class="px-4 py-2">E-Mail</th>
                                    <th class="px-4 py-2">Date de cr??ation</th>
                                    <th class="px-4 py-2">Admin</th>
                                    <th class="px-4 py-2">Modifier</th>
                                    <th class="px-4 py-2">Supprimer</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm font-normal text-gray-700">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-gray-50 border-b border-gray-200 py-10" x-data="{ 'showModal': false }" x-cloak>
                                        <td class="px-4 py-4">{{ $user->name }}</td>
                                        <td class="px-4 py-4">{{ $user->email }}</td>
                                        <td class="px-4 py-4">{{ $user->created_at }}</td>
                                        <td class="px-4 py-4">{{ $user->admin ? 'Oui' : 'Non' }}</td>
                                        <td class="px-4 py-4 w-1/12">
                                            <a href="{{ route('admin.users.edit', $user) }}">
                                                <button role="submit" class="rounded-sm py-2 px-3 bg-blue-500 text-white hover:bg-blue-400" required>Modifier</button>
                                            </a>    
                                        </td>
                                        <td class="px-4 py-4 w-1/12">
                                            <button @click="showModal = true" role="submit" class="rounded-sm py-2 px-3 bg-red-500 text-white hover:bg-red-400" required>Supprimer</button>

                                            <div x-show="showModal" tabindex="-1" class="z-10 overflow-y-auto overflow-x-hidden fixed flex justify-center items-center z-50 md:inset-0 h-modal md:h-full">
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                                    @csrf
                                                    <div class="relative p-4 w-full max-w-md h-full md:h-auto"
                                                    x-show="showModal" @click.away="showModal = false">
                                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                            <button @click="showModal = false" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="popup-modal">
                                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                                                            </button>
                                                            <div class="p-6 text-center">
                                                                <svg class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete "{{ $user->email }}" user?</h3>
                                                                
                                                                    <button role="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                                        Yes, I'm sure
                                                                    </button>
                                                                <button @click="showModal = false" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($users->count() == 0)
                            <div class="text-center text-gray-500 pb-2 flex h-[160px] justify-center items-center flex-col border-b border-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5 w-6 h-6 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="block mt-1">Pas de r??sultats</span></div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="mt-8">
                        <div class="flex">
                            {{ $users->appends(request()->all())->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>