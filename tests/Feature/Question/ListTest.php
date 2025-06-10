<?php

use App\Models\{Question, User};
use Illuminate\Pagination\LengthAwarePaginator;

use function Pest\Laravel\{actingAs, get};

it('should list all the questions', function () {
    // Arrange
    $user      = User::factory()->create();
    $questions = Question::factory()->count(5)->create();

    actingAs($user);
    // Act
    $response = get(route('dashboard'));

    // Assert
    /** @var Question $q */
    foreach ($questions as $q) {
        $response->assertSee($q->question);
    }

});

it('should paginate the result', function () {
    // Arrange
    $user = User::factory()->create();
    Question::factory()->count(20)->create();

    actingAs($user);
    // Act
    get(route('dashboard'))
        ->assertViewHas('questions', fn ($value) => $value instanceof LengthAwarePaginator);

});

it('should order by like and unlike, most liked question should be at the top, most unliked questions should be in the bottom', function () {
    // Arrange
    $user       = User::factory()->create();
    $secondUser = User::factory()->create();
    Question::factory()->count(5)->create();

    $mostLikedQuestion   = Question::find(3);
    $mostUnlikedQuestion = Question::find(1);

    $user->like($mostLikedQuestion);
    $secondUser->unlike($mostUnlikedQuestion);

    actingAs($user);
    // Act
    get(route('dashboard'))
        ->assertViewHas('questions', function ($questions) {

            expect($questions)
               ->first()->id->toBe(3)
               ->and($questions)
               ->last()->id->toBe(1);

            return true;
        });

});
