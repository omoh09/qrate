<?php


namespace App\Repository\Artworks;


use App\Events\NewAuction;
use App\User;
use App\Artworks;
use App\Helpers\Helper;
use App\Events\LikeEvent;
use App\Events\CommentEvent;
use Illuminate\Http\Request;

class ArtworksRepository implements ArtworksRepositoryInterface
{

    /**
     * @var Artworks
     */
    private $model;

    public function __construct(Artworks $model)
    {
        $this->model = $model;
    }

    public function artworks()
    {
        return Artworks::where(['user_id' => auth()->user()->id])->where()->orderBy('updated_at','desc')->paginate(20);
    }

    public function store(Request $request)
    {
        if($request->hasFile('pictures')){
            $count = count($request->file('pictures'));
            if($count > 5){
                return Helper::response('error' , 'you can\'t upload more that file pictures',404);
            }
        }
        $artwork = Artworks::create(
            [
                'user_id' => auth()->user()->id,
                'title' => $request->title,
                'description' => $request->description,
                'dimension' => (string) $request->dimension,
                'sale_type' => $request->sale_type,
                'category_id' => $request->category,
                'price' => $request->price
            ]
        );
        if($artwork->sale_type == 2)
        {
            $artwork->auction()->create(
                [
                    'bid_start' => Now()->toDateTime(),
                    'bid_end' => Now()->toDateTime(),
                ]
            );
            event(new NewAuction($artwork));
        }
        if ($request->hasFile('pictures')) {
            $files = $request->file('pictures');
            Helper::uploadPictures($files, $artwork);
        };

        if($request->hasFile('video'))
        {
            $files = $request->file('video');
            Helper::uploadVideo($files,$artwork);
        }
        return $artwork;
    }

    public function show($artwork)
    {
        if($this->model->whereId($artwork)->first())
        {
            return $this->model->whereId($artwork)->first();
        }
        return Helper::response('error','artwork not found',404);
    }

    public function update(Request $request, int $artworks)
    {
        $artworkModel = $this->model->whereId($artworks)->where(['user_id' => auth()->user()->id])->first();
        if($artworkModel) {
            $artwork = $artworkModel->update(
                [
                    'title' => $request->title ?$request->title : $artworkModel->title ,
                    'description' => $request->description ? $request->description : $artworkModel->description  ,
                    'dimension' => $request->dimension ? (string)$request->dimension: $artworkModel->dimension ,
                    'sale_type' => $request->sale_type ? $request->sale_type : $artworkModel->sale_type ,
                    'category_id' => $request->category ? $request->category : $artworkModel->category_id,
                    'price' => $request->price ? $request->price : $artworkModel->price,
                ]
            );

            if ($request->hasFile('pictures.*')) {
                $files = $request->file('pictures');
                Helper::uploadPictures($files, $artworkModel);
            };
            if ($request->hasFile('video')) {
                $files = $request->file('video');
                Helper::uploadVideo($files, $artworkModel);
            }
            return Helper::response('success','artwork updated');
        }
        return Helper::response('error','artwork not found',404);
    }

    public function destroy($artwork)
    {
        if($artworkModel = $this->model->whereId($artwork)->where('user_id',auth()->user()->id)->first())
        {
           $artworkModel->delete();
            return Helper::response('sucess','artwork deleted sucessfully');
        }
        return Helper::response('error','artwork not found',404);
    }

    public function artistArtworks($artist)
    {
        $user = User::whereId($artist)->first();
        if($user->role == '2')
        {
            return $this->model->where(['user_id' => $artist])->orderBy('updated_at','desc')->paginate(20);
        }
        return Helper::response('error','user is not an artist',404);
    }
    public function index()
    {
        return $this->model->orderBy('updated_at','desc')->paginate(20);
    }

    /**
     * @inheritDoc
     */
    public function toggleLike($id)
    {
        $artwork = Artworks::whereId($id)->first();
        if($artwork){
            $likedPreviously = $artwork->likes()->onlyTrashed()->where(['user_id' => auth()->user()->id])->first();
            if($likedPreviously){
                $likedPreviously->restore();
                Helper::updateLikeCount($artwork);
                return Helper::response('success','artwork liked',200);
            }else{
                $liked = $artwork->likes()->where(['user_id' => auth()->user()->id])->first();
                if($liked){
                    $liked->delete();
                    Helper::updateLikeCount($artwork);
                    return Helper::response('success','artwork un-liked',200);
                }
                $like = $artwork->likes()->create(['user_id'=> auth()->user()->id]);
                Helper::updateLikeCount($artwork);
                event(new LikeEvent($like));
                return Helper::response('success','artwork  liked',200);
            }
        }
        return Helper::response('error','artwork not found',404);
    }

    /**
     * @inheritDoc
     */
    public function comment(Request $request, $id)
    {
        $artwork = Artworks::whereId($id)->first();
        if($artwork){
            $comment = $artwork->comments()->create(['user_id' => auth()->user()->id,'body' => $request->body]);
            if($comment){
                Helper::updateCommentCount($artwork);
                event(new CommentEvent($comment));
                return $comment;
            }else{
                return Helper::response('error','internal server error',501);
            }
        }
        return Helper::response('error','artwork not found',404);
    }

    public function addtoCart($id)
    {
        $artwork = Artworks::whereId($id)->where('on-shelf',true)->where('sold',false)->where('sale_type',1)->first();
        if($artwork){
            $checkCart  = $artwork->toCart()->where(['user_id' => auth()->user()->id])->first();
            if($checkCart)
            {
                return Helper::response('success','artwork add to your cart');
            }
            $artwork->toCart()->create(['user_id' => auth()->user()->id, 'quantity' => 1]);
            Helper::picked($artwork);
            return Helper::response('success','artwork add to your cart');
        }
        $artwork_check = Artworks::whereId($id)->where('sale_type',1)->where('sold',false)->first();
        if($artwork_check)
        {
            $checkCart  = $artwork_check->toCart()->where(['user_id' => auth()->user()->id])->first();
            if($checkCart)
            {
                return Helper::response('success','artwork add to your cart');
            }
            return Helper::response('error','artwork is off the shelf, check back later');
        }
        $artwork_check = Artworks::whereId($id)->where('sale_type',2)->first();
        if($artwork_check){
            return Helper::response('error','you can\'t add an auction item to your cart',404);
        }
        return Helper::response('error','artwork not found',404);
    }
}
