<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, put};

it('should update the question in the database', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
                ->for($user, 'createdBy')
                ->create(['draft' => true]);

    actingAs($user);

    put(route('question.update', $question), [
        'question' => 'Updated Question?',
    ])->assertRedirect();

    $question->refresh();

    expect($question)
        ->question->toBe('Updated Question?');
});

it('should make sure that only question with status DRAFT can be update', function () {
    $user = User::factory()->create();

    $questionNotDraft = Question::factory()->for($user, 'createdBy')
                                    ->create(['draft' => false]);
    $draftQuestion = Question::factory()->for($user, 'createdBy')
                                    ->create(['draft' => true]);

    actingAs($user);

    put(route('question.update', $questionNotDraft))->assertForbidden();
    put(route('question.update', $draftQuestion), ['question' => 'New Question'])->assertRedirect();
});

it('should make sure that only the person who has created the question can update the question', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->for($rightUser, 'createdBy')
        ->create([
            'draft' => true,
        ]);

    actingAs($wrongUser);

    put(route('question.update', $question))
        ->assertForbidden();

    actingAs($rightUser);

    put(
        route('question.update', $question),
        ['question' => 'New Question']
    )->assertRedirect();
});

it('should not be able to update a new question bigger than 255 characters', function () {
    // Arrange :: preparar
    $user     = User::factory()->create();
    $question = Question::factory()
                ->for($user, 'createdBy')
                ->create(['draft' => true]);

    actingAs($user);

    // Act :: agir
    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 260) . '?',
    ]);

    // Assert :: verificar
    $request->assertRedirect();
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('*', 260) . '?']);
});

it('should check if ends with question mark?', function () {
    // Arrange :: preparar
    $user     = User::factory()->create();
    $question = Question::factory()
                ->for($user, 'createdBy')
                ->create(['draft' => true]);
    actingAs($user);

    // Act :: agir
    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 10),
    ]);

    // Assert :: verificar
    $request->assertSessionHasErrors([
        'question' => 'Are you sure that is a question? It is missing the question mark in the end.',
    ]);

    // Espero que a pergunta seja igual a de quando ela foi criada
    assertDatabaseHas('questions', [
        'question' => $question->question,
    ]);
});

it('should have at least 10 characters', function () {
    // Arrange :: preparar
    $user     = User::factory()->create();
    $question = Question::factory()
                ->for($user, 'createdBy')
                ->create(['draft' => true]);
    actingAs($user);

    // Act :: agir
    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 8) . '?',
    ]);

    // Assert :: verificar
    $request->assertSessionHasErrors(['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]);

    // Espero que a pergunta seja igual a de quando ela foi criada
    assertDatabaseHas('questions', [
        'question' => $question->question,
    ]);
});
