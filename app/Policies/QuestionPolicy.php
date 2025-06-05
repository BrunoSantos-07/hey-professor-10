<?php

namespace App\Policies;

use App\Models\{Question, User};

class QuestionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function publish(User $user, Question $question): bool
    {
        return $question->createdBy->is($user);
    }
}
