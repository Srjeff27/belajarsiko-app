<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function show(Course $course)
    {
        return view('student.checkout', compact('course'));
    }

    public function confirm(Request $request, Course $course)
    {
        $validated = $request->validate([
            'payer_name' => ['required', 'string', 'max:255'],
            'payer_bank' => ['required', 'string', 'max:255'],
            'payment_proof' => ['required', 'image', 'max:4096'],
        ]);

        $path = $request->file('payment_proof')->store('', 'private_proofs');

        Transaction::create([
            'user_id' => $request->user()->id,
            'course_id' => $course->id,
            'amount' => $course->price,
            'status' => 'waiting_verification',
            'payment_proof_path' => $path,
            'payer_name' => $validated['payer_name'],
            'payer_bank' => $validated['payer_bank'],
        ]);

        return to_route('student.payment.waiting');
    }

    public function waiting()
    {
        return view('student.payment-waiting');
    }
}
