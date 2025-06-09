<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Edit Question') }} :: {{ $question->id }}
        </x-header>
    </x-slot>
    <x-container>
        <x-form :action="route('question.update', $question)" put>
            <x-textarea
                label="Question"
                name="question"
                placeholder="Ask me anything..."
                :value="$question->question"
            />
            <x-btn.primary>
                Save
            </x-btn.primary>
            <x-btn.cancel>
                Cancel
            </x-btn.cancel>
        </x-form>
    </x-container>
</x-app-layout>
