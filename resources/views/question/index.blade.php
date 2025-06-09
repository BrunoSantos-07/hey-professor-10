<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('My questions') }}
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

        <hr class="my-4 border-dashed border-gray-700" />

        <div class="mb-1 font-bold uppercase dark:text-gray-300">
            Drafts
        </div>

        <x-table>
            <x-table.thead>
                <x-table.th>
                    Question
                </x-table.th>
                <x-table.th>
                    Actions
                </x-table.th>
            </x-table.thead>
            <tbody>
                @foreach ($questions->where('draft', true) as $question)
                    <x-table.tr>
                        <x-table.td>
                            {{ $question->question }}
                        </x-table.td>
                        <x-table.td>
                            <x-form :action="route('question.publish', $question)" put>
                                <button type="submit" class="houver:underline text-blue-500">Publish</button>
                            </x-form>
                            <x-form :action="route('question.destroy', $question)" delete>
                                <button type="submit" class="houver:underline text-red-500">Delete</button>
                            </x-form>

                            <a href="{{ route('question.edit', $question) }}" class="houver:underline text-blue-500">Edit</a>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </tbody>
        </x-table>

        <hr class="my-4 border-dashed border-gray-700" />

        <div class="mb-1 font-bold uppercase dark:text-gray-300">
            My Questions
        </div>

        <x-table>
            <x-table.thead>
                <x-table.th>
                    Question
                </x-table.th>
                <x-table.th>
                    Actions
                </x-table.th>
            </x-table.thead>
            <tbody>
                @foreach ($questions->where('draft', false)  as $question)
                    <x-table.tr>
                        <x-table.td>
                            {{ $question->question }}
                        </x-table.td>
                        <x-table.td>
                            <x-form :action="route('question.destroy', $question)" delete>
                                <button type="submit" class="houver:underline text-red-500">Delete</button>
                            </x-form>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </tbody>
        </x-table>
    </x-container>
</x-app-layout>
