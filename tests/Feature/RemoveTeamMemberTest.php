<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveTeamMemberTest extends TestCase
{
    use RefreshDatabase;

    public function testTeamMembersCanBeRemovedFromTeams(): void
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'admin']
        );

        $this->delete('/teams/' . $user->currentTeam->id . '/members/' . $otherUser->id);

        $this->assertCount(0, $user->currentTeam->fresh()->users);
    }

    public function testOnlyTeamOwnerCanRemoveTeamMembers(): void
    {
        $user = User::factory()->withPersonalTeam()->create();

        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'admin']
        );

        $this->actingAs($otherUser);

        $response = $this->delete('/teams/' . $user->currentTeam->id . '/members/' . $user->id);

        $response->assertStatus(403);
    }
}
