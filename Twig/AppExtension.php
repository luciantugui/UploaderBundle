<?php

namespace Gus\UploaderBundle\Twig;

/**
 * Class AppExtension
 * @package Gus\UploaderBundle\Twig
 */
class AppExtension extends \Twig_Extension
{
    /**
     * @var
     */
    private $uploaderPath;

    /**
     * @param $uploaderPath
     */
    public function __construct($uploaderPath)
    {
        $this->uploaderPath = $uploaderPath;
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function getGlobals()
    {
        return array(
            'uploads_dir' => $this->uploaderPath
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'app_extension';
    }
}