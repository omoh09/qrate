<?php


namespace App\Repository\ArtGallery;


use App\Helpers\Helper;
use App\Http\Resources\ExhibitionResource;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ArtGalleryRepository implements ArtGalleryInterface
{

    /**
     * @return mixed
     */
    public function index()
    {
        return User::where('role' ,3)->orderBy('name')->paginate(10);
    }

    /**
     * @param $id
     * @return mixed|void
     */
    public function show($id)
    {
      $user =   User::where('role' ,3)->whereId($id)->first();
      if($user)
      {
          return $user;
      }
      return Helper::response('error','art gallery not found',404);
    }

    /**
     * @inheritDoc
     */
    public function search(Request $request)
    {
        $users =   User::where('role' ,3)->where('name','Like','%'.$request->text.'%')->get();
        if($users->toArray())
        {
            return $users;
        }
        return Helper::response('error','art gallery not found',404);
    }

    public function createExhibition(Request $request)
    {
        $exhibition = auth()->user()->exhibitions()->create(
            [
                'name' => $request->name,
                'desc' => $request->description,
                'event_date' => Carbon::parse($request->date)->format('Y-m-d'),
                'time' => Carbon::parse($request->time)->format('H:i'),
                'country' => $request->country,
                'address' => $request->address,
                'ticket_price' => $request->ticket_price,
            ]
        );
        if ($request->hasFile('pictures.*')) {
            $files = $request->file('pictures');
            Helper::uploadPictures($files, $exhibition);
        }
        if($request->hasFile('video'))
        {
            $files = $request->file('video');
            Helper::uploadVideo($files,$exhibition);
        }
        return Helper::response('success','exhibition created',200 , ExhibitionResource::make($exhibition));
    }

    public function editExhibition(Request $request, $id)
    {
        $exhibition = auth()->user()->exhibitions()->whereId($id)->first();
        if(!$exhibition)
        {
            return  Helper::response('error','exhibition not found',404);
        }

        $exhibition->update(
            [
                'name' => $request->name ?? $exhibition->name,
                'desc' => $request->description ?? $exhibition->desc,
                'event_date' =>  $request->date ? Carbon::parse($request->date)->format('Y-m-d') : $exhibition->event_date,
                'time' => $request->time ? Carbon::parse($request->time)->format('H:i') : $exhibition->time,
                'country' => $request->country ?? $exhibition->country,
                'address' => $request->address ?? $exhibition->address,
                'ticket_price' => $request->ticket_price,
            ]
        );
        if ($request->hasFile('pictures.*')) {
            $files = $request->file('pictures');
            Helper::uploadPictures($files, $exhibition);
        }
        if($request->hasFile('video'))
        {
            $files = $request->file('video');
            Helper::uploadVideo($files,$exhibition);
        }
        return Helper::response('success','exhibition edited',200 , ExhibitionResource::make($exhibition));

    }
}
