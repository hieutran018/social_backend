<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeelAndActivity;
use Illuminate\Http\Request;
use URL;
use JWTAuth;
use Illuminate\Support\Str;
use Carbon\Carbon;

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

    public function createFeelAndActivity(Request $request)
    {
        $isAdmin = JWTAuth::toUser($request->token)->isAdmin;
        if ($isAdmin === 1) {
            $new = new FeelAndActivity();
            $new->icon_name = $request->iconName;
            if ($request->hasFile('file')) {
                $file = $request->file;
                $fileExtentsion = $file->getClientOriginalExtension();
                $random = Str::random(10);
                $fileName = time() . $random . '.' . $fileExtentsion;
                $file->move('icon/', $fileName);
                $new->patch = $fileName;
                $new->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $new->save();
                return response()->json($new, 200);
            }
        } else {
            return response()->json('Bạn không có quyền thực hiện thao tác này', 403);
        }
    }
}
