<?php

namespace App\Http\Controllers;

use App\Http\Resources\LicenseResource;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class LicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $license = new License();
        $license->user_id = $request->user_id;
        $license->product_id = $request->product_id;
        $license->domain = $request->domain;
        $license->license_key = Str::uuid();
        $license->expiration_date = Carbon::now()->addMonth($request->expiration_date);
        $license->is_trial = $request->is_trial ? $request->is_trial : false;
        $license->save();

        return response()->json(['message' => 'License Created Successfully!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function verify(Request $request)
    {
        $request->validate([
            'license_key' => ['required', 'string', 'uuid'],
        ]);

        $license = License::where('license_key', $request->license_key)
            ->where('domain', $request->domain )
            ->firstOrFail();

        if ($license->is_trial === 1) {
            $diff =Carbon::parse($license->expiration_date)->diffForHumans();
            return response(['message' => "Trial License Validity Period for $diff Days"], 401);
        }

        if ($license->expiration_date < now()) {
            return response(['message' => 'Expired license key.',], 401);
        }
        if ($license->active === 1) {
            return LicenseResource::make($license);
        }
        return response(['message' => 'This license is not Active. Please contact the license provider!',], 401);
    }
}
