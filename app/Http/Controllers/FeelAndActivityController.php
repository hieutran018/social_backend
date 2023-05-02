<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeelAndActivity;
use URL;

class FeelAndActivityController extends Controller
{
    public function fetchFeelAndActivity()
    {
        $lstIcon = FeelAndActivity::get();
        foreach ($lstIcon as $icon) {
            $icon->patch = URL::to('icon/' . $icon->patch);
        }
        return response()->json($lstIcon, 200);
    }
    public function searchFeelAnActivity($input)
    {
        $result = FeelAndActivity::WHERE('icon_name', 'LIKE', "%$input%")->get();
        foreach ($result as $icon) {
            $icon->patch = URL::to('icon/' . $icon->patch);
        }
        return response()->json($result, 200);
    }
}
