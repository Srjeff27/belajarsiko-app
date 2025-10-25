<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class TransactionProofController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function show(Transaction $transaction)
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);

        if (!$transaction->payment_proof_path || !Storage::disk('private_proofs')->exists($transaction->payment_proof_path)) {
            abort(404);
        }

        return response()->file(Storage::disk('private_proofs')->path($transaction->payment_proof_path));
    }
}
