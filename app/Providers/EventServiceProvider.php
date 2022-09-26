<?php

namespace App\Providers;

use App\Models\Catalog\Category;
use App\Models\Catalog\Image;
use App\Models\Catalog\Offer;
use App\Models\Catalog\Product;
use App\Models\Sale\Delivery;
use App\Models\Sale\Payment;
use App\Observers\CategoryObserver;
use App\Observers\DeliveryObserver;
use App\Observers\ImageObserver;
use App\Observers\OfferObserver;
use App\Observers\PaymentObserver;
use App\Observers\ProductObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


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
        Delivery::observe(DeliveryObserver::class);
        Payment::observe(PaymentObserver::class);
    }
}
