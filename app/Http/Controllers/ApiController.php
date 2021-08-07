<?php

namespace App\Http\Controllers;

use App\Models\ParameterizedWorkout;
use App\Services\AssetService;
use App\Models\Video;
use App\Models\WorkoutUserEvent;
use App\Models\GlobalUserEvent;
use App\Models\WorkoutRoutineEvent;
use App\Models\Athlete;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use Illuminate\Database\QueryException;
use Log;
use validator;
use Illuminate\Support\Str;
use App\Services\Mailer;
use Illuminate\Support\Facades\Hash;
use App\Models\AssignedRoutine;

/**
 * TODO: phpdoc
 * Class ApiController
 * @package Agilo\Http\Controllers
 */
class ApiController extends Controller
{
    private $auth;

    private $response;

    public function __construct(Auth $auth, Response $response)
    {
        $this->auth = $auth;
        $this->response = $response;
    }

    public function user()
    {

        $user = $this->auth->guard('jwt')->user();

        if (!$user) {
            return $this->response->json(['user_not_found'], 404);
        }

        // eager load office
        $user->load('office');
        
        return $user;
    }

    public function tenantLogo() {
         $user = $this->user();

        if ($user instanceof JsonResponse) {
            return $user;
        }

        return response()->download(storage_path('/app/public/'.$user->office->logo_path), $user->office->logo_path);
    }

    public function routines(AssetService $assetService)
    {
        /*
         * move block to service and inject user? -> user check not needed because of jwt.auth middleware?
         */
        $user = $this->auth->guard('jwt')->user();

        if (!$user) {
            return $this->response->json(['user_not_found'], 404);
        }

        // TODO: use $visible or $hide to modify the result. see https://laravel.com/docs/5.3/eloquent-serialization#serializing-models-and-collections
        // TODO: has no relations, should be $user->routines()->with('translations', 'parameterizedWorkouts')->get()...
        // a dto should be the better solution

        $assignedRoutines = $user->assignedRoutines()->get();

        $workoutRoutinesArray = array();

        foreach($assignedRoutines as $assignedRoutine){
            if($assignedRoutine->isActive()) {
                array_push($workoutRoutinesArray, $this->workoutRoutineAsJson($assignedRoutine, $user, $assetService));
            }
        }

        //Getting routines which are assigned to this user via its assigned groups
        //TODO: the same pattern is used in AthleteController. So maybe a candidate to outsource it
        $groupIds = collect($user->groups->map(function($group) {
            return $group->id;
        }));

        $assignedRoutinesByGroup = AssignedRoutine::whereIn('group_id',$groupIds)->with('routine.translations')->get();

        foreach($assignedRoutinesByGroup as $assignedRoutine){
            if($assignedRoutine->isActive()) {
                array_push($workoutRoutinesArray, $this->workoutRoutineAsJson($assignedRoutine, $user, $assetService));
            }
        }
        return $this->response->json($workoutRoutinesArray);
    }

    private function workoutRoutineAsJson($assignedRoutine,$athlete, AssetService $assetService)
    {
        $routineAsArray = array();

        $routine = $assignedRoutine->routine;

        $parameterizedWorkouts = $routine->parameterizedWorkouts()->get();

        foreach ($parameterizedWorkouts as $paramWorkout) {

            $workout = $paramWorkout->workout()->first();

            $workoutUserEvents = $paramWorkout->workoutUserEvents()->where('athlete_id', $athlete->id)->get()->filter(function($event,$key){
                return $this->isMoreRecentThan(Carbon::parse($event->created_at), 7);
            })->sortByDesc('client_time')->values();

            if ($workout != null) {
                $workoutTranslation = $workout->translations()->first();

                $paramWorkoutInfoArray = array(
                    'id' => $workout->id,
                    'param_workout_id' => $paramWorkout->id,
                    'title' => $workoutTranslation->title_in_app,
                    'execution' => $workoutTranslation->execution,
                    'starting_position' => $workoutTranslation->starting_position,
                    'hints' => $workoutTranslation->hints,
                    'image' => $assetService->imageAsDataUrl($workout->image_path),
                    'videoThumbnail' => $workout->video ? $assetService->imageAsDataUrl($workout->video->thumbnail_path) : '',
                    'videoId' => $workout->video ? $workout->video->name : '',
                    'equipment_needed' => $workout->equipment_needed,
                    'material' => $workout->material,
                    'type' => $workout->type,
                    'sets' => $paramWorkout->sets,
                    'rest' => $paramWorkout->rest,
                    'repetitions' => $paramWorkout->repetitions,
                    'holding_period' => $paramWorkout->holding_period,
                    'weight' => $paramWorkout->weight,
                    'level' => $workout->levelTag->name,
                    'regions' => $workout->regionTags->toArray(),
                    'categories' => $workout->typeTags->toArray(),
                    'difficulty' => $workoutTranslation->difficulty,
                    'pace' => $workout->paceTag->name,
                    'userEvents' =>  $workoutUserEvents->toArray()
                );
                array_push($routineAsArray, $paramWorkoutInfoArray);
            }

        }


        $routineTranslation = $routine->translations()->first();
        $rArray = array(
            'id' => $assignedRoutine->id,
            'title' => $routineTranslation->title,
            'description' => $routineTranslation->description,
            'age' => $routine->ageTag->name,
            'gender' => $routine->genderTag->name,
            'level' => $routine->levelTag->name,
            'measure' => $routine->measureTag->name,
            'regions' => $routine->regionTags->toArray(),
            'objective' => $routine->objectiveTag->name,
            'pubmed' => $routine->pubmed_link,
            'duration' => $assignedRoutine->duration,
            'frequence' => $assignedRoutine->frequence,
            'startDate' => $assignedRoutine->getFormattedStartDate(),
            'events' => $assignedRoutine->events()->get()->filter(function($event,$key){
                return $this->isMoreRecentThan(Carbon::parse($event->created_at), 7);
            })->sortByDesc('client_time')->values()->toArray(),
            'workouts' => $routineAsArray
        );

        return $rArray;

    }

    public function workoutUserEvents(){
        $athlete = $this->getCurrentUser();

       $this->response->json($athlete);

        $workoutUserEvents = $athlete->workoutUserEvents()->get()->filter(function($event,$key){
            return $this->isMoreRecentThan(Carbon::parse($event->created_at), 7);
        });

        return $this->response->json($workoutUserEvents);
    }

    public function setWorkoutUserEvent(Request $request){

        $overallSuccess = true;
        $resultArray = array();

        $eventArray = $request['events'];
        $athlete = $this->user();

        foreach($eventArray as $eventData) {

            $success = true;
            $message = "";
            try {

                if($eventData['eventClass'] == "workout") {


                    $paramWorkout = ParameterizedWorkout::find($eventData['paramWorkoutId']);

                    if ($paramWorkout != null) {

                        $newEvent = new WorkoutUserEvent();
                        $newEvent->event_type = $eventData['type'];
                        $newEvent->client_time = $eventData['timestamp'];
                        $newEvent->athlete()->associate($athlete);
                        $newEvent->paramWorkout()->associate($paramWorkout);

                        $newEvent->save();
                    } else {
                        $success = false;
                        $message = "Mentioned ParameterizedWorkout not found: ". $eventData['paramWorkoutId'];
                    }


                }else if($eventData['eventClass'] == "routine"){
                    $assignedRoutine = AssignedRoutine::find($eventData['routineId']);

                    if($assignedRoutine != null){

                        $newEvent = new WorkoutRoutineEvent();
                        $newEvent->event_type = $eventData['type'];
                        $newEvent->client_time = $eventData['timestamp'];
                        $newEvent->athlete()->associate($athlete);
                        $newEvent->assignedRoutine()->associate($assignedRoutine);

                        $newEvent->save();
                    }else {
                        $success = false;
                        $message = "Mentioned Routine not found: ". $eventData['routineId'];
                    }
                }else if($eventData['eventClass'] == "global"){
                    $newGlobalEvent = new GlobalUserEvent();
                    $newGlobalEvent->event_type = $eventData['type'];
                    $newGlobalEvent->client_time = $eventData['timestamp'];
                    $newGlobalEvent->data = $eventData['data'];
                    $newGlobalEvent->athlete()->associate($athlete);

                    $newGlobalEvent->save();

                }

            } catch (QueryException $e) {

                $success = false;
                $message = $e->getMessage();
            }
            $overallSuccess = $overallSuccess && $success;
            array_push($resultArray,array("guid"=>$eventData['guid'],"success"=>$success, "message" => $message));

        }

        $this->response->json(array('success'=>$overallSuccess, "results"=>$resultArray));

    }

    public function statistics() {

        $user = $this->user();



        $userEvents = $user->userEvents();
        $usedDates = collect([]);

        //TODO: move this to a statistics service
        $fitnessLevelEvents = $userEvents->where('event_type',1)->get()->filter(function($value,$key) use ($usedDates){
            $mil = $value->client_time;
            $seconds = $mil / 1000;
            $date = date("d-m-Y", $seconds);

            if($usedDates->contains($date)){
                return false;
            }else{
                $usedDates->push($date);
                return true;
            }

        })->sortBy('client_time');


        //calculate completion ratio
        $routineCompletion = array();
        $overallCompletionRatio = 0;
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $activeAssignedRoutines = $this->getAllActiveAssignedRoutines($user);

        $activeRoutineCount = $activeAssignedRoutines->count();
        $weightOfEachRoutine = 0;

        if($activeRoutineCount != 0){
            $weightOfEachRoutine = 1.0 / $activeRoutineCount;
        }

        foreach($activeAssignedRoutines as $assignedRoutine){

                log::debug("[API Statistics] ==> Handling Assigned Routine");
                $routineCompletionRatio = 0;

                //times a routine and its workouts should be done
                $routineFrequence = $assignedRoutine->frequence;

                //get complete events for all workouts related to this routine
                $assignedWorkouts = $assignedRoutine->routine()->first()->parameterizedWorkouts()->get();
                $assignedWorkoutsCount = $assignedWorkouts->count();

                $workoutWeight = 1 / $assignedWorkoutsCount;

                foreach($assignedWorkouts as $paramWorkout){

                    log::debug("[API Statistics] ==> Handling Active Assigned Workout");
                    $closeEventCount = $paramWorkout->workoutUserEvents()->get()->filter(function($value,$key) use($startOfWeek,$endOfWeek, $user){

                        if($value->athlete_id == $user->id && $value->event_type > 0) {
                            $mil = $value->client_time;
                            $seconds = $mil / 1000;
                            $date = Carbon::createFromTimestamp($seconds);

                            //return Carbon::parse($date)->between($startOfWeek, $endOfWeek);
                            if($date->between($startOfWeek, $endOfWeek)){
                                log::debug("[API Statistics] ==> Accept CloseEvent since ".$date." is between ".$startOfWeek. " and " .$endOfWeek);
                                return true;
                            }else{
                                log::debug("[API Statistics] ==> Ignore CloseEvent since ".$date." is not between ".$startOfWeek. " and " .$endOfWeek);
                                return false;
                            }
                        }

                        log::debug("[API Statistics] ==> Skip event since it is not a CloseEvent or it is not owned by current user - Status:" .$value->event_type);
                        return false;

                    })->count();
                    log::debug("[API Statistics] ==> CloseEvent Count: ".$closeEventCount);

                    //get workout reopenings
                    $workoutResets = $paramWorkout->workoutUserEvents()->get()->filter(function($value,$key) use($startOfWeek,$endOfWeek,$user){

                        if($value->athlete_id == $user->id &&$value->event_type == 0) {
                            $mil = $value->client_time;
                            $seconds = $mil / 1000;
                            $date = Carbon::createFromTimestamp($seconds);

                            //return Carbon::parse($date)->between($startOfWeek, $endOfWeek);
                            if($date->between($startOfWeek, $endOfWeek)){
                                log::debug("[API Statistics] ==> Accept ReopenEvent since ".$date." is between ".$startOfWeek. " and " .$endOfWeek);
                                return true;
                            }else{
                                log::debug("[API Statistics] ==> Ignore ReopenEvent since ".$date." is not between ".$startOfWeek. " and " .$endOfWeek);
                                return false;
                            }
                        }
                        log::debug("[API Statistics] ==> Skip event since it is not a reopen event or it is not owned by current user - Status:" .$value->event_type);
                        return false;

                    })->count();
                    log::debug("[API Statistics] ==> Workout Reopen Event Count: ".$workoutResets);

                    //TODO: this event count can be calculated once per routine
                    //get workoutroutine reopenings
                    $workoutRoutineResets = $assignedRoutine->events()->get()->filter(function($value,$key) use($startOfWeek,$endOfWeek,$user){

                        if($value->athlete_id == $user->id && $value->event_type == 0) {
                            $mil = $value->client_time;
                            $seconds = $mil / 1000;
                            $date = Carbon::createFromTimestamp($seconds);

                            //return Carbon::parse($date)->between($startOfWeek, $endOfWeek);
                            if($date->between($startOfWeek, $endOfWeek)){
                                log::debug("[API Statistics] ==> Accept RoutineReopenEvent since ".$date." is between ".$startOfWeek. " and " .$endOfWeek);
                                return true;
                            }else{
                                log::debug("[API Statistics] ==> Ignore RoutineReopenEvent since ".$date." is not between ".$startOfWeek. " and " .$endOfWeek);
                                return false;
                            }
                        }
                        log::debug("[API Statistics] ==> Skip event since it is not a reopen event or it is not owned by current user - Status:" .$value->event_type);
                        return false;

                    })->count();
                    log::debug("[API Statistics] ==> Routine Reopen Event Count: ".$workoutRoutineResets);

                    //user initiated resets is the difference between workoutroutine events and workout reopen events
                    $userInitiatedResets = $workoutResets - $workoutRoutineResets;
                    if($userInitiatedResets < 0){
                        $userInitiatedResets = 0;
                    }
                    log::debug("[API Statistics] ==> Calculated UserInitiated ResetEvent Count: ".$userInitiatedResets);
                    $effectiveCloseEventCount = $closeEventCount - $userInitiatedResets;
                    if($effectiveCloseEventCount < 0){
                        $effectiveCloseEventCount = 0;
                    }

                    $completionRatioWorkout = $effectiveCloseEventCount / $routineFrequence;
                    $routineCompletionRatio = $routineCompletionRatio + ($workoutWeight * $completionRatioWorkout);
                }
                $routineCompletion[$assignedRoutine->id] = $routineCompletionRatio;
                $overallCompletionRatio = $overallCompletionRatio + ($weightOfEachRoutine * $routineCompletionRatio);
        }

        $completionData = array("overall" => $overallCompletionRatio, "routines" => $routineCompletion);

        $statisticsData = array("fitnessLevels" => $fitnessLevelEvents->values(), "completionRatio" => $completionData);

        return $this->response->json($statisticsData);
    }

    private function getAllActiveAssignedRoutines($user){
        $assignedRoutines = $user->assignedRoutines()->get();

        $groupIds = collect($user->groups->map(function($group) {
            return $group->id;
        }));

        $assignedRoutinesByGroup = AssignedRoutine::whereIn('group_id',$groupIds)->with('routine.translations')->get();

        $assignedRoutines = $assignedRoutines->merge($assignedRoutinesByGroup);

        return $assignedRoutines->filter(function($routine, $key){
            return $routine->isActive();
        });
    }

    public function video($name) {
        $video = Video::whereName($name)->firstOrFail();

        return response()->file(storage_path('app/public/'.$video->path));
    }

    private function isMoreRecentThan($date, $ageInDays){
        return $date->addDays($ageInDays)->gt(Carbon::today());
    }



    // forgot password



    public function forgotPassword(Request $request,Mailer $mailer)
    {
        // validation
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:athletes',
          ]);
          

       if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
       }

      try{

            $athlete = Athlete::where('email',$request->email)->first();
          
            $recoveryCode = Str::random(6);
        
            $mailer->send('athlete-password-recovery',
            ['code' => $recoveryCode,'email'=>$athlete->email],
            function ($message) use ($athlete) {
                $message->to($athlete->email)->subject(trans('subjects.password-reset-code'));
            }
            );

            $athlete -> recovery_code = $recoveryCode;
           
             $athlete->update();

             return response()->json(
                 [
                'message' => trans('messages.athletes-password-reset'),
                'email'=>$athlete->email,
                 ]
                 , 200);
    }
    
    catch(Exception $e)
        {
        return response()->json($e->getMessage(), 500);

        }
    }


    public function submitRecoveryCode(Request $request)
    {
        // validation

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:athletes',
            'code' => 'required',
            'password'=>'required|confirmed|min:6',

          ]);
     
        if ($validator->fails()) {
         return response()->json($validator->errors(), 400);
      }

      try{
      
      $athlete = Athlete::where('email',$request->email)->first();
     
      if($athlete->recovery_code != $request->code)
      {
        return response()->json(trans('messages.please-enter-valid-reset-code'), 400);

      }
      
      $athlete->password = Hash::make($request->password);
      $athlete->recovery_code = null;

      $athlete->update();

      return response()->json(trans('messages.password-reset-success'), 200);
    }
    catch(Exception $e)
    {
        return response()->json($e->getMessage(), 500);


    }

    }
}