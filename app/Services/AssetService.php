<?php

namespace App\Services;


use App\Models\Video;
use Carbon\Carbon;
use File;
use Flavy;
use Folour\Flavy\Exceptions\FlavyException;
use Symfony\Component\HttpFoundation\File\File as FileAlias;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Storage;
use Log;
use Image;
use FFMpeg;

class AssetService
{
    const MAX_THUMB_WIDTH = 640;
    const MAX_IMAGE_WIDTH = 600;
    const MAX_IMAGE_HEIGHT = 300;

    /**
     * @param UploadedFile $file
     * @return FileAlias
     */
    public function move(UploadedFile $file)
    {
        $name = $this->generateHashedName($file);

        return $file->move(storage_path('/app/public/'), $name);
    }

    /**
     * @param UploadedFile $file
     * @param int $append
     * @return string
     */
    private function generateHashedName(UploadedFile $file, $append = 0)
    {
        $hashed = md5($file->getClientOriginalName().Carbon::now()->timestamp.$append);
        $name = $hashed.'.'.$file->getClientOriginalExtension();

        if (Storage::exists($name)) {
            return $this::generateHashedName($file, ++$append);
        }

        return $name;
    }

    /**
     * @param Video $video
     * @return string
     */
    public function thumb(Video $video)
    {
        try {
            $thumbnailName = $video->name . '_thumb.jpg';
            $thumbnailPath = storage_path('app/public/'.$thumbnailName);
            FFmpeg::open(('/public/'.$video->path))->getFrameFromSeconds(5)->export()->save('/public/'.$thumbnailName);
            if(file_exists($thumbnailPath)){
            Image::make($thumbnailPath)->widen(self::MAX_THUMB_WIDTH, function ($constraint) {
                $constraint->upsize();
            })->save($thumbnailPath, 50);
        }
            return $thumbnailName;
        } catch (FlavyException $e) {
            Log::error('failed to create thumbnail from videofile with path: '. $video->path . '. exception message: '. $e->getMessage());
        }

        return '';
    }

    /**
     * @param string $assetPath
     */
    public function delete($assetPath)
    {
        if (File::exists(storage_path('app/public/'.$assetPath))) {
            File::delete(storage_path('/app/public/'.$assetPath));
        }
    }

    public function deleteVideo(Video $video) {
        $this->delete($video->path);
        $this->delete($video->thumbnail_path);
    }

    /**
     * @param FileAlias $image
     */
    public function resizeImage(FileAlias $image)
    {
        Image::make($image)
            ->resize(self::MAX_IMAGE_WIDTH, self::MAX_IMAGE_HEIGHT, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save();
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function moveAndResizeImage(UploadedFile $file)
    {
        $movedFile = $this->move($file);
        $this->resizeImage($movedFile);
        return $movedFile->getFilename();
    }

    /**
     * @param Video $video
     * @param UploadedFile $file
     * @return Video
     */
    public function updateVideo(Video $video, UploadedFile $file) {
        $videoFile = $this->move($file);

        $video->name = pathinfo($videoFile->getFilename(), PATHINFO_FILENAME);
        $video->path = $videoFile->getFilename();
        $video->thumbnail_path = $this->thumb($video);

        return $video;
    }

    public function imageAsDataUrl($imagePath) {
        if ($imagePath && File::exists(storage_path('/app/public/'.$imagePath))) {
            return Image::make(storage_path('/app/public/'.$imagePath))->encode('data-url')->encoded;
        }

        return '';
    }
}