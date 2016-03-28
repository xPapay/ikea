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
            $path = $this->getPath($file);

            if ($this->isImage($file))
            {
                $thumbnail_path = $this->getThumbnailPath($file);
                $this->saveImage($file, $path);
                $this->saveThumbnail($file, $thumbnail_path);
                $this->documentable->photos()->create(['path' => $path, 'thumbnail_path' => $thumbnail_path]);
            }
            else
            {
                $file->move($this->baseDir, $this->getName($file));
                $this->documentable->files()->create(['path' => $path, 'type' => $file->getExtension()]);
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

    private function getPath($file)
    {
        return sprintf("%s/%s", $this->baseDir, $this->getName($file));
    }

    private function getThumbnailPath($file)
    {
        return sprintf("%s/tn-%s", $this->baseDir, $this->getName($file));
    }
}