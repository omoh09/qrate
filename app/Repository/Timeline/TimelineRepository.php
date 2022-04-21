<?php


namespace App\Repository\Timeline;


use App\Artworks;
use App\Http\Resources\PostResource;
use App\Post;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TimelineRepository implements TimelineInterface
{


    /**
     * @inheritDoc
     */
    public function timeline()
    {

        //TODO update the logic for timeline
        // $ArtistFollowing = User::whereId(auth()->user()->id)->first()->following()->allRelatedIds()->toArray();
        // $ArtistFollowing[] = auth()->user()->id;
        // $post_for =  Post::whereIn('user_id',$ArtistFollowing)->orderBy('updated_at','desc')->get();
        // $post_against = Post::WhereNotIn('user_id',$ArtistFollowing)->orderBy('updated_at','desc')->get();
        // $timeline = $post_for->merge($post_against);

        // return $timeline->paginate(20);
        // die();
        
        // Optimal way to get the timeline
        $user_id = auth()->user()->id;
        $posts =  Post::userTimeLine($user_id)->paginate(20);
        return $posts;

    }

    /*
     * @inheritDoc
     */
    public function topPicks()
    {
        $categories = User::whereId(auth()->user()->id)->first()->preferredCategories()->allRelatedIds()->toArray();
        $top_picks = new Collection();
        if($categories){
            $artwork_group = Artworks::whereIn('category_id',$categories)->with('likes')->orderBy('likes_count','DESC')->orderBy('updated_at')
        ->get()->groupBy('category_id');
            foreach( $artwork_group as $artwork)
            {
                if($top_picks == ''){
                    $top_picks = $artwork->first();
                }
                $top_picks = $top_picks->add($artwork->first());
            }
        }
        $artwork_group2 =  Artworks::whereNotIn('category_id',$categories)->with('likes')->orderBy('likes_count','DESC')->orderBy('updated_at')
        ->get()->groupBy('category_id');
        foreach( $artwork_group2 as $artwork)
        {
            if($top_picks == ''){
                $top_picks = $artwork->first();
            }
            $top_picks = $top_picks->add($artwork->first());
        }
        return $top_picks->take(5);

    }
}
