<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use Inertia\Inertia;
use Auth;

class WorkController extends Controller
{
    public function index(){
        $publicWorks=Work::where('is_public',true)->with('user')->get();
        $userWorks=Work::where('user_id',Auth::id())->get();
        return inertia('Work/Home',[
            'publicWorks'=>$publicWorks,
            'userWorks'=>$userWorks
        ]);
    }
    public function showNote(Work $work){
        return inertia("Work/Show",["work"=>$work]);
    }
}
