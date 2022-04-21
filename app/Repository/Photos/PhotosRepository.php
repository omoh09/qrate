<?php


namespace App\Repository\Photos;


use App\Helpers\Helper;
use App\User;
use Illuminate\Http\Request;
use PHPUnit\TextUI\Help;

class PhotosRepository implements PhotosRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        $photos = auth()->user()->photos;
        if(!$photos)
        {
            $photos = auth()->user()->photos()->create();
        }
        return auth()->user()->photos->files()->paginate(20);
    }

    /**
     * @inheritDoc
     */
    public function store(Request $request)
    {
        $photos = auth()->user()->photos;
        if(!$photos)
        {
            $photos = auth()->user()->photos()->create();
        }
        if ($request->hasFile('pictures.*')) {
            $files = $request->file('pictures');
            Helper::uploadPictures($files, $photos);
            return Helper::response('success','picture uploaded');
        };
        return Helper::response('error','pictures not uploaded',404);
    }

    /**
     * @inheritDoc
     */
    public function destroy($photo)
    {
        $photo = auth()->user()->photos->files()->whereId($photo)->first();
        if($photo)
        {
            $photo->delete();
            return Helper::response('success','pictured deleted');
        }
        return Helper::response('error','picture does not exist');
    }
}
