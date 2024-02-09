<?php

namespace App\Http\Controllers\Mobil;
use App\Http\Controllers\Controller;
use App\Http\Requests\InsuranceAddRequest;
use App\Http\Requests\InsuranceDeleteRequest;
use App\Http\Requests\InsuranceUpdateRequest;
use App\Models\Insurance;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;


class InsuranceController extends Controller
{
    public function getuserinsurancelist(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $token);
            $u = JWTAuth::setToken($token)->authenticate();
            if ($u) {
                $columnsToSelect = [
                    'insurance_id', 'user_id', 'insurance_type', 'insurance_policy_url', 'insurance_request_date',
                    'insurance_review_date', 'insurance_result_date', 'insurance_end_date', 'insurance_price',
                    'insurance_description', 'insurance_state', 'insurance_author'
                ];
                $insurances = Insurance::select($columnsToSelect)->where('user_id', $u->user_id)->whereNotIn('insurance_state', 5)->get();
                if (!$insurances->isEmpty()) {
                    $responseData = [
                        "success" => 1,
                        "insurances" => $insurances,
                        "message" => "Kullanıcı Sigorta listesi getirildi",
                    ];
                } else {
                    $responseData = [
                        "success" => 0,
                        "insurances" => "",
                        "message" => "Kullanıcı Sigorta listesi bulunamadı",
                    ];
                }
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Bir hata oluştu, lütfen tekrar deneyiniz.",
                ];
            }
        } catch (\Exception $e) {
            $responseData = [
                "success" => 0,
                "shoowroom" => "",
                "message" => $e->getMessage(),
            ];
        }
        return response()->json($responseData);
    }
    public function adduserinsurancelist(InsuranceAddRequest $request)
    {
        try {

            $token = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $token);
            $u = JWTAuth::setToken($token)->authenticate();
            if ($u) {
                $insurance_description = $request->insurance_description;
                $insurance_type = $request->insurance_type;
                $user_id = $u->user_id;
                $insurance_author = $request->insurance_author;
                $affectedRows = Insurance::insert([
                    'user_id' => $user_id,
                    'insurance_description' => $insurance_description,
                    'insurance_type' => $insurance_type,
                    'insurance_author' => $insurance_author,
                    'insurance_state' => 1
                ]);
                if ($affectedRows > 0) {
                    $responseData = [
                        "success" => 1,
                        "message" => "Sigorta talebiniz başarılı bir şekilde oluşturuldu",
                    ];
                } else {
                    $responseData = [
                        "success" => 0,
                        "message" => "Sigorta talebiniz oluşturulamadı , lütfen tekrar deneyiniz",
                    ];
                }
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Bir hata oluştu, lütfen tekrar deneyiniz.",
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

    public function deleteuserinsurancelist(InsuranceDeleteRequest $request)
    {
        try {
            $token = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $token);
            $u = JWTAuth::setToken($token)->authenticate();
            if ($u) {
                $insurance_id = $request->insurance_id;
                $insurance = Insurance::where('insurance_id', $insurance_id)->first();
                if ($insurance->user_id == $u->user_id || $u->user_role == "admin") {
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
            } else {
                $responseData = [
                    "success" => 0,
                    "testDrives" => "",
                    "message" => "Bir hata oluştu, lütfen tekrar deneyiniz.",
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
    public function updateuserinsurancelist(InsuranceUpdateRequest $request)
    {
        try {

            $token = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $token);
            $u = JWTAuth::setToken($token)->authenticate();
            if ($u) {
                $insurance_description = $request->insurance_description;
                $insurance_type = $request->insurance_type;
                $user_id = $u->user_id;
                $insurance_id = $request->insurance_id;
                $affectedRows = Insurance::where('insurance_id', $insurance_id)->update([
                    'insurance_description' => $insurance_description,
                    'insurance_type' => $insurance_type,
                ]);
                if ($affectedRows > 0) {
                    $responseData = [
                        "success" => 1,
                        "message" => "Sigorta talebiniz başarılı bir şekilde güncellendi",
                    ];
                } else {
                    $responseData = [
                        "success" => 0,
                        "message" => "Sigorta talebiniz güncellenemedi , lütfen tekrar deneyiniz",
                    ];
                }
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Bir hata oluştu, lütfen tekrar deneyiniz.",
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
