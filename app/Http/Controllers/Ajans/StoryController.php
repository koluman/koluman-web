<?php

namespace App\Http\Controllers\Ajans;

use App\Http\Controllers\Controller;
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
            $stories = Stories::select('stories.story_id',
            'companies.company_id','companies.company_name',
            'stories.story_title','stories.story_small_image',
            'stories.story_big_image','stories.story_priority',
            'stories.story_state')
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
                    "storyid" =>"",
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
}
