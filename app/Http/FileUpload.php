<?php
namespace App\Http;

use App\Documentable;
use Intervention\Image\Facades\Image;

class FileUpload
{
    private $files;
    private $baseDir;
    private $documentable;

    public function __construct($files, Documentable $documentable)
    {
        $this->baseDir = 'upload';
        $this->files = $files;
        $this->documentable = $documentable;
    }

    public function handleFilesUpload()
    {
        if ($this->files[0] == null)
            return;
        foreach ($this->files as $file)
        {
            $name = $this->getName($file);
            $path = $this->getPath($name);

            if ($this->isImage($file))
            {
                $thumbnail_path = $this->getThumbnailPath($name);
                $this->saveImage($file, $path);
                $this->saveThumbnail($file, $thumbnail_path);
                $this->documentable->photos()->create(['path' => $path, 'thumbnail_path' => $thumbnail_path, 'name' => $name]);
            }
            else
            {
                $this->documentable->files()->create(['path' => $path, 'name' => $name]);
                $file->move($this->baseDir, $this->getName($file));
            }
        }
    }

    private function saveImage($file, $path)
    {
        $image = Image::make($file->getPathName());
        $image->resize(1024, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image->save($path);
    }

    private function saveThumbnail($file, $thumbnail_path)
    {
        $thumbnail = Image::make($file->getPathName());
        $thumbnail->fit(200)->save($thumbnail_path);
    }

    private function isImage($file)
    {
        return substr($file->getMimeType(), 0, 5) == 'image';
    }

    private function getName($file)
    {
        return sprintf("%s-%s", time(), $file->getClientOriginalName());
    }

    private function getPath($name)
    {
        return sprintf("%s/%s", $this->baseDir, $name);
    }

    private function getThumbnailPath($name)
    {
        return sprintf("%s/tn-%s", $this->baseDir, $name);
    }
}