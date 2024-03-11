<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use App\Models\Companies;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function getcompanies(Request $request)
    {
        try {
            $companies = Companies::select('company_id', 'company_name', 'company_image_url', 'company_logo_url','company_phone')
            ->where('state',1)->orderby('priority', 'asc')->get();
            if (!$companies->isEmpty()) {
                $responseData = [
                    "success" => 1,
                    "companies" => $companies,
                    "message" => "Firmalar listesi getirildi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Firmalar listesi bulunamadı",
                ];
            }
        } catch (\Exception $e) {
            $responseData = [
                "success" => 0,
                "message" => $e->getMessage(),
            ];
        }
        return response()->json($responseData);
    }
}
