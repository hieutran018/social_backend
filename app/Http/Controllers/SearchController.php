<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\MemberGroup;
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
                $dataGroup = Group::WHERE('group_name','LIKE',"%$input%")->limit(4)->get();
                 foreach($dataGroup as $group){
                    
                    $group->avatar = $group->avatar == null ? 
                            URL::to('default/avatar_group_default.jpg'):
                            URL::to('media_file_post/'.$group->avatar);
                            $group->totalMember = MemberGroup::WHERE('group_id',$group->id)->WHERE('status',1)->count();
                }
        return response(['users'=>$dataUser,'groups'=>$dataGroup],200);
    }
}