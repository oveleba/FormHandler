<?php
namespace Veleba\FormHandlerBundle\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

class PersistenceFormHandler extends FormHandler
{
    /**
     * @var ObjectManager
     */
    protected $manager;

    public function __construct(EventDispatcherInterface $eventDispatcher, ObjectManager $manager)
    {
        parent::__construct($eventDispatcher);
        $this->manager = $manager;
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function onValid(Request $request)
    {
        $entity = $this->getForm()->getData();

        $this->manager->persist($entity);
        $this->manager->flush();
        
        return true;
    }
}
