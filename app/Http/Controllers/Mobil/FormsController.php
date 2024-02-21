<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormsAddRequest;
use App\Models\Forms;
use Illuminate\Http\Request;

class FormsController extends Controller
{
    public function addforms(FormsAddRequest $request)
    {
        try {
         
                $type = $request->type;
                $firstname = $request->firstname;
                $lastname = $request->lastname;
                $phone = $request->phone;
                $email = $request->email;
                $city = ($request->city != "") ? $request->city : "";
                $message = $request->message;
                $insurance_type = empty($insurance_type) ? "" : $insurance_type;

                $affectedRows = Forms::insert([
                    'type' => $type,
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'phone' => $phone,
                    'email' => $email,
                    'city' => $city,
                    'message' => $message,
                    'insurance_type' => $insurance_type,
                ]);
                if ($affectedRows > 0) {
                    $responseData = [
                        "success" => 1,
                        "message" => "Forma bilgiler kaydedildi",
                    ];
                } else {
                    $responseData = [
                        "success" => 0,
                        "message" => "Forma bilgiler kaydedilemedi , lütfen tekrar deneyiniz",
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
