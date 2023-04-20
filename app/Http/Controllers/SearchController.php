<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use URL;

class SearchController extends Controller
{
    public function searchData(Request $request, $input = null){
        $dataUser = User::WHERE('email_verified_at','!=',null)
                    ->Where(function($query) use( $input){
                        $query->where('first_name','LIKE',"%$input%")
                        ->orWhere('last_name','LIKE',"%$input%");
                })->limit(4)->get();
                foreach($dataUser as $user){
                    $user->username = $user->first_name.' '.$user->last_name;
                    $user->avatar = $user->avatar == null ? 
                            ($user->sex === 0 ? URL::to('default/avatar_default_female.png') :URL::to('default/avatar_default_male.png'))
                            :
                            URL::to('media_file_post/'.$user->id.'/'.$user->avatar);
                }
        return response($dataUser,200);
    }
}