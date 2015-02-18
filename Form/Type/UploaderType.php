<?php

namespace Gus\UploaderBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

/**
 * Class UploaderType
 * @package Gus\UploaderBundle\Form\Type
 */
class UploaderType extends AbstractType
{
    /**
     * @var
     */
    private $formName;

    /**
     * @param $formName
     */
    public function __construct($formName)
    {
        $this->formName = $formName;
    }

    /**
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['gus_uploader_form_name'] = sprintf('%s[%s]', $view->parent->vars['full_name'], $this->formName);
        $view->vars['gus_uploader_form_id'] = sprintf('%s_%s', $view->parent->vars['full_name'], $this->formName);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gus_uploader';
    }
}