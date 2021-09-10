<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{-- もともとあった下の読み込みをコメントアウトする --}}
                {{-- <x-jet-welcome /> --}}

                {{-- そして以下を追加しました --}}
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                {{-- Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript development.
                                Check them out, see for yourself, and massively level up your development skills in the process. --}}
                                <li><a href="{{ url('/users') }}" class="text-lg text-gray-700 underline">ユーザー一覧画面</a></li>

                        </div>
                    </div>
                </div>

                    <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                            {{-- Laravel News is a community driven portal and newsletter aggregating all
                             of the latest and most important news in the Laravel ecosystem, including new package releases and tutorials. --}}

                             <li><a href="{{ url('/departments') }}" class="text-lg text-gray-700 underline">部署一覧画面</a></li>
                             <li><a href="{{ url('/employees') }}" class="text-lg text-gray-700 underline">従業員一覧画面</a></li>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</x-app-layout>
