<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\TripRequest;
use App\Models\ContactMessage;
use App\Models\Recommendation;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        $popularDestinations = Destination::popular()->take(6)->get();
        
        return view('home', compact('popularDestinations'));
    }

    /**
     * Handle trip request submission.
     */
    public function submitTripRequest(Request $request)
    {
        $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'travel_date' => 'required|date|after:today',
            'duration_days' => 'required|integer|min:1|max:30',
            'travelers_count' => 'required|integer|min:1|max:10',
            'notes' => 'nullable|string|max:1000',
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'يجب تسجيل الدخول لطلب رحلة'
            ]);
        }

        $tripRequest = TripRequest::create([
            'request_number' => TripRequest::generateRequestNumber(),
            'user_id' => Auth::id(),
            'destination_id' => $request->destination_id,
            'travel_date' => $request->travel_date,
            'duration_days' => $request->duration_days,
            'travelers_count' => $request->travelers_count,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال طلب رحلتك بنجاح! سيتواصل معك فريقنا قريباً.',
            'request_number' => $tripRequest->request_number
        ]);
    }

    /**
     * Handle contact form submission.
     */
    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.'
        ]);
    }

    /**
     * Handle recommendation request.
     */
    public function getRecommendation(Request $request)
    {
        $request->validate([
            'budget' => 'required|integer|min:100|max:2000',
            'travel_month' => 'required|string',
            'weather_preference' => 'required|string',
            'trip_type' => 'required|string',
        ]);

        // Get matching destinations based on criteria
        $destinations = Destination::withinBudget($request->budget)
            ->forMonth($request->travel_month)
            ->forWeather($request->weather_preference)
            ->forTripType($request->trip_type)
            ->take(3)
            ->get();

        // If no exact matches, get closest matches
        if ($destinations->isEmpty()) {
            $destinations = Destination::withinBudget($request->budget)
                ->take(3)
                ->get();
        }

        // Save recommendation if user is logged in
        if (Auth::check()) {
            Recommendation::create([
                'user_id' => Auth::id(),
                'budget' => $request->budget,
                'travel_month' => $request->travel_month,
                'weather_preference' => $request->weather_preference,
                'trip_type' => $request->trip_type,
                'recommended_destinations' => $destinations->pluck('id')->toArray(),
                'recommendation_reason' => $this->generateRecommendationReason($request, $destinations),
            ]);
        }

        return response()->json([
            'success' => true,
            'destinations' => $destinations->map(function ($destination) {
                return [
                    'id' => $destination->id,
                    'name_ar' => $destination->name_ar,
                    'description_ar' => $destination->description_ar,
                    'currency' => $destination->currency,
                    'exchange_rate' => $destination->exchange_rate,
                    'min_daily_budget' => $destination->min_daily_budget,
                    'max_daily_budget' => $destination->max_daily_budget,
                    'image_url' => $destination->image_url,
                    'badge_text_ar' => $destination->badge_text_ar,
                    'badge_type' => $destination->badge_type,
                ];
            }),
            'message' => 'تم العثور على ' . $destinations->count() . ' وجهات مناسبة لتفضيلاتك!'
        ]);
    }

    /**
     * Generate recommendation reason text.
     */
    private function generateRecommendationReason($request, $destinations)
    {
        $reasons = [];
        
        if ($destinations->count() > 0) {
            $reasons[] = "تم اختيار هذه الوجهات بناءً على ميزانيتك اليومية ({$request->budget} ريال)";
            $reasons[] = "مناسبة للسفر في شهر {$request->travel_month}";
            $reasons[] = "تتميز بالطقس {$request->weather_preference}";
            $reasons[] = "مثالية لرحلات {$request->trip_type}";
        }

        return implode('، ', $reasons);
    }

    /**
     * Get destinations data for AJAX requests.
     */
    public function getDestinations()
    {
        $destinations = Destination::all();
        
        return response()->json($destinations);
    }
}