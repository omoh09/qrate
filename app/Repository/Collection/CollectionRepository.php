<?php


namespace App\Repository\Collection;


use App\Collection;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use PHPUnit\TextUI\Help;

class CollectionRepository implements CollectionRepositoryInterface
{

    public function index()
    {
        return Collection::where(['user_id' => auth()->user()->id])->paginate(20);
    }

    /**
     * @inheritDoc
     */
    public function store(Request $request)
    {
        $collection = Collection::create(
            [
                'user_id' => auth()->user()->id,
                'name' => $request->name,
                'details' => $request->details
            ]
        );
        return $collection;
    }

    /**
     * @inheritDoc
     */
    public function show($collection)
    {
        $collection = Collection::where(['id' => $collection])->first();
        if($collection)
        {
            return $collection;
        }
        return Helper::response('error','collection not found',404);
    }

    /**
     * @inheritDoc
     */
    public function update(Request $request, $collection)
    {
        $collection = Collection::where(['id' => $collection , 'user_id' => auth()->user()->id])->first();
        if($collection)
        {
            $collection->update(
                [
                    'name'=> $request->name ? $request->name : $collection->name,
                    'details' => $request->details ? $request->details : $collection->details
                ]
            );
            return Helper::response('success','collection updated');
        }
        return  Helper::response('error','collection not found',404);
    }

    /**
     * @inheritDoc
     */
    public function destroy($collection)
    {
        $collection = Collection::where(['id' => $collection , 'user_id' => auth()->user()->id])->first();
        if($collection)
        {
            $collection->delete();
            return Helper::response('success','collection deleted');
        }
        return  Helper::response('error','collection not found',404);
    }

    /**
     * @inheritDoc
     */
    public function addArtworkToCollection(Request $request, $collection)
    {
        $collection = Collection::where(['id' => $collection , 'user_id' => auth()->user()->id])->first();
        if($collection)
        {
            //TODO work of this add artworks check ... make a single art work 
            $collection->artworks()->attach($request->artworks);
            return Helper::response('success','artworks added to collection');
        }
        return  Helper::response('error','collection not found',404);
    }

    /**
     * @inheritDoc
     */
    public function removeArtworkFromCollection(Request $request, $collection)
    {
        $collection = Collection::where(['id' => $collection , 'user_id' => auth()->user()->id])->first();
        if($collection)
        {
            $collection->artworks()->detach($request->artworks);
            return Helper::response('success','artworks added to collection');
        }
        return  Helper::response('error','collection not found',404);
    }
}
