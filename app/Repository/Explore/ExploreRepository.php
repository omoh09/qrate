<?php


namespace App\Repository\Explore;

use App\Artworks;
use App\Exhibition;
use App\Explore;
use App\Helpers\Helper;
use App\Http\Resources\ArtworksResource;
use App\Http\Resources\ExhibitionResource;
use App\Http\Resources\MiniArtworkResource;
use Illuminate\Http\Request;
use UserPreferredCategory;

class ExploreRepository implements ExploreRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        $artworks = Artworks::inRandomOrder()->take(8)->get();
        $exhibitions = Exhibition::where('event_date','>=',Now())->inRandomOrder()->take(2)->get();
        return Helper::response('success','explore',200, ['artworks' => ArtworksResource::collection($artworks),'exhibitions' =>ExhibitionResource::collection($exhibitions)]);
    }

    /**
     * @inheritDoc
     */
    public function show($id)
    {
//        $explore = Explore::whereId($id)->first();
//        if($explore->toArray())
//        {
//            return $explore;
//        }
//        return Helper::response('error','Preferred Category not found',404);
    }

    /**
     * @inheritDoc
     */
    public function trending()
    {
        $exhibitions = Exhibition::orderBy('likes_count','desc')->take(4)->get();
        $artworks = Artworks::orderBy('likes_count','desc')->take(4)->get();
        return Helper::response('success','trending',200,['artworks' => MiniArtworkResource::collection($artworks),'exhibitions' => ExhibitionResource::collection($exhibitions)]);
    }
}
