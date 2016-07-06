<?php
namespace Veleba\FormHandlerBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

interface FormHandlerInterface
{
    /**
     * @param Request $request
     * @return bool
     */
    public function handle(Request $request);

    /**
     * Returns a form.
     *
     * @return FormInterface
     */
    public function getForm();

    /**
     * @param FormInterface $form
     */
    public function setForm(FormInterface $form);

    /**
     * @return FormTypeInterface
     */
    public function getFormType();

    /**
     * @param FormTypeInterface $formType
     */
    public function setFormType(FormTypeInterface $formType);
}
