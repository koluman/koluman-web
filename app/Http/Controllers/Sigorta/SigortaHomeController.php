<?php

namespace App\Http\Controllers\Sigorta;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function sigortadetail(Request $request, $id)
    {
        $users = User::get();
        return view('sigorta.detail',compact('users'));

    }
    public function getallsigorta(Request $request)
    {
        try {
            $sigortaall = Insurance::select('insurance.*', 'a.*')
                ->join('users as a', 'insurance.user_id', '=', 'a.user_id')
                ->orderBy('insurance_id', 'desc')
                ->get();
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
    public function getbyIdSigorta(Request $request)
    {
        try {
            $sigortaid = Insurance::select('insurance.*', 'a.*')
                ->where('insurance_id',$request->id)
                ->join('users as a', 'insurance.user_id', '=', 'a.user_id')
                ->orderBy('insurance_id', 'desc')
                ->get();
            if ($sigortaid->isEmpty()) {
                $responseData = [
                    "sigortaid" => "",
                    "success" => 0,
                    "message" => "Sigorta talep bilgileri bulunamadı",
                ];
            } else {
                $responseData = [
                    "sigortaid" => $sigortaid,
                    "success" => 1,
                    "message" => "Sigorta talep bilgileri getirildi",
                ];
                $insurancePolicyPath = rtrim($sigortaid[0]->insurance_policy_url, '.');
                $insurancePolicySize = Storage::disk('public')->size($insurancePolicyPath);
                $responseData['insurance_policy_size'] = $insurancePolicySize;
   
            }
        } catch (\Exception $e) {
            $responseData = [
                "sigortaid" => "",
                "success" => 0,
                "message" => $e->getMessage(),
            ];
        }
        return response()->json($responseData);
    }
}
