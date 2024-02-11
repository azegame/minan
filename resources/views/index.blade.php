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
                        <h2 class="text-lg text-gray-900 font-medium title-font mb-4">{{ $questionnaire->questionnaire_name }}</h2>
                        <h2 class="text-sm text-gray-900 font-medium ">作成者：{{ $user->name  }}</h2>
                        <h2 class="text-sm text-gray-900 font-medium ">投票された数：{{ $voteCounts[$questionnaire->id] ?? '？'  }}</h2>
                        <h2 class="text-sm text-gray-900 font-medium ">作成日：{{ $questionnaire->created_at }}</h2>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>