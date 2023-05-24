<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{

    public function adminDashboardStatistics()
    {
        $users = DB::table('users')
            ->select(DB::raw('count(*) as totalUsers'))
            ->Where('isAdmin', 0)
            ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE())')
            ->get();
        $posts = DB::table('posts')
            ->select(DB::raw('count(*) as totalPosts'))
            ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE())')
            ->get();
        $chart = DB::table('posts')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        foreach ($chart as $item) {
            $item->month = 'Tháng ' . $item->month;
        }
        return response()->json(['users' => $users, 'posts' => $posts, 'chart' => $chart], 200);
    }
}
