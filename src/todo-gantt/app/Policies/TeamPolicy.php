<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TeamPolicy
{
    public function removeTeamMember(User $user, Team $team, $targetUserId)
    {
        $userBelongsToTeam = $team->users->contains($user->id);

        $targetUserBelongsToTeam = $team->users->contains($targetUserId);

        return $userBelongsToTeam && $targetUserBelongsToTeam;
    }
}
