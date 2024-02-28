<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use App\Models\Stories;
use Illuminate\Http\Request;

class StoriesController extends Controller
{
    public function getshowroomcars(Request $request)
    {
        try {
            $story = Stories::where('story_state', 1)
                ->select('story_id', 'company_id', 'story_title', 'story_small_image', 'story_big_image', 'story_priority', 'story_state')
                ->orderBy('story_priority', 'asc')->get();

            if (!$story->isEmpty()) {
                $responseData = [
                    "success" => 1,
                    "stories" => $story,
                    "message" => "Hikaye listesi getirildi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Hikaye listesi bulunamadı",
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
