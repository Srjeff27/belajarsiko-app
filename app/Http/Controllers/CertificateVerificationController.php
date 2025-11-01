<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateVerificationController extends Controller
{
    /**
     * Public certificate verification page at /verify?code=XXXX
     */
    public function show(Request $request)
    {
        $input = $request->query('code');
        $normalized = $input !== null ? strtoupper(trim($input)) : null;

        $certificate = null;
        if (!empty($normalized)) {
            $certificate = Certificate::with(['user', 'course'])
                ->where('unique_code', $normalized)
                ->first();
        }

        return view('verify', [
            'code' => $normalized,
            'certificate' => $certificate,
        ]);
    }
}
