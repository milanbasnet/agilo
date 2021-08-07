<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkoutRequest;
use App\Models\LevelTag;
use App\Services\AssetService;
use App\Services\TagService;
use App\Utils\SessionUtil;
use App\Utils\TranslationUtil;
use App\Models\RegionTag;
use App\Models\TypeTag;
use App\Models\PaceTag;
use App\Models\Equipment;
use App\Models\Video;
use App\Models\Workout;
use App\Models\WorkoutTranslation;
use Auth;
use DB;
use Flavy;
use Illuminate\Support\MessageBag;
use Log;
use Session;

class WorkoutsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $workouts = Workout::visible()
            ->withTranslation()
            ->get()
            ->sortByDesc('created_at');

        return view('workouts.index', compact('workouts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        return view('workouts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param WorkoutRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(WorkoutRequest $request, AssetService $assetService, TagService $tagService)
    {
        $workout = new Workout($request->input());

        $workout->equipment_needed = $request->has('equipment_id');

        //connect used equipment
        if($request->has('equipment_id')){
            $equipment = Equipment::findOrFail($request->input('equipment_id'));
            $workout->equipment()->associate($equipment);
        }

        $workout->image_path = $assetService->moveAndResizeImage($request->file('image'));

        $video = $assetService->updateVideo(new Video, $request->file('video'));

        $workout->office()->associate(Auth::user()->office);


        $paceTag = PaceTag::findOrFail($request->input('pace_tag_id'));
        $workout->paceTag()->associate($paceTag);

        $levelTag = LevelTag::findOrFail($request->input('level_tag_id'));
        $workout->levelTag()->associate($levelTag);

        try {
            DB::transaction(function() use ($request, $workout, $video) {
                $video->save();
                $workout->video()->associate($video);
                $workout->save();

                if ($request->exists('regions')) {
                    $workout->regionTags()->sync($request->input('regions'));
                }

                if ($request->exists('types')) {
                    $workout->typeTags()->sync($request->input('types'));
                }

                TranslationUtil::create($request, $workout, WorkoutTranslation::class);
            });
        } catch (\Exception $e) {
            Log::error($e->__toString());
            $errors = new MessageBag();
            $errors->add('Unerwarteter Fehler', 'Es ist ein unerwateter Fehler aufgetreten.');
            return redirect()->action('App\Http\Controllers\WorkoutsController@index')->withErrors($errors);
        }

        return redirect()->action('App\Http\Controllers\WorkoutsController@show', [$workout->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $workout = Workout::visible()
            ->withTranslation()
            ->with('video')
            ->findOrFail($id);

        $translation = $workout->translations->first();

        return view('workouts.show', compact('workout', 'translation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id, TagService $tagService)
    {
        $workout = Workout::with('translations')
            ->editable()
            ->findOrFail($id);

        //TODO move to Service

        $relatedRegionTagIds = $workout->regionTags()->get()->map(function($item,$key){ return $item->id; });
        $relatedTypeTagIds = $workout->typeTags()->get()->map(function($item,$key){ return $item->id; });


        $tagsAsString = $tagService->asString($workout->tags);
        $this->flash($workout);

        return view('workouts.edit', compact('workout','tagsAsString', 'relatedRegionTagIds', 'relatedTypeTagIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int            $id
     * @param WorkoutRequest $request
     *
     * @return Response
     */
    public function update($id, WorkoutRequest $request, AssetService $assetService, TagService $tagService)
    {
        $workout = Workout::editable()->findOrFail($id);

        $workout->fill($request->input());
        $workout->equipment_needed = $request->has('equipment_id');

        //connect used equipment
        if($request->has('equipment_id')){
            $equipment = Equipment::findOrFail($request->input('equipment_id'));
            $workout->equipment()->associate($equipment);
            $workout->equipment_needed = true;
        }

        if ($request->hasFile('image')) {
            $oldImagePath = $workout->image_path;

            $workout->image_path = $assetService->moveAndResizeImage($request->file('image'));

            $assetService->delete($oldImagePath);
        }

        if ($request->hasFile('video')) {
            $video = $workout->video;

            $assetService->deleteVideo($video);

            $video = $assetService->updateVideo($video, $request->file('video'));
            $video->save();
        }

        $paceTag = PaceTag::findOrFail($request->input('pace_tag_id'));
        $workout->paceTag()->associate($paceTag);

        $levelTag = LevelTag::findOrFail($request->input('level_tag_id'));
        $workout->levelTag()->associate($levelTag);

        try {
            DB::transaction(function() use ($request, $workout) {
                $workout->save();

                if ($request->exists('regions')) {
                    $workout->regionTags()->sync($request->input('regions'));
                }

                if ($request->exists('types')) {
                    $workout->typeTags()->sync($request->input('types'));
                }

                TranslationUtil::update($request, $workout, WorkoutTranslation::class);
            });
        } catch (\Exception $e) {
            Log::error($e->__toString());
            $errors = new MessageBag();
            $errors->add('Unerwarteter Fehler', 'Es ist ein unerwateter Fehler aufgetreten.');
            return redirect()->action('App\Http\Controllers\WorkoutsController@index')->withErrors($errors);
        }

        return redirect()->action('App\Http\Controllers\WorkoutsController@show', [$workout->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        Workout::editable()->findOrFail($id)->delete();

        return redirect()->action('App\Http\Controllers\WorkoutsController@index');
    }

    /**
     * Flashes the given workout to the session.
     *
     * @param Workout $workout
     */
    private function flash(Workout $workout)
    {
        $flash = [
            'type' => old('type', $workout->type),
            'equipment_needed' => SessionUtil::checked('equipment_needed', $workout->equipment_needed),
            'sets_default' => old('sets_default', $workout->sets_default),
            'rest_default' => old('rest_default', $workout->rest_default),
            'weight_default' => old('weight_default', $workout->weight_default),
            'repetitions_default' => old('repetitions_default', $workout->repetitions_default),
            'holding_period_default' => old('holding_period_default', $workout->holding_period_default),
            'equipment_id' => old('equipment_id', $workout->equipment_id),
            'pace_tag_id' => old('pace_tag_id', $workout->pace_tag_id),
            'level_tag_id' => old('level_tag_id', $workout->level_tag_id),
            'image_path' => old('image_path', $workout->image_path),
            'video_path' => old('video_path', $workout->video ? $workout->video->path : ''),
            'regions' => old('regions', $workout->regionIds()),
            'types' => old('types', $workout->typeIds()),
        ];

        $translations = $workout->translations;

        TranslationUtil::mergeFlash($translations, $flash);

        Session::flashInput($flash);
    }
}
