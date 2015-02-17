<?php

namespace Gus\UploaderBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

/**
 * Class UploaderType
 * @package Gus\UploaderBundle\Form\Type
 */
class UploaderType extends AbstractType
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'gus_uploader';
    }
}