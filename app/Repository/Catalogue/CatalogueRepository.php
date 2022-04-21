<?php
namespace App\Repository\Catalogue;

use App\Artworks;
use App\Helpers\Helper;
use App\Repository\Catalogue\CatalogueRepositoryInterface;
use App\User;
use Illuminate\Http\Request;

class CatalogueRepository implements CatalogueRepositoryInterface
{
    public function index()
    {
        $userModel = User::whereId(auth()->user()->id)->first();
        if($userModel->catalogue)
        {
            return $userModel->catalogue;
        }
        return $userModel->catalogue()->create();
    }

    public function show($id) // show the folder
    {
        $userModel = User::whereId(auth()->user()->id)->first();
        if(!$userModel->catalogue)
        {
            $userModel->catalogue()->create();
            $userModel = User::whereId(auth()->user()->id)->first();

        }
        $folder =  $userModel->catalogue->folders()->whereId($id)->first();
        if($folder)
        {
            return $folder;
        }else{
            return Helper::response('error','folder not found',404);
        }
    }

    public function store(Request $request) // create folder in catalogue
    {
        $userModel = User::whereId(auth()->user()->id)->first();
        if(!$userModel->catalogue)
        {
            $userModel->catalogue()->create();
            $userModel = User::whereId(auth()->user()->id)->first();

        }
        return $userModel->catalogue->folders()->create(['name' => $request->name]);
    }

    public function edit(Request $request, $id) // edit a folders details
    {
        $userModel = User::whereId(auth()->user()->id)->first();
        if(!$userModel->catalogue)
        {
            $userModel->catalogue()->create();
            $userModel = User::whereId(auth()->user()->id)->first();

        }
        $folder =  $userModel->catalogue->folders()->whereId($id)->first();
        if($folder)
        {
           $folder->update(['name' => $request->name]);
           return  Helper::response('success','folder updated',200);
        }
        return Helper::response('error','folder not found',404);
    }

    public function destroy($id) // deleta a whole folder
    {
        $userModel = User::whereId(auth()->user()->id)->first();
        if(!$userModel->catalogue)
        {
            $userModel->catalogue()->create();
            $userModel = User::whereId(auth()->user()->id)->first();

        }
        $folder =  $userModel->catalogue->folders()->whereId($id)->first();
        if($folder)
        {
            $folder->delete();
            return  Helper::response('success','folder deleted',200);
        }else{
            return Helper::response('error','folder not found',404);
        }
    }

    public function addToFolder(int $folder, int $artwork) // add artworks to a folder
    {
        $artworkModel = Artworks::whereId($artwork)->first();
        if($artworkModel) {
            $userModel = User::whereId(auth()->user()->id)->first();
            if(!$userModel->catalogue)
            {
                $userModel->catalogue()->create();
                $userModel = User::whereId(auth()->user()->id)->first();

            }
            $folderModel = $userModel->catalogue->folders()->whereId($folder)->first();
            if ($folderModel) {
                try{
                    $folderModel->artworks()->attach($artwork);
                }catch (\Exception $exception)
                {
                    return Helper::response('error', 'art work already in folder', 400);
                }
                return Helper::response('success', 'artwork added to folder', 200);
            } else {
                return Helper::response('error', 'folder not found', 404);
            }
        }
        return Helper::response('error', 'artwork not found', 404);
    }

    public function removeFromFolder(int $folder, int $artwork) // remove artwork from a folder
    {
        $artworkModel = Artworks::whereId($artwork)->first();
        if($artworkModel) {
            $userModel = User::whereId(auth()->user()->id)->first();
            if(!$userModel->catalogue)
            {
                $userModel->catalogue()->create();
                $userModel = User::whereId(auth()->user()->id)->first();

            }
            $folderModel = $userModel->catalogue->folders()->whereId($folder)->first();
            if ($folderModel) {
                if($folderModel->artworks()->whereId($artwork)->first()){
                    try{
                        $folderModel->artworks()->detach((int)$artwork);
                    }catch (\Exception $exception)
                    {
                        return Helper::response('error', 'internal server error', 500);
                    }
                    return Helper::response('success', 'removed from folder', 200);
                }
                return Helper::response('error', 'artwork not in folder', 400);
            } else {
                return Helper::response('error', 'folder not found', 404);
            }
        }
        return Helper::response('error', 'artwork not found', 404);
    }

}
