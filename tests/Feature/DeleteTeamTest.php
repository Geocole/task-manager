<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteTeamTest extends TestCase
{
    use RefreshDatabase;

    public function testTeamsCanBeDeleted(): void
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $user->ownedTeams()->save($team = Team::factory()->make([
            'personal_team' => false,
        ]));

        $team->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'test-role']
        );

        $this->delete('/teams/' . $team->id);

        $this->assertNull($team->fresh());
        $this->assertCount(0, $otherUser->fresh()->teams);
    }

    public function testPersonalTeamsCantBeDeleted(): void
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $this->delete('/teams/' . $user->currentTeam->id);

        $this->assertNotNull($user->currentTeam->fresh());
    }
}
