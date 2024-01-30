<?php

namespace App\Http\Controllers\Sigorta;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use Illuminate\Http\Request;

class SigortaHomeController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('sigorta.dashboard');
    }
    public function sigorta(Request $request)
    {
        return view('sigorta.list');
    }
    public function getallsigorta(Request $request)
    {
        try {
            $sigortaall = Insurance::orderBy('insurance_id', 'desc')->get();
            if ($sigortaall->isEmpty()) {
                $responseData = [
                    "sigortaall" => "",
                    "success" => 0,
                    "message" => "Sigorta talep bilgileri bulunamadı",
                ];
            } else {
                $responseData = [
                    "sigortaall" => $sigortaall,
                    "success" => 1,
                    "message" => "Sigorta talep bilgileri getirildi",
                ];
            }
        } catch (\Exception $e) {
            $responseData = [
                "sigortaall" => "",
                "success" => 0,
                "message" => $e->getMessage(),
            ];
        }
        return response()->json($responseData);
    }
}
