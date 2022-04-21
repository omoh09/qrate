<?php


namespace App\Repository\Post;

use App\Events\CommentEvent;
use App\Events\LikeEvent;
use App\File;
use App\Helpers\Helper;
use App\Likes;
use App\Post;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use phpseclib\Crypt\Random;
use App\Events\BroadcastTimeline;

class PostRepository implements PostRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        return Post::where('user_id',auth()->user()->id)->paginate(20);
    }

    /**
     * @inheritDoc
     */
    public function store(Request $request)
    {
        if($request->hasFile('pictures')){
            $count = count($request->file('pictures'));
            if($count > 5){
                return Helper::response('error' , 'you can\'t upload more that file pictures',404);
            }
        }

        $post = Post::create(
            [
                'body' => $request->body,
                'user_id' => auth()->user()->id,
                #'category_id' => (int) $request->categories,
            ]
        );
        if($request->categories){
            # $request->categorie is an array of categoery id i.e [1,2,3]
            $post->categories()->sync($request->categories);
        }
        
        //BROADCAST TO ALL CLIENTS REAL TIME 
        // $date = [
        //     'body' => $request->body,
        //     'user_id' => auth()->user()->id,
        //     'category_id' => (int) $request->category,
        // ];
        // BroadcastTimeline::dispatch($date);
     
        if ($request->hasFile('pictures.*')) {
            $files = $request->file('pictures');
            Helper::uploadPictures($files, $post);
        }
        return $post;
    }

    public function show($id)
    {
        $post = Post::where(['id' => $id])->first();
        if($post){
            return $post;
        }
        return Helper::response('error','post not found',404);
    }

    /**
     * @inheritDoc
     */
    public function edit($id, Request $request)
    {
        $post  = Post::where(['id' => $id,'user_id' => auth()->user()->id])->first();
        if($post){
            $post->update(['body' => $request->body]);
            if ($request->has('categories')) {
                # remove existing categories and update with new ids
                $post->categories()->sync($request->categories);
            }
            return $post;
        }
        return Helper::response('error','post not found',404);
    }

    /**
     * @inheritDoc
     */
    public function destroy($id)
    {
        $post  = Post::where(['id' => $id,'user_id' => auth()->user()->id])->first();
        if($post){
            $post->delete();
            return Helper::response('success','post deleted',200);
        }
        return Helper::response('error','post not found',404);
    }

    /**
     * @inheritDoc
     */
    public function toggleLike($id)
    {
        $Post = Post::whereId($id)->first();
        if($Post){
            $likedPreviosly = $Post->likes()->onlyTrashed()->where(['user_id' => auth()->user()->id])->first();
            if($likedPreviosly){
                $likedPreviosly->restore();
                Helper::updateLikeCount($Post);
                return Helper::response('success','post liked',200);
            }else{
                $liked = $Post->likes()->where(['user_id' => auth()->user()->id])->first();
                if($liked){
                    $liked->delete();
                    Helper::updateLikeCount($Post);
                    return Helper::response('success','post un-liked',200);
                }
                $like = $Post->likes()->create(['user_id'=> auth()->user()->id]);
                Helper::updateLikeCount($Post);
                event(new LikeEvent($like));
                return Helper::response('success','post liked',200);
            }
        }
        return Helper::response('error','post not found',404);
    }

    /**
     * @inheritDoc
     */
    public function comment(Request $request, $id)
    {
        $Post = Post::whereId($id)->first();
        if($Post){
            $comment = $Post->comments()->create(['user_id' => auth()->user()->id,'body' => $request->body]);
            if($comment){
                Helper::updateCommentCount($Post);
                event(new CommentEvent($comment));
                return $comment;
            }else{
                return Helper::response('error','internal server error',501);
            }
        }
        return Helper::response('error','post not found',404);
    }
}
