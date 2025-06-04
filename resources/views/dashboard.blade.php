<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Dashboard') }}
        </x-header>
    </x-slot>
    <x-container>
        <x-form post :action="route('question.store')">
            <x-textarea label="Question" name="question" placeholder="Ask me anything..." />

            <x-btn.primary>
                Save
            </x-btn.primary>
            <x-btn.cancel>
                Cancel
            </x-btn.cancel>
        </x-form>

        <hr class="my-4 border-dashed border-gray-700"/>

        <div class="mb-1 font-bold uppercase dark:text-gray-300">List of Questions</div>

        <div class="space-y-4 dark:text-gray-400">
            @foreach ($questions as $item)
                <x-question :question="$item"/>
            @endforeach
        </div>
    </x-container>
</x-app-layout>
