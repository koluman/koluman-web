<?php

namespace App\Http\Controllers\Sigorta;

use App\Http\Controllers\Controller;
use App\Http\Requests\InsuranceDeleteRequest;
use App\Http\Requests\InsuranceAddWebRequest;
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
    public function sigortadetail(Request $request)
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
                    'insurance_review_date' => Carbon::now('Europe/Istanbul'),
                ]);
            if ($affectedRows > 0) {
                $updatedInsurance = Insurance::where('insurance_id', $insurance_id)->first();
                $responseData = [
                    "insurance" => $updatedInsurance,
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
                    'insurance_result_date' => Carbon::now('Europe/Istanbul'),
                ]);
            if ($affectedRows > 0) {
                $updatedInsurance = Insurance::where('insurance_id', $insurance_id)->first();
                $responseData = [
                    "insurance" => $updatedInsurance,
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
    public function addsigorta(InsuranceAddWebRequest $request)
    {
        try {
            $insurancePrice = $request->input('insurance_price');
            $insuranceEndDate = $request->input('insurance_end_date');

            $insuranceDescription = $request->input('insurance_description');
            $insuranceRequestDate = $request->input('insurance_request_date');
            $insuranceReviewDate = $request->input('insurance_review_date');
            $insuranceResultDate = $request->input('insurance_result_date');

            $insuranceReviewDate = !empty($insuranceReviewDate) ? $insuranceReviewDate . ' ' . date('H:i:s') : null;
            $insuranceResultDate = !empty($insuranceResultDate) ? $insuranceResultDate . ' ' . date('H:i:s') : null;
            $insuranceRequestDate = !empty($insuranceRequestDate) ? $insuranceRequestDate . ' ' . date('H:i:s') : null;
            $insuranceEndDate = !empty($insuranceEndDate) ? $insuranceEndDate . ' ' . date('H:i:s') : null;            
            $insurance_type = $request->input('insurance_type');
            $insurance_state = $request->input('insurance_state');
            $user_id = $request->input('user_id');
            $pdfPath = "";
            if ($request->hasFile('insurance_policy_url')) {
                $pdf = $request->file('insurance_policy_url');
                $pdfName = time() . '.' . $pdf->getClientOriginalExtension();
                $pdf->move(public_path('upload/pdf'), $pdfName);
                $pdfPath = 'https://mobiloby.app/koluman/web/public/upload/pdf/' . $pdfName;
            } else {
                $pdfPath = "";
            }
            $result = Insurance::create([
                'insurance_type' => $insurance_type,
                'insurance_price' => $insurancePrice,
                'insurance_end_date' => $insuranceEndDate,
                'insurance_description' => $insuranceDescription,
                'insurance_request_date' => $insuranceRequestDate,
                'insurance_review_date' => $insuranceReviewDate,
                'insurance_result_date' => $insuranceResultDate,
                'insurance_state' => $insurance_state,
                'insurance_author' => 1,
                'user_id' => $user_id,
                'insurance_policy_url' => $pdfPath, // Dosyanın URL'sini kaydet
            ]);
            if ($result) {
                $responseData = [
                    "result" => $result,
                    "success" => 1,
                    "message" => "Sigorta talebi oluşturuldu",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Sigorta talebi oluşturulamadı, lütfen tekrar deneyiniz",
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
    public function deletesigortapoliçe(Request $request)
    {
        try {
            $insurance_id = $request->insurance_id;

            $affectedRows = Insurance::where('insurance_id', $insurance_id)
                ->update([
                    'insurance_policy_url' =>"",
                ]);
            if ($affectedRows > 0) {
                $responseData = [
                    "insurance" => $affectedRows,
                    "success" => 1,
                    "message" => "Poliçe silindi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Poliçe silinemedi",
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
    public function updatesigorta(InsuranceAddWebRequest $request)
    {
        try {
            $insurancePrice = $request->input('insurance_price');
            $insuranceEndDate = $request->input('insurance_end_date');
            $insurance_id = $request->input('insurance_id');

            $insuranceDescription = $request->input('insurance_description');
            $insuranceRequestDate = $request->input('insurance_request_date');
            $insuranceReviewDate = $request->input('insurance_review_date');
            $insuranceResultDate = $request->input('insurance_result_date');

            $insuranceReviewDate = !empty($insuranceReviewDate) ? $insuranceReviewDate : null;
            $insuranceResultDate = !empty($insuranceResultDate) ? $insuranceResultDate : null;
            $insuranceRequestDate = !empty($insuranceRequestDate) ? $insuranceRequestDate : null;
            $insuranceEndDate = !empty($insuranceEndDate) ? $insuranceEndDate : null;            
            $insurance_type = $request->input('insurance_type');
            $insurance_state = $request->input('insurance_state');
            $user_id = $request->input('user_id');
            $pdfPath = "";

            if ($request->hasFile('insurance_policy_url')) {
                $pdf = $request->file('insurance_policy_url');
                $pdfName = time() . '.' . $pdf->getClientOriginalExtension();
                $pdf->move(public_path('upload/pdf'), $pdfName);
                $pdfPath = 'https://mobiloby.app/koluman/web/public/upload/pdf/' . $pdfName;
                $affectedRows = Insurance::where('insurance_id', $insurance_id)
                ->update([
                    'insurance_type' => $insurance_type,
                    'insurance_price' => $insurancePrice,
                    'insurance_end_date' => $insuranceEndDate,
                    'insurance_description' => $insuranceDescription,
                    'insurance_request_date' => $insuranceRequestDate,
                    'insurance_review_date' => $insuranceReviewDate,
                    'insurance_result_date' => $insuranceResultDate,
                    'insurance_state' => $insurance_state,
                    'insurance_author' => 1,
                    'user_id' => $user_id,
                    'insurance_policy_url' => $pdfPath,
                ]);
            } else {
                $affectedRows = Insurance::where('insurance_id', $insurance_id)
                ->update([
                    'insurance_type' => $insurance_type,
                    'insurance_price' => $insurancePrice,
                    'insurance_end_date' => $insuranceEndDate,
                    'insurance_description' => $insuranceDescription,
                    'insurance_request_date' => $insuranceRequestDate,
                    'insurance_review_date' => $insuranceReviewDate,
                    'insurance_result_date' => $insuranceResultDate,
                    'insurance_state' => $insurance_state,
                    'insurance_author' => 1,
                    'user_id' => $user_id,
                ]);
            }
            if ($affectedRows > 0) {
                $responseData = [
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
}
