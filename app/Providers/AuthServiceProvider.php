<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Channel;
use App\Models\ChannelUser;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('channel-member', function (User $user, Channel $channel = null) {
           if ($channel == null) {
              return false;
           }
         return $channel->user->contains($user->id);
      });

      Gate::define('admin-channel', function (User $user, Channel $channel = null) {
         if ($channel == null) {
            return false;
         }
       return $channel->user_id == $user->id;
    });
    }
}
