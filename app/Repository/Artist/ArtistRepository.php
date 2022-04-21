<?php


namespace App\Repository\Artist;


use App\Helpers\Helper;
use App\User;
use Illuminate\Http\Request;

class ArtistRepository implements ArtistRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        return User::where(['role' => 2])->orderBy('name')->paginate(20);
    }

    /**
     * @inheritDoc
     */
    public function show($id)
    {
        $artist = User::where(['id'=> $id,'role' => 2])->first();
        if($artist){
            return $artist;
        }else{
            return Helper::response('error','artist not found',404);
        }
    }

    /**
     * @inheritDoc
     */
    public function search(Request $request)
    {
        $text = $request->text;
        $artists = User::where('name','Like','%'.$text.'%')->get();
        if($artists->toArray())
        {
            return $artists;
        }else{
            return Helper::response('error','artist not found',404);
        }
    }
}
