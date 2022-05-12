<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form method="POST" action="{{ $action }}">
                    @csrf
                    <div class="mb-4">
                        <label class="text-xl text-gray-600">Title <span class="text-red-500">*</span></label></br>
                        <input type="text" class="border-2 border-gray-300 p-2 w-full @error('title') border-red-500 @enderror" name="title" id="title" value="{{ $post ? $post->title : old('title') }}">
                        @error('title')
                            <div class="flex flex-row items-center font-medium text-red-500 mt-2">
                                <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg> 
                                <div>
                                    {{ $message }}
                                </div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="text-xl text-gray-600">Content <span class="text-red-500">*</span></label></br>
                        <textarea name="content" class="border-2 border-gray-500">
                            {{ $post ? $post->content : old('content') }}
                        </textarea>
                    </div>
                    @error('content')
                        <div class="flex flex-row items-center font-medium text-red-500 mb-6">
                            <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg> 
                            <div>
                                {{ $message }}
                            </div>
                        </div>
                    @enderror
                    

                    


                    <div class="flex mb-4 justify-between w-full">
                        <div class="items-center">
                            <label class="text-xl text-gray-600">Status <span class="text-red-500">*</span></label></br>
                            <div class="inline-block relative w-64">
                                <select name="published" class="block appearance-none w-full bg-white border-2 border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="0">Not Published</option>
                                    <option value="1"
                                    @if (old('published') || (!is_null($post) && $post->published))
                                        selected
                                    @endif>Published</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                        <label class="flex items-end">
                            <input type="file" class="block w-full text-sm text-slate-500 border-2 border-gray-300
                              file:mr-4 file:py-2 file:px-4
                              file:border-0
                              file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700
                              hover:file:bg-blue-100
                            "/>
                        </label>
                    </div> 

                    <div class="flex p-1">
                        <button role="submit" class="p-3 bg-blue-500 text-white hover:bg-blue-400" required>Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace( 'content' );
</script>