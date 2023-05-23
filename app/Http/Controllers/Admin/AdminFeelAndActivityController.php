<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeelAndActivity;
use Illuminate\Http\Request;
use URL;

class AdminFeelAndActivityController extends Controller
{
    public function fetchListFeelAndActivity()
    {
        $FAs = FeelAndActivity::Select('id', 'icon_name', 'patch', 'created_at', 'status')->get();
        foreach ($FAs as $FA) {
            $FA->patch = URL::to('icon/' . $FA->patch);
            $FA->status = $FA->status === 0 ? 'Ẩn' : 'Hiện';
        }
        return response()->json($FAs, 200);
    }
}
