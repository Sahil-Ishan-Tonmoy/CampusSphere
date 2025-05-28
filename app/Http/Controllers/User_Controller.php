<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class User_Controller extends Controller
{
   public function index(Request $request)
{
    
    
   return view('Sign.qr', [
        
    ]);
}

}
