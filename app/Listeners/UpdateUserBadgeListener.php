<?php

namespace App\Listeners;

use App\Models\Badge;
use App\Models\User;
use App\Models\UserBadge;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateUserBadgeListener
{
      /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = User::findOrFail($event->id);
        $user->points += $event->value;
        $user->update();
        $badge = Badge::whereRaw('? between `from` and `to`', [$user->points])->first();
        UserBadge::where('user_id', $user->id)->update(['badge_id' => $badge->id]);
    }
}
