<?php

namespace App\Providers;

use App\{Events\CommentEvent,
    Events\LikeEvent,
    Events\NewAuction,
    Events\NewPost,
    Events\NewUser,
    Events\NewArtwork,
    Events\FollowEvent,
    Events\ComingExhibition,
    Events\UserVerified,
    Listeners\AuctionListener,
    Listeners\CommentListener,
    Listeners\LikeListener,
    Listeners\NewPostListener,
    Listeners\FollowListener,
    Listeners\NewUserListener,
    Listeners\NewArtworkListener,
    Listeners\ComingExhibitionListener,
    Listeners\UserVerifiedListener};
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NewPost::class => [
            NewPostListener::class
        ],
        NewUser::class => [
            NewUserListener::class
        ],
        UserVerified::class => [
            UserVerifiedListener::class
        ],
        NewArtwork::class => [
           NewArtworkListener::class
        ],
        ComingExhibition::class => [
            ComingExhibitionListener::class
        ],
        CommentEvent::class => [
            CommentListener::class
        ],
        LikeEvent::class => [
            LikeListener::class
        ],
        FollowEvent::class => [
            FollowListener::class
        ],
        NewAuction::class => [
            AuctionListener::class
        ],
        BidEvent::class=>[
            BidListener::class
        ],
        NewAuction::class => [
            AuctionListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
