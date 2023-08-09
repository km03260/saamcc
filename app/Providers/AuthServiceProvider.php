<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Article;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Mouvement;
use App\Models\Stock;
use App\Models\User;
use App\Models\Variation;
use App\Policies\ArticlePolicy;
use App\Policies\ClientPolicy;
use App\Policies\CommandePolicy;
use App\Policies\MouvementPolicy;
use App\Policies\StockPolicy;
use App\Policies\UserPolicy;
use App\Policies\VariationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Client::class => ClientPolicy::class,
        Article::class => ArticlePolicy::class,
        Stock::class => StockPolicy::class,
        Mouvement::class => MouvementPolicy::class,
        Commande::class => CommandePolicy::class,
        User::class => UserPolicy::class,
        Variation::class => VariationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
