<?php


namespace App\Repository\ArtSupply;


use App\ArtSupply;
use App\Artworks;
use App\Helpers\Helper;
use Illuminate\Http\Request;

class ArtSupplyRepository implements ArtSupplyRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function index()
    {
       return ArtSupply::orderBy('updated_at','desc')->paginate(20);
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
        $art_supply = ArtSupply::create(
            [
                'user_id' => auth()->user()->id,
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'category_id' => $request->category
            ]
        );
        if ($request->hasFile('pictures.*')) {
            $files = $request->file('pictures');
            Helper::uploadPictures($files, $art_supply);
        }
        return $art_supply;
    }

    /**
     * @inheritDoc
     */
    public function show($artSupply)
    {
        $art_supply = ArtSupply::whereId($artSupply)->first();
        if($art_supply->toArray())
        {
            return $art_supply;
        }
        return Helper::response('error','art supply not found',404);
    }

    /**
     * @inheritDoc
     */
    public function update(Request $request, $artSupply)
    {
        $art_supply = ArtSupply::whereId($artSupply)->where('user_id',auth()->user()->id)->first();
        if($art_supply->toArray())
        {
            $art_supply->update(
                [
                    'title' => $request->title ? $request->title : $art_supply->title,
                    'description' => $request->description ? $request->description : $art_supply->description ,
                    'price' => $request->price ? $request->price : $art_supply->price,
                    'category_id' => $request->category ? $request->category : $art_supply->catgory_id
                ]
            );
            return  Helper::response('success','art supply updated',200 );
        }
        return Helper::response('error','art supply not found',404);
    }

    /**
     * @inheritDoc
     */
    public function destroy($artSupply) // delete an artsupply
    {
        $art_supply = ArtSupply::whereId($artSupply)->where('user_id', auth()->user()->id)->first();
        if ($art_supply->toArray()) {
            $art_supply->delete();
            return  Helper::response('success','art supply updated',200 );

        }
        return Helper::response('error', 'art supply not found', 404);
    }
    /**
     * @inheritDoc
     */
    public function userArtSupplies()
    {
        return ArtSupply::where('user_id', auth()->user()->id)->orderBy('updated_at','desc')->paginate(20);
    }

    /**
     * @inheritDoc
     */
    public function categorizeArtSupplies($request)
    {
        $artSupply = new ArtSupply();
        if($request->categories)
        {
            $artSupply = $artSupply->whereIn('category_id' , $request->categories);
        }

        if($request->released)
        {
            switch ($request->released){
                case 1;
                    $artSupply = $artSupply->orderBy('created_at','desc');
                    break;
                case 2:
                    $artSupply = $artSupply->where('created_at','>=',Now()->startOfWeek()->format('Y-m-d'))
                                            ->where('created_at','<=',Now()->endOfWeek()->format('Y-m-d'))
                                            ->orderBy('created_at','desc');
                    break;
                case 3:
                    $artSupply = $artSupply->where('created_at','>=',Now()->startOfMonth()->format('Y-m-d'))
                                            ->where('created_at','<=',Now()->endOfMonth()->format('Y-m-d'))
                                            ->orderBy('created_at','desc');
                    break;
                case 4:
                    $artSupply = $artSupply->where('created_at','>=',Now()->startOfYear()->format('Y-m-d'))
                                            ->where('created_at','<=',Now()->endOfYear()->format('Y-m-d'))
                                            ->orderBy('created_at','desc');
                    break;
                case 5:
                    $artSupply = $artSupply->where('created_at','<',Now()->startOfYear()->format('Y-m-d'))
                                            ->orderBy('created_at','desc');
                    break;
                default :
                $artSupply = $artSupply->orderBy('created_at','desc');
            }
        }
        if($request->price)
        {
            $artSupply = $artSupply->orderBy('price',$request->price);
        }
        return $artSupply->paginate(20);
    }

    /**
     * @inheritDoc
     */
    public function addtoCart($id)
    {
        $art_supply = ArtSupply::whereId($id)->first();
        if($art_supply){
            $checkCart  = $art_supply->toCart()->where(['user_id' => auth()->user()->id])->first();
            if($checkCart)
            {
                $checkCart->update(['quantity' => (int) $checkCart->quantity + 1]);
                return Helper::response('success','art supply add to your cart');
            }
            $art_supply->toCart()->create(['user_id' => auth()->user()->id, 'quantity' => 1]);
            return Helper::response('success','art supply add to your cart');
        }
        return Helper::response('error','art supply not found',404);
    }
}
