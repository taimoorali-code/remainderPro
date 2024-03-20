<?php

// app/Http/Controllers/FollowupController.php

namespace App\Http\Controllers;

use App\Models\Followup;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
// use Illuminate\Http\JsonResponse;
// use App\Models\Followup;
// use Illuminate\Http\Request;


class FollowupController extends Controller
{
    public function search(Request $request, $userId): JsonResponse
{
    $userFollowups = Followup::where('user_id', $userId)
        ->where('name', 'like', '%' . $request->name . '%')
        ->get();

    if ($userFollowups->isEmpty()) {
        return response()->json(['message' => 'Follow-ups not found for the specified user and name'], 404);
    }

    // Additional details
    $todayFollowups = $userFollowups->where('follow_date', today())->count();
    $pastFollowups = $userFollowups->where('follow_date', '<', now())->count();
    $tomorrowFollowups = $userFollowups->where('follow_date', Carbon::tomorrow())->count();

    return response()->json([
        'user_followups' => $userFollowups,
        'today_followups' => $todayFollowups,
        'past_followups' => $pastFollowups,
        'tomorrow_followups' => $tomorrowFollowups,
    ]);
}

    public function show($userId): JsonResponse
    {
        $userFollowups = Followup::where('user_id', $userId)->get(); // Add ->get() to execute the query
    
        if ($userFollowups->isEmpty()) {
            return response()->json(['message' => 'Follow-ups not found for the specified user'], 404);
        }
    
        // Additional details
        $todayFollowups = $userFollowups->where('follow_date', today())->count();
        $pastFollowups = $userFollowups->where('follow_date', '<', now())->count();
        $tomorrowFollowups = $userFollowups->where('follow_date', Carbon::tomorrow())->count();
    
        return response()->json([
            'user_followups' => $userFollowups,
            'today_followups' => $todayFollowups,
            'past_followups' => $pastFollowups,
            'tomorrow_followups' => $tomorrowFollowups,
        ]);
    }
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'user_id' => ['required'],
            'phone' => ['required', 'string'],
            'dial_code' => ['required', 'string'],
            'address' => ['required', 'string'],
            'note' => ['nullable', 'string'],
            'status' => ['required', 'string'],
            'follow_date' => ['required', 'date'],
            'country' => ['required', 'string'],
            'state' => ['required', 'string'],
            'city' => ['required', 'string'],
        ]);

        $followup = Followup::create($data);

        return response()->json([
            'message' => 'Follow-up created successfully',
            'followup' => $followup,
        ]);
    }
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $followup = Followup::findOrFail($id);
    
            $request->validate([
                'name' => 'string|max:255',
                'phone' => 'string|max:255',
                'address' => 'string|max:255',
                'note' => 'string',
                'dial_code' => 'string',
                'status' => 'string|max:255',
                'follow_date' => 'date',
                'country' => 'string|max:255',
                'state' => 'string|max:255',
                'city' => 'string|max:255',
            ]);
    
            $followup->update($request->all());
    
            return response()->json(['message' => 'Follow-up updated successfully', 'followup' => $followup]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Follow-up not found.'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the follow-up.'], 500);
        }
    }
    public function destroy($id): JsonResponse
    {
        $followup = Followup::findOrFail($id);
        $followup->delete();

        return response()->json(['message' => 'Follow-up deleted successfully']);
    }
    public function filterFollowups(Request $request, $userId): JsonResponse
    {
        $request->validate([
            'from_date' => ['required', 'date'],
            'to_date' => ['required', 'date', 'after_or_equal:from_date'],
            'country' => ['required', 'string'],
            'state' => ['required', 'string'],
            'city' => ['required', 'string'],
        ]);
    
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $country = $request->input('country');
        $state = $request->input('state');
        $city = $request->input('city');
    
        $filteredFollowups = Followup::where('user_id', $userId)
            ->whereBetween('follow_date', [$fromDate, $toDate])
            ->where('country', $country)
            ->where('state', $state)
            ->where('city', $city)
            ->get();
    
        if ($filteredFollowups->isEmpty()) {
            return response()->json(['message' => 'No follow-ups found for the specified user and criteria'], 404);
        }
    
        return response()->json(['filtered_followups' => $filteredFollowups]);
    }
    
    
    public function doneFollowups($userId): JsonResponse
    {
        $doneFollowups = Followup::where('user_id', $userId) 
        ->where('status', 'success')->get();

        return response()->json(['done_followups' => $doneFollowups]);
    }

    public function deletedFollowups($userId): JsonResponse
    {
        $doneFollowups = Followup::where('user_id', $userId) 
        ->where('status', 'pending')->get();

        return response()->json(['pending_followups' => $doneFollowups]);

    }


    // Add other CRUD methods like show, update, destroy as needed
}
