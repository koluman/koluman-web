<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsuranceAddRequest;
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
                   'insurance_id','user_id','insurance_type','insurance_policy_url','insurance_request_date',
                   'insurance_review_date','insurance_result_date','insurance_end_date','insurance_price',
                   'insurance_description','insurance_state','insurance_author'
                ];
                $insurances = Insurance::select($columnsToSelect)->where('user_id',$u->user_id)->get();
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
                    'insurance_policy_url'=>""
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
}
