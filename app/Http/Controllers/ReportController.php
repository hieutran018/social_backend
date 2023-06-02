<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ReportController extends Controller
{
    public function createReport(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $new = new Report();
        $new->user_id = $userId;
        $new->object_type = $request->objectType;
        $new->object_id = $request->objectId;
        $new->conent_report = $request->contentReport;
        $new->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $new->save();
        return response()->json($new, 200);
    }
}
