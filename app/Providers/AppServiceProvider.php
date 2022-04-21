<?php

namespace App\Providers;

use App\Repository\Admin\AdminRepositoryInterface;
use App\{Repository\Admin\AdminRepository,
    Repository\ArtGallery\ArtGalleryInterface,
    Repository\ArtGallery\ArtGalleryRepository,
    Repository\Artist\ArtistRepository,
    Repository\Artist\ArtistRepositoryInterface,
    Repository\ArtistProfile\ProfileInterface,
    Repository\ArtistProfile\ProfileRepository,
    Repository\ArtSupply\ArtSupplyRepository,
    Repository\ArtSupply\ArtSupplyRepositoryInterface,
    Repository\Artworks\ArtworksRepository,
    Repository\Artworks\ArtworksRepositoryInterface,
    Repository\Auction\AuctionRepository,
    Repository\Auction\AuctionRepositoryInterface,
    Repository\Cart\CartRepository,
    Repository\Cart\CartRepositoryInterface,
    Repository\Catalogue\CatalogueRepository,
    Repository\Catalogue\CatalogueRepositoryInterface,
    Repository\Collection\CollectionRepository,
    Repository\Collection\CollectionRepositoryInterface,
    Repository\Exhibition\ExhibitionRepository,
    Repository\Exhibition\ExhibitionRepositoryInterface,
    Repository\Explore\ExploreRepository,
    Repository\Explore\ExploreRepositoryInterface,
    Repository\Follow\FollowInterface,
    Repository\Follow\FollowRepository,
    Repository\Notification\NotificationRepository,
    Repository\Notification\NotificationRepositoryInterface,
    Repository\Payment\PaymentInterface,
    Repository\Payment\PaymentRepository,
    Repository\Photos\PhotosRepository,
    Repository\Photos\PhotosRepositoryInterface,
    Repository\Post\PostRepository,
    Repository\Post\PostRepositoryInterface,
    Repository\Timeline\TimelineInterface,
    Repository\Timeline\TimelineRepository,
    Repository\TwoFactorAuth\TwoFactorAuthInterface,
    Repository\TwoFactorAuth\TwoFactorRepository};
use App\Repository\Checkout\CheckoutRepository;
use App\Repository\Checkout\CheckoutRepositoryInterface;
use App\HttpRepository\HttpRepository;
use App\HttpRepository\HttpInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            FollowInterface::class,
            FollowRepository::class
        );

        $this->app->bind(
            PostRepositoryInterface::class,
            PostRepository::class
        );
        $this->app->bind(
            TimelineInterface::class,
            TimelineRepository::class
        );
        $this->app->bind(
            ArtistRepositoryInterface::class,
            ArtistRepository::class
        );
        $this->app->bind(
            ProfileInterface::class,
            ProfileRepository::class
        );
        $this->app->bind(
            CatalogueRepositoryInterface::class,
            CatalogueRepository::class
        );
        $this->app->bind(
            ArtworksRepositoryInterface::class,
            ArtworksRepository::class
        );
        $this->app->bind(
            CartRepositoryInterface::class,
            CartRepository::class
        );
        $this->app->bind(
            ArtGalleryInterface::class,
            ArtGalleryRepository::class
        );
        $this->app->bind(
            CollectionRepositoryInterface::class,
            CollectionRepository::class
        );
        $this->app->bind(
            PhotosRepositoryInterface::class,
            PhotosRepository::class
        );
        $this->app->bind(
            ArtSupplyRepositoryInterface::class,
            ArtSupplyRepository::class
        );
        $this->app->bind(
            NotificationRepositoryInterface::class,
            NotificationRepository::class
        );
        $this->app->bind(
            AuctionRepositoryInterface::class,
            AuctionRepository::class
        );
        $this->app->bind(
            PaymentInterface::class,
            PaymentRepository::class
        );
        $this->app->bind(
            CheckoutRepositoryInterface::class,
            CheckoutRepository::class
        );
        $this->app->bind(
            ExhibitionRepositoryInterface::class,
            ExhibitionRepository::class
        );
        $this->app->bind(
            TwoFactorAuthInterface::class,
            TwoFactorRepository::class
        );
        $this->app->bind(
            AdminRepositoryInterface::class,
                    AdminRepository::class
        );
        $this->app->bind(
            ExploreRepositoryInterface::class,
                ExploreRepository::class
        );
        $this->app->bind(
            HttpInterface::class,
            HttpRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }
}
