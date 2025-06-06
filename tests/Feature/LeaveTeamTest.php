<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeaveTeamTest extends TestCase
{
    use RefreshDatabase;

    public function testUsersCanLeaveTeams(): void
    {
        $user = User::factory()->withPersonalTeam()->create();

        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'admin']
        );

        $this->actingAs($otherUser);

        $this->delete('/teams/' . $user->currentTeam->id . '/members/' . $otherUser->id);

        $this->assertCount(0, $user->currentTeam->fresh()->users);
    }

    public function testTeamOwnersCantLeaveTheirOwnTeam(): void
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $response = $this->delete('/teams/' . $user->currentTeam->id . '/members/' . $user->id);

        $response->assertSessionHasErrorsIn('removeTeamMember', ['team']);

        $this->assertNotNull($user->currentTeam->fresh());
    }
}
