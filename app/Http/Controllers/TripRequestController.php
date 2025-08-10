<?php

namespace App\Http\Controllers;

use App\Models\TripRequest;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TripRequestController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'destination_id' => 'required|exists:destinations,id',
            'travel_date' => 'required|date|after:today',
            'duration_days' => 'required|integer|min:1',
            'travelers_count' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Get destination
        $destination = Destination::findOrFail($request->destination_id);

        // Create trip request
        TripRequest::create([
            'user_id' => Auth::id(),
            'destination_id' => $request->destination_id,
            'travel_date' => $request->travel_date,
            'duration_days' => $request->duration_days,
            'travelers_count' => $request->travelers_count,
            'notes' => $request->notes,
            'status' => 'pending',
            'estimated_cost' => $this->calculateEstimatedCost($destination, $request),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال طلب الرحلة بنجاح! سوف نتصل بك قريباً لتأكيد التفاصيل.'
        ]);
    }

    private function calculateEstimatedCost(Destination $destination, Request $request)
    {
        // Simple cost estimation logic
        $dailyBudget = ($destination->min_daily_budget + $destination->max_daily_budget) / 2;
        return $dailyBudget * $request->duration_days * $request->travelers_count;
    }
}