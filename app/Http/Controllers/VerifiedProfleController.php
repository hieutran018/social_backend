<?php

namespace App\Http\Controllers;

use App\Models\ProfileVerifiedRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class VerifiedProfleController extends Controller
{
    public function verifiedProfile(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $isExist = ProfileVerifiedRecord::Where('user_id', $userId)->first();
        if ($isExist) {
            //TODO: cập nhật lại hoặc trả về lỗi đã tồn tại
            return response()->json('Tài khoản đã được xác minh từ trước!', 200);
        } else {
            $new = new ProfileVerifiedRecord();
            $new->user_id = $userId;
            $new->name = $request->name;
            $new->document_type = $request->documentType;
            if ($request->hasFile('file1')) {
                $file = $request->file('file1');
                $fileExtentsion = $file->getClientOriginalExtension();
                $random = Str::random(10);
                $fileName = time() . $random . '.' . $fileExtentsion;
                $file->move('verified_profile/', $fileName);
                $new->verified_image_front = $fileName;
            }
            if ($request->hasFile('file2')) {
                $file = $request->file('file2');
                $fileExtentsion = $file->getClientOriginalExtension();
                $random = Str::random(10);
                $fileName = time() . $random . '.' . $fileExtentsion;
                $file->move('verified_profile/', $fileName);
                $new->verified_image_backside = $fileName;
            }
            $new->outstanding_type = $request->outstandingType;
            $new->county = $request->county;
            $new->quote_one = $request->quoteOne;
            $new->quote_two = $request->quoteTwo;
            $new->quote_three = $request->quoteThree;
            $new->quote_four = $request->quoteFour;
            $new->quote_five = $request->quoteFive;
            $new->status = 0;
            $new->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $new->save();
            return response()->json('Gửi xác minh thành công!', 200);
        }
    }
}
