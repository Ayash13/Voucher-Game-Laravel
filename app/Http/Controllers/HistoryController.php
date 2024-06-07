<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = History::with(['user', 'product', 'payment'])->where('id_user', auth()->id())->get();
        return view('history', compact('histories'));
    }

    public function adminIndex()
    {
        $histories = History::with(['user', 'product', 'payment'])->get();
        return view('admin.history', compact('histories'));
    }
}
