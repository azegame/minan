<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            みんなのアンケート
        </h2>

    </x-slot>
    <div class="relative inline-flex justify-center ml-6 mt-6">
        <a href="{{ route('index', ['sort' => 'created_at']) }}" class="flex mx-auto text-white bg-indigo-300 border-0 py-2 px-4 mb-4 focus:outline-none hover:bg-indigo-300 rounded text-lg">作成日</a>
        <a href="{{ route('index', ['sort' => 'vote_counts']) }}" class="flex mx-auto text-white bg-indigo-300 border-0 py-2 px-4 mb-4 ml-4 focus:outline-none hover:bg-indigo-300 rounded text-lg">投票数</a>
    </div>

    <form class="w-auto">
        <div class="flex justify-end mr-6 mt-1">
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" id="search-box" name="search" class="block w-full p-6 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="タイトル検索" required>
                <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">検索</button>
            </div>
        </div>
    </form>

    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <a href="{{ route('questionnaires.create') }}" class="flex mx-auto text-white bg-indigo-300 border-0 py-2 px-4 mb-4 focus:outline-none hover:bg-indigo-400 rounded text-lg w-1/2">アンケートを作成する</a>
            @if(Auth::user() != null)
            <a href="{{ route('questionnaires.mine') }}" class="flex mx-auto text-white bg-stone-300 border-0 py-2 px-4 mb-4 focus:outline-none hover:bg-stone-400 rounded text-lg w-1/2">わたしのアンケート</a>
            @endif

            <div class="flex flex-wrap -m-4">
                @foreach($questionnaires as $questionnaire)
                <div class="xl:w-1/4 md:w-1/2 p-4">
                    <div class="bg-sky-200 p-6 rounded-lg">
                        <!-- <img class="h-40 rounded w-full object-cover object-center mb-6" src="https://dummyimage.com/720x400" alt="content"> -->
                        <h3 class="tracking-widest text-blue-500 text-xs font-medium title-font">
                            <a href="{{ route('questionnaires.show', $questionnaire->id) }}">投票する</a>
                        </h3>
                        <h2 class="text-lg text-gray-900 font-medium title-font">{{ $questionnaire->questionnaire_name }}</h2>
                        <h2 class="text-sm text-gray-900 font-medium ">作成者：{{ $questionnaire->user->name  }}</h2>
                        <h2 class="text-sm text-gray-900 font-medium ">投票された数：{{ $voteCounts[$questionnaire->id] ?? '？'  }}</h2>
                        <h2 class="text-sm text-gray-900 font-medium ">作成日：{{ $questionnaire->created_at }}</h2>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>