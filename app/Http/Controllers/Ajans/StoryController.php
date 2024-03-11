<?php

namespace App\Http\Controllers\Ajans;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoryRequest;
use App\Models\Stories;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function story(Request $request)
    {
        return view('ajans.story');
    }
    public function storydetail(Request $request)
    {
        return view('ajans.storydetail');
    }
    public function getstories(Request $request)
    {
        try {
            $stories = Stories::select(
                'stories.story_id',
                'companies.company_id',
                'companies.company_name',
                'stories.story_title',
                'stories.story_small_image',
                'stories.story_big_image',
                'stories.story_priority',
                'stories.story_state'
            )
                ->join('companies', 'stories.company_id', '=', 'companies.company_id')
                ->orderBy('stories.story_id', 'asc')
                ->get();

            if (!$stories->isEmpty()) {
                $responseData = [
                    "success" => 1,
                    "stories" => $stories,
                    "message" => "Hikayeler listesi getirildi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Hikayeler listesi bulunamadı",
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
    public function getstoryid(Request $request)
    {
        try {
            $storyid = Stories::where('story_id', $request->story_id)->get();
            if (!$storyid->isEmpty()) {
                $responseData = [
                    "success" => 1,
                    "storyid" => $storyid,
                    "message" => "Liste getirildi",
                ];
            } else {
                $responseData = [
                    "storyid" => "",
                    "success" => 1,
                    "message" => "Liste bulunamadı",
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

    public function storyprocess(StoryRequest $request)
    {
        try {
           
            $story_state = $request->story_state;
            $story_title = $request->story_title;
            $story_priority = $request->story_priority;
            $company_id = $request->company_id;
            $story_id = $request->story_id;
            if ($story_id != "") {
                $affectedRows = 0;
                if ($request->hasFile('story_big_image')) {
                    $s = $request->file('story_big_image');
                    $sName = time() . '.' . $s->getClientOriginalExtension();
                    $s->move(public_path('upload/story'), $sName);
                    $sPath = 'https://mobiloby.app/koluman/web/public/upload/story/' . $sName;
        
                    $affectedRows += Stories::where('story_id', $story_id)
                        ->update([
                            'story_big_image' => $sPath,
                        ]);
                }
        
                if ($request->hasFile('story_small_image')) {
                    $s2 = $request->file('story_small_image');
                    $sName2 = time() . '.' . $s2->getClientOriginalExtension();
                    $s2->move(public_path('upload/story'), $sName2);
                    $sPath2 = 'https://mobiloby.app/koluman/web/public/upload/story/' . $sName2;
        
                    $affectedRows += Stories::where('story_id', $story_id)
                        ->update([
                            'story_small_image' => $sPath2,
                        ]);
                }
                $affectedRows += Stories::where('story_id', $story_id)
                ->update([
                    'story_state' => $story_state,
                    'story_title' => $story_title,
                    'story_priority' => $story_priority,
                    'company_id' => $company_id,
                ]);
                if ($affectedRows > 0) {
                    $responseData = [
                        "success" => 1,
                        "message" => "Araba detayları güncellendi",
                    ];
                } else {
                    $responseData = [
                        "success" => 0,
                        "message" => "Araba detayları güncellenemedi , lütfen tekrar deneyiniz",
                    ];
                }
            } else {
                $path = "";
                if ($request->hasFile('story_big_image')) {
                    $im = $request->file('story_big_image');
                    $imName = time() . '.' . $im->getClientOriginalExtension();
                    $im->move(public_path('upload/story'), $imName);
                    $path = 'https://mobiloby.app/koluman/web/public/upload/story/' . $imName;
                }
                if ($request->hasFile('story_small_image')) {
                    $im2 = $request->file('story_small_image');
                    $imName2 = time() . '.' . $im2->getClientOriginalExtension();
                    $im2->move(public_path('upload/story'), $imName2);
                    $path2 = 'https://mobiloby.app/koluman/web/public/upload/story/' . $imName2;
                } else {
                    $path = "";
                    $path2 = "";
                }
                $result = Stories::create([
                    'story_state' => $story_state,
                    'story_title' => $story_title,
                    'story_priority' => $story_priority,
                    'company_id'=>$company_id,
                    'story_big_image'=>$path,
                    'story_small_image'=>$path2

                ]);
                if ($result) {
                    $responseData = [
                        "result" => $result,
                        "success" => 1,
                        "message" => "Hikaye  eklendi",
                    ];
                } else {
                    $responseData = [
                        "success" => 0,
                        "message" => "Hikaye eklenemedi, lütfen tekrar deneyiniz",
                    ];
                }
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
