<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Articles / Edit
            </h2>
            <a href="{{route('articles.index')}}" class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('articles.update', $articles->id)}}" method="POST">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Title</label>
                            <div class="my-3">
                                <input value="{{old('title', $articles->title)}}" placeholder="Title" type="text" name="title" id="title" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('title')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>

                            <label for="" class="text-lg font-medium">Content</label>
                            <div class="my-3">
                                <textarea placeholder="Content" class="border-gray-300 shadow-sm w-1/2 rounded-lg" name="text" id="text" cols="30" rows="10">{{old('text', $articles->text)}}</textarea>
                            </div>

                            <label for="" class="text-lg font-medium">Author</label>
                            <div class="my-3">
                                <input value="{{old('author', $articles->author)}}" placeholder="Author" type="text" name="author" id="author" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('author')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            <button class="bg-slate-700 hover:bg-slate-600 text-sm rounded-md px-5 py-3 text-white">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
