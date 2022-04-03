<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Lead;
use App\Models\Assignment;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/addLead', function (Request $request) {
    $lead = Lead::create([
        'name' => $request->name,
        'surname' => $request->surname,
        'phone' => $request->phone,
        'email' => $request->email,
        'current_state' => 'Creato',
        'channel' => 'Form'
    ]);
    if ($lead) {
        $assignment = new Assignment;
        $assignment->lead_id = $lead->id;
        $last_assignment = Assignment::where('is_direct', false)->latest()->get()->first();

        if ((isset($last_assignment->id))) {
            foreach (User::all()->whereNotIn('agent_code', '00000000')->whereNotIn('agent_code', '99999999') as $user) {
                if ($user->assignable && ($user->id > $last_assignment->user_id)) {
                    $assignment->user_id = $user->id;
                    $assignment->is_direct = false;
                    $assignment->save();
                    return response()->json([
                        'message' => 'Lead added correctly with assignment'
                    ], 201);
                }
            }
            $user = User::all()->whereNotIn('agent_code', '00000000')->whereNotIn('agent_code', '99999999')->first();
            $assignment->user_id = $user->id;
            $assignment->is_direct = false;
            $assignment->save();
            return response()->json([
                'message' => 'Lead added correctly with assignment'
            ], 201);
        } else {
            $user = User::all()->whereNotIn('agent_code', '00000000')->whereNotIn('agent_code', '99999999')->first();
            $assignment->user_id = $user->id;
            $assignment->is_direct = false;
            $assignment->save();
            return response()->json([
                'message' => 'Lead added correctly with assignment'
            ], 201);
        }
        return response()->json([
            'message' => 'Lead added correctly'
        ], 201);
    } else {
        return response()->json([
            'error' => 'Bad request'
        ], 400);
    }
});
