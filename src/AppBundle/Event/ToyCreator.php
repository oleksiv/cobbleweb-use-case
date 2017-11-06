<?php

namespace AppBundle\Event;

use AppBundle\Entity\Toy;
use AppBundle\Entity\People;
use Doctrine\ORM\Event\LifecycleEventArgs;

class ToyCreator {

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {

        $entity = $args->getObject();

        if ($entity instanceof People) {

            $om = $args->getObjectManager();

            $toy = new Toy();
            $toy->setName(sprintf("%s_%s", $entity->getName(), $entity->getAge()));
            $toy->setCreatedAt(new \DateTime());
            $toy->setPerson($entity);

            $om->persist($toy);
            $om->flush();

        }
    }

}