<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use App\Models\Note;
use Inertia\Inertia;
use Auth;

class WorkController extends Controller
{
    public function index(){
        $publicWorks=Work::where('is_public',true)->with('user')->get();
        $userWorks=Auth::check()? Work::where('user_id',Auth::id())->get() : [];
        return Inertia('Work/Home',[
            'publicWorks'=>$publicWorks,
            'userWorks'=>$userWorks,
            'isAuthenticated' => Auth::check(),
        ]);
    }
    
    public function myWorks()
    {
        $works = Work::with('tags')->where('user_id', auth()->id())->get();
        return Inertia::render('Work/MyWorks', [
            'works' => $works,
        ]);

    }
    
    public function showNote(Work $work){
        $note=$work->note;
        return Inertia("Work/ShowNote",[
            "work"=>$work,
            'note'=>$note,
        ]);
    }
    public function openWorkspace(Work $work){
        $note=$work->note;
        return Inertia("Work/Workspace",[
            'work'=>$work,
            'note'=>$note,
            ]);
    }
    public function createWorkspace(){
        return inertia('Work/Create');
    }
    
    public function store(Request $request){
        $validated=$request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_public' => 'required|boolean',
        ]);
        $work=Work::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'is_public' => $validated['is_public'],
            'user_id' => auth()->id(), 
        ]);
        $note=Note::create([
            'work_id'=>$work->id,
            'html_path'=>'',
        ]);
        
        return redirect()->route('workspace', $work->id)->with('success', 'Work created successfully');
    }
    
    public function update(Request $request, Work $work) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'html_path' => 'required|string|max:255',
        ]);
    
        $work->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);
    
        $note = $work->note;
        $note->update(['html_path' => $validated['html_path']]);
    
        return redirect()->route('home')->with('success', 'Work updated successfully');
    }
    
    public function togglePublic(Request $request, Work $work) {
        $validated = $request->validate([
            'is_public' => 'required|boolean',
        ]);
        $work->update([
            'is_public' => $validated['is_public'] ?? $work->is_public, 
        ]);
    
        
    }
    
    public function destroy(Work $work)
    {
        $work->delete();
        return redirect()->route('myWorks')->with('success', 'ワークを削除しました。');
    }


}
