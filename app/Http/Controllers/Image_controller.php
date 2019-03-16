<?php

namespace App\Http\Controllers;

class Image_controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function image(request $request){
        return response()->json("test");
    }

}
