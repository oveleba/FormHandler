<?php
namespace Veleba\FormHandlerBundle\Form\Handler;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class FormHandler implements FormHandlerInterface
{
    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @var FormTypeInterface
     */
    protected $formType;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(Request $request)
    {
        $form = $this->getForm();

        $this->preHandle($request);

        if (!$form->isSubmitted()) {
            $form->handleRequest($request);
        }
        
        $this->preValidate($request);
        
        return $form->isValid() ? $this->onValid($request) : $this->onInvalid($request);
    }

    /*
     * @return FormInterface
     *
     * @throws \BadMethodCallException
     */
    public function getForm()
    {
        if ($this->form === null && $this->formType !== null) {
            if ($this->formFactory === null) {
                throw new \BadMethodCallException("can't build a Form from FormType without FormFactory");
            }

            $this->form = $this->formFactory->create(
                get_class($this->formType
            ));
        }

        return $this->form;
    }

    public function setForm(FormInterface $form)
    {
        $this->form = $form;
    }

    public function getFormType()
    {
        return $this->formType;
    }

    public function setFormType(FormTypeInterface $formType)
    {
        $this->formType = $formType;
    }

    /**
     * @param FormFactoryInterface $formFactory
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    protected function preHandle(Request $request)
    {
    }

    protected function preValidate(Request $request)
    {
    }

    /**
     * @param Request $request
     * @return boolean
     */
    protected abstract function onValid(Request $request);

    /**
     * @param Request $request
     * @return boolean
     */
    protected function onInvalid(Request $request)
    {
        return false;
    }
}
