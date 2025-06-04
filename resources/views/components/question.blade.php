@props([
    'question'
])

<div class="flex items-center justify-between rounded p-3 shadow shadow-blue-500/50 dark:bg-gray-800/50 dark:text-gray-400">
    <span>{{ $question->question }}</span>
    <div>
        <x-form :action="route('question.like', $question)">
            <button class="flex items-start space-x-1">
                <x-icons.thumb-up id="thumb-up" class="houver:text-green-300 h-5 w-5 cursor-pointer text-green-500"/>
                <span>{{ $question->votes_sum_like ?: 0 }}</span>
            </button>
        </x-form>
        <x-form :action="route('question.unlike', $question)">
            <button class="flex items-start space-x-1">
                <x-icons.thumb-down id="thumb-down" class="houver:text-red-300 h-5 w-5 cursor-pointer text-red-500"/>
                <span>{{ $question->votes_sum_unlike ?: 0 }}</span>
            </button>
        </x-form>
    </div>
</div>