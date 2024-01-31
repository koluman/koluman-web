<?php

namespace App\Http\Controllers\Sigorta;

use App\Http\Controllers\Controller;
use App\Http\Requests\InsuranceDeleteRequest;
use App\Models\Insurance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
        return view('sigorta.detail', compact('users'));
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
                ->where('insurance_id', $request->id)
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
    public function deletesigorta(InsuranceDeleteRequest $request)
    {
        try {
            $insurance_id = $request->insurance_id;
            $insurance = Insurance::where('insurance_id', $insurance_id)->first();
            if ($insurance) {
                $insurance->delete();
                $responseData = [
                    "success" => 1,
                    "message" => "Sigorta talebi başarıyla silindi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Silmek istediğiniz Sigorta talebi size ait değil!",
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
    public function updatesigortareview(Request $request)
    {
        try {
            $insurance_id = $request->insurance_id;
            
            $affectedRows = Insurance::where('insurance_id', $insurance_id)
            ->update([
                'insurance_review_date' =>Carbon::now('Europe/Istanbul'),
            ]);
            if ($affectedRows > 0) {
                $responseData = [
                    "sonuc" => $affectedRows,
                    "success" => 1,
                    "message" => "İncelendi durumu güncellendi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "İncelendi durumu güncellenemedi , lütfen tekrar deneyiniz",
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
    public function updatesigortaresult(Request $request)
    {
        try {
            $insurance_id = $request->insurance_id;
            
            $affectedRows = Insurance::where('insurance_id', $insurance_id)
            ->update([
                'insurance_result_date' =>Carbon::now('Europe/Istanbul'),
            ]);
            if ($affectedRows > 0) {
                $responseData = [
                    "sonuc" => $affectedRows,
                    "success" => 1,
                    "message" => "Sonuçlandırıldı durumu güncellendi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Sonuçlandırıldı durumu güncellenemedi , lütfen tekrar deneyiniz",
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
