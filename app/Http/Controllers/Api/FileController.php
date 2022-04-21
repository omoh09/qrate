<?php

namespace App\Http\Controllers\Api;

use App\File;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileController extends Controller
{
    
    public function destroy($file)
    {
        $file = File::whereId($file)->first();
        if($file)
        {
            $owner = $file->owner()->where('user_id',auth()->user()->id);
            if($owner)
            {
                $file->delete();
                return Helper::response('sucess','file deleted');
            }
            return Helper::response('error','file not found',404);    
        }
        return Helper::response('error','file not found',404);
    }
}
