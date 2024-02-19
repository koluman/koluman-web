<?php

namespace App\Http\Controllers\Ajans;

use App\Http\Controllers\Controller;
use App\Models\Companies;
use Illuminate\Http\Request;

class AnnouncementsController extends Controller
{
    
    public function announcements(Request $request)
    {
        $companies = Companies::with(['showrooms', 'showrooms.cars'])->get();

        foreach ($companies as $company) {
            $carCount = 0;

            foreach ($company->showrooms as $showroom) {
                $carCount += $showroom->cars->count();
            }

            $company->setAttribute('carCount', $carCount);
        }

        return view('ajans.announcements', compact('companies'));
    }
}
