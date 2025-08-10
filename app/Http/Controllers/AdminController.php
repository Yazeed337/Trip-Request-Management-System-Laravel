<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Destination;
use App\Models\TripRequest;
use App\Models\ContactMessage;
use App\Models\Recommendation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function contactMessages()
{
    $messages = ContactMessage::latest()->get();
    return view('admin.contact-messages', compact('messages'));
}

public function markAsRead(ContactMessage $message)
{
    $message->markAsRead();
    return back()->with('message_success', 'تم تعليم الرسالة كمقروءة');
}

public function markAsReplied(ContactMessage $message)
{
    $message->markAsReplied();
    return back()->with('message_success', 'تم تعليم الرسالة كتم الرد عليها');
}
public function dashboard()
{
    $tripRequests = TripRequest::with(['user', 'destination'])->latest()->get();
    $contactMessages = ContactMessage::latest()->get();
    
    return view('admin.dashboard', compact('tripRequests', 'contactMessages'));
}

    public function updateTripRequestStatus(Request $request, TripRequest $tripRequest)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $tripRequest->update(['status' => $request->status]);

        return back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    /**
     * Display users management.
     */
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.users', compact('users'));
    }

    /**
     * Toggle user admin status.
     */
    public function toggleUserAdmin(User $user)
    {
        $user->update(['is_admin' => !$user->is_admin]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث صلاحيات المستخدم بنجاح',
            'is_admin' => $user->is_admin
        ]);
    }

    /**
     * Display destinations management.
     */
    public function destinations()
    {
        $destinations = Destination::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.destinations', compact('destinations'));
    }

    /**
     * Store new destination.
     */
    public function storeDestination(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'currency' => 'required|string|max:255',
            'exchange_rate' => 'required|numeric|min:0',
            'min_daily_budget' => 'required|integer|min:0',
            'max_daily_budget' => 'required|integer|min:0',
            'image_url' => 'required|url',
            'badge_type' => 'nullable|string',
            'badge_text_ar' => 'nullable|string',
            'badge_text_en' => 'nullable|string',
            'is_popular' => 'boolean',
            'best_months' => 'nullable|array',
            'weather_types' => 'nullable|array',
            'trip_types' => 'nullable|array',
        ]);

        Destination::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة الوجهة بنجاح'
        ]);
    }

    /**
     * Update destination.
     */
    public function updateDestination(Request $request, Destination $destination)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'currency' => 'required|string|max:255',
            'exchange_rate' => 'required|numeric|min:0',
            'min_daily_budget' => 'required|integer|min:0',
            'max_daily_budget' => 'required|integer|min:0',
            'image_url' => 'required|url',
            'badge_type' => 'nullable|string',
            'badge_text_ar' => 'nullable|string',
            'badge_text_en' => 'nullable|string',
            'is_popular' => 'boolean',
            'best_months' => 'nullable|array',
            'weather_types' => 'nullable|array',
            'trip_types' => 'nullable|array',
        ]);

        $destination->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الوجهة بنجاح'
        ]);
    }

    /**
     * Delete destination.
     */
    public function destroyDestination(Destination $destination)
    {
        $destination->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الوجهة بنجاح'
        ]);
    }

    /**
     * Display contact messages.
     */
    public function contactMessages1()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.contact-messages', compact('messages'));
    }

    /**
     * Mark message as read.
     */
    public function markMessageAsRead(ContactMessage $message)
    {
        $message->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'تم تمييز الرسالة كمقروءة'
        ]);
    }

    /**
     * Mark message as replied.
     */
    public function markMessageAsReplied(ContactMessage $message)
    {
        $message->markAsReplied();

        return response()->json([
            'success' => true,
            'message' => 'تم تمييز الرسالة كتم الرد عليها'
        ]);
    }

    /**
     * Display recommendations.
     */
    public function recommendations()
    {
        $recommendations = Recommendation::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.recommendations', compact('recommendations'));
    }

    /**
     * Get dashboard statistics for AJAX requests.
     */
    public function getStats()
    {
        $stats = [
            'total_users' => User::count(),
            'total_destinations' => Destination::count(),
            'total_trip_requests' => TripRequest::count(),
            'pending_requests' => TripRequest::byStatus('pending')->count(),
            'processing_requests' => TripRequest::byStatus('processing')->count(),
            'completed_requests' => TripRequest::byStatus('completed')->count(),
            'unread_messages' => ContactMessage::unread()->count(),
            'recent_users' => User::where('created_at', '>=', now()->subDays(7))->count(),
            'recent_requests' => TripRequest::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        return response()->json($stats);
    }
}