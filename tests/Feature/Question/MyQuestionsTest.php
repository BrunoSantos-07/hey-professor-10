<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able to list all question created by me', function () {
    $wrongUser     = User::factory()->create();
    $wrongQuestion = Question::factory()
        ->for($wrongUser, 'createdBy')
        ->count(10)
        ->create();

    $user      = User::factory()->create();
    $questions = Question::factory()
        ->for($user, 'createdBy')
        ->count(10)
        ->create();

    actingAs($user);

    $request = get(route('question.index'));

    /** @var Question $q */
    foreach ($questions as $q) {
        $request->assertSee($q->question);
    }

    /** @var Question $q */
    foreach ($wrongQuestion as $q) {
        $request->assertDontSee($q->question);
    }
});
