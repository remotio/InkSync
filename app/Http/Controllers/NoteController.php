<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Inertia\Inertia;

class NoteController extends Controller
{
    public function showTestNote()
    {
        return inertia('Work/Editor'); 
    }
}
