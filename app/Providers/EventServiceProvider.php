<?php

namespace App\Providers;

use App\Models\Shop\Category;
use App\Models\Shop\Image;
use App\Models\Shop\Offer;
use App\Models\Shop\Product;
use App\Observers\CategoryObserver;
use App\Observers\ImageObserver;
use App\Observers\OfferObserver;
use App\Observers\ProductObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Category::observe(CategoryObserver::class);
        Image::observe(ImageObserver::class);
        Product::observe(ProductObserver::class);
        Offer::observe(OfferObserver::class);
    }
}
