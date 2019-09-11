<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvatarController extends Controller
{
    
    public function image($image)
    {
        
        return response()->file(storage_path('app/public/images/' . $image));
    }
}
