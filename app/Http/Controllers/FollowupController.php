<?php

// app/Http/Controllers/FollowupController.php

namespace App\Http\Controllers;

use App\Models\Followup;
// use App\Models\FollowupHistory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
// use Illuminate\Http\JsonResponse;
// use App\Models\Followup;
// use Illuminate\Http\Request;
use App\Models\FollowupHistory;
use Illuminate\Support\Facades\DB;


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


// use Carbon\Carbon;

public function show(Request $request, $userId): JsonResponse
{
    $userFollowups = Followup::where('user_id', $userId)
        ->where('status', 0)
        ->get();

    if ($userFollowups->isEmpty()) {
        return response()->json(['message' => 'Follow-ups not found for the specified user'], 404);
    }

    // Additional details
    $today = Carbon::today();
    $tomorrow = Carbon::tomorrow();

    $todayFollowups = Followup::where('user_id', $userId)
        ->whereDate('follow_date', $today)
        ->where('status', 0)
        ->orderBy('follow_date', 'asc')
        ->get();

    $tomorrowFollowups = Followup::where('user_id', $userId)
        ->whereDate('follow_date', $tomorrow)
        ->where('status', 0)
        ->orderBy('follow_date', 'asc')
        ->get();

    $pastFollowups = Followup::where('user_id', $userId)
        ->where('follow_date', '<', $today)
        ->where('status', 0)
        ->orderBy('follow_date', 'desc')
        ->get();

    return response()->json([
        'user_followups' => $userFollowups,
        'today_followups' => $todayFollowups,
        'past_followups' => $pastFollowups,
        'tomorrow_followups' => $tomorrowFollowups,
    ]);
}




    public function store(Request $request): JsonResponse
    {
        try {

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
            'switch' => ['required'],

        ]);
        // $followDate = Carbon::createFromFormat('Y-m-d', $data['follow_date'])->format('d-m-Y');
        // $data['follow_date'] = $followDate;

        $followup = Followup::create($data);

        return response()->json([
            'message' => 'Follow-up created successfully',
            'followup' => $followup,
        ]);
    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Follow-up not created.'], 404);
    }catch (ValidationException $e) {
        return response()->json(['error' => $e->getMessage()], 422);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred while updating the follow-up.'], 500);
    }
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
            'status' => 'integer',
            'follow_date' => 'date',
            'country' => 'string|max:255',
            'state' => 'string|max:255',
            'city' => 'string|max:255',
            'switch' => ['required'],
        ]);

        // Ensure 'status' field is cast to integer before updating
        $requestData = $request->all();
        $requestData['status'] = intval($requestData['status']);

        $followup->update($requestData);

        // Serialize changes array before storing in the database
        $changes = $followup->getChanges();
        $serializedChanges = serialize($changes);

        $history = new FollowupHistory([
            'followup_id' => $followup->id,
            'changes' => $serializedChanges,
        ]);
        $history->save();

        return response()->json(['message' => 'Follow-up updated successfully', 'followup' => $followup]);
    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Follow-up not found.'], 404);
    } catch (ValidationException $e) {
        return response()->json(['error' => $e->getMessage()], 422);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
 // Import DB facade for raw query

public function followupHistory(Request $request, $followupId): JsonResponse
{
    try {
        $followup = Followup::findOrFail($followupId);

        // Retrieve the follow-up history records associated with this follow-up
        $historyRecords = DB::table('followup_histories')
            ->where('followup_id', $followup->id)
            ->select('followup_id', 'changes', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        $formattedHistory = $historyRecords->map(function ($history) {
            $changesArray = unserialize($history->changes);
            $formattedChanges = [
                'followup_id' => $history->followup_id,
                'name' => $changesArray['name'] ?? null, // If 'name' key is not present, set to null
                'updated_at' => $changesArray['updated_at'] ?? null, // If 'updated_at' key is not present, set to null
            ];
            return $formattedChanges;
        });

        return response()->json(['followup_history' => $formattedHistory]);
    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Follow-up not found.'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred while fetching follow-up history.'], 500);
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
    $validator = Validator::make($request->all(), [
        'from_date' => ['date'],
        'to_date' => ['date', 'after_or_equal:from_date'],
        'country' => ['string'],
        'state' => ['string'],
        'city' => ['string'],
        'status' => ['required', 'string'], // Add validation for status
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    $query = Followup::where('user_id', $userId)
        ->where('status', $request->status); // Apply status condition here

    if ($request->filled('from_date') && $request->filled('to_date')) {
        $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date->addDay()); // Add one day to the end date
        $query->whereBetween('follow_date', [$request->from_date, $toDate]);
    }
   

    if ($request->filled('country')) {
        $query->where('country', $request->input('country'));
    }

    if ($request->filled('state')) {
        $query->where('state', $request->input('state'));
    }

    if ($request->filled('city')) {
        $query->where('city', $request->input('city'));
    }

    $filteredFollowups = $query->get();

    if ($filteredFollowups->isEmpty()) {
        return response()->json(['message' => 'No follow-ups found for the specified user and criteria'], 404);
    }

    return response()->json(['filtered_followups' => $filteredFollowups]);
}

    
    
    
    
    public function doneFollowups($userId): JsonResponse
    {
        $doneFollowups = Followup::where('user_id', $userId) 
        ->where('status', 1)->get();

        return response()->json(['done_followups' => $doneFollowups]);
    }

    public function deletedFollowups($userId): JsonResponse
    {
        $doneFollowups = Followup::where('user_id', $userId) 
        ->where('status', 2)->get();

        return response()->json(['pending_followups' => $doneFollowups]);

    }


    // Add other CRUD methods like show, update, destroy as needed
}
