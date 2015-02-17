<?php

namespace Gus\UploaderBundle\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Gus\UploaderBundle\Entity\BaseMedia;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class UploaderListener
 * @package Gus\UploaderBundle\EventListener
 */
class UploaderListener
{
    /**
     * @var
     */
    private $imageVersions;

    /**
     * @param $uploadPath
     * @param $imageVersions
     */
    public function __construct($uploadPath, $imageVersions)
    {
        $this->uploadPath = $uploadPath;
        $this->imageVersions = $imageVersions;
    }

    /**
     * @param BaseMedia $media
     * @param LifecycleEventArgs $event
     */
    public function postPersistHandler(BaseMedia $media, LifecycleEventArgs $event)
    {
        if ($media->getFiles()->isEmpty()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the media from being persisted to the database on error
        foreach ($media->getFiles() as $path => &$file) {
            /* @var $file UploadedFile */
            $file->move(sprintf('%s/%s', $this->uploadPath, $path), $media->getPath());
//            $file = null;
        }
    }

    /**
     * @param BaseMedia $media
     * @param LifecycleEventArgs $event
     */
    public function prePersistHandler(BaseMedia $media, LifecycleEventArgs $event)
    {
        $filename = sha1(uniqid(mt_rand(), true));
        $media->setPath($filename . '.' . $media->getFiles()->first()->guessExtension());
    }

    /**
     * @param BaseMedia $media
     * @param LifecycleEventArgs $event
     */
    public function postRemoveHandler(BaseMedia $media, LifecycleEventArgs $event)
    {
        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        if ($media->getPath()) {
            foreach (array_keys($this->imageVersions) as $imageVersion) {
                $imageVersionDir = $imageVersion == 'original' ? '' : $imageVersion . '/';
                $file = $this->uploadPath . $imageVersionDir . $media->getPath();
                @unlink($file);
            }
        }
    }
}