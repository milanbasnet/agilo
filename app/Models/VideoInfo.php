<?php

namespace App\Models;



use FFMpeg;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class VideoInfo
{
    private $codec;

    private $width;

    private $height;

    private $length;

    

    private function __construct($codec, $width, $height, $length) {
        $this->codec = $codec;
        $this->width = $width;
        $this->height = $height;
        $this->length = $length;
    }

    public static function toVideoInfo(UploadedFile $video) {
        $ffprobe = FFMpeg\FFProbe::create();
        $video = $ffprobe->streams($video)->videos()->first();
        
        $videoInfo['codec_name']= $video->get('codec_name');
        $videoInfo['width']=$video->get('width');
        $videoInfo['height'] = $video->get('height');
        $duration=$video->get('duration');
        // $dt = new \DateTime("1970-01-01" . $video->get('duration'), new \DateTimeZone('UTC'));
        $duration =$video->get('duration');
        // dd($duration);
        return new VideoInfo($videoInfo['codec_name'], $videoInfo['width'], $videoInfo['height'], $duration);
    }

    /**
     * @return mixed
     */
    public function codec()
    {
        return $this->codec;
    }

    /**
     * @return mixed
     */
    public function width()
    {
        return $this->width;
    }

    /**
     * @return mixed
     */
    public function height()
    {
        return $this->height;
    }

    /**
     * @return mixed
     */
    public function length()
    {
        return $this->length;
    }
}