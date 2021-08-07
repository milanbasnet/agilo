<?php

namespace App\Services;


use App\Models\Workout;
use App\Models\WorkoutTag;

class TagService
{
    /**
     * @param array $tags
     * @param Workout $workout
     */
    public function process($tags, $workout) {
        $currentTagIds = collect($workout->tags->map(function ($tag) {
            return $tag->id;
        }));

        $workoutTags = WorkoutTag::whereIn('title', $tags)->get();

        collect($tags)->filter(function ($value, $key) use ($workoutTags) {
            return !$workoutTags->contains('title', $value);
        })->each(function ($item, $key) use (&$workoutTags) {
            $tag = WorkoutTag::create(['title' => $item]);

            $workoutTags->add($tag);
        });

        $workoutTags->each(function ($tag, $key) use ($workout, &$currentTagIds) {
            $key = $currentTagIds->search($tag->id);

            if ($key !== false) {
                $currentTagIds->forget($key);
            } else {
                $workout->tags()->attach($tag->id);
            }
        });

        $currentTagIds->each(function ($id, $key) use ($workout) {
            $workout->tags()->detach($id);
        });
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection|\Agilo\WorkoutTag[] $tags
     *
     * @return string
     */
    public function asString($tags) {
        return $tags->implode('title', ',');
    }
}