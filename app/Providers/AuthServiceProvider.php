<?php

namespace App\Providers;

use App\Policies\PostPolicy;
use App\Post;
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
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Post::class => PostPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function($user) {
            if ($user->id == 1) {
                return true;
            }
        });

        //
        Gate::define('posts.index', function($user) {
            return $user->hasPermission('posts.index');
        });

        Gate::define('posts.create', function($user) {
            return $user->hasPermission('posts.create');
        });

        Gate::define('posts.edit', function($user, $post) {
            if ($user->id != $post->user_id) {
                return false;
            }
            return $user->hasPermission('posts.edit');
        });

        Gate::define('posts.delete', function($user, $post) {
            if ($user->id != $post->user_id) {
                return false;
            }
            return $user->hasPermission('posts.delete');
        });
    }
}
