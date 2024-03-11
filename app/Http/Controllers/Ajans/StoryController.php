<?php

namespace App\Http\Controllers\Ajans;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function storylist(Request $request)
    {
        return view('ajans.story');
    }
}
