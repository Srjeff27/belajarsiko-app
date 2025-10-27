<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:student']);
    }

    public function index(Request $request)
    {
        $transactions = $request->user()
            ->transactions()
            ->with('course')
            ->latest()
            ->get();

        return view('student.purchases-index', compact('transactions'));
    }
}

