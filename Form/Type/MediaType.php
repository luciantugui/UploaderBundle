<?php

namespace Gus\UploaderBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Gus\UploaderBundle\Entity\BaseMedia;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class MediaType
 * @package Gus\UploaderBundle\Form\Type
 */
class MediaType extends AbstractType
{
    /**
     * @var
     */
    private $mediaClass;

    /**
     * @var string
     */
    private $uploadsDir;

    /**
     * @var array
     */
    private $imageVersions;

    /**
     * @param $class
     * @param $uploadsDir
     * @param $imageVersions
     */
    public function __construct($class, $uploadsDir, array $imageVersions)
    {
        $this->mediaClass = $class;
        $this->uploadsDir = $uploadsDir;
        $this->imageVersions = $imageVersions;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'hidden')
            ->add('mimeType', 'hidden')
            ->add('size', 'hidden');

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            /* @var $media BaseMedia */
            $media = $event->getData();

            if (!$media->getId()) {
                foreach (array_keys($this->imageVersions) as $imageVersion) {
                    $imageVersionDir = $imageVersion == 'original' ? '' : $imageVersion;
                    $media->addFile(
                        $imageVersionDir,
                        new UploadedFile(
                            sprintf('%s/%s/%s', $this->uploadsDir, $imageVersionDir, $media->getName()),
                            $media->getName(),
                            $media->getMimeType(),
                            null,
                            null,
                            true
                        )
                    );
                }
                $event->setData($media);
            }
        });
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->mediaClass
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gus_uploader_media';
    }
}