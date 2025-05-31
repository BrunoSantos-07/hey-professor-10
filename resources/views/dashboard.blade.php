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
    </x-container>
</x-app-layout>
