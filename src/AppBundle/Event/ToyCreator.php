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
        $om = $args->getObjectManager();

        /**
         * @var $person People
         */
        $person = $args->getObject();

        if ($person instanceof People) {
            $toy = new Toy();
            $toy->setName(sprintf("%s_%s", $person->getName(), $person->getAge()));
            $toy->setCreatedAt(new \DateTime());
            $toy->setPerson($person);

            $om->persist($toy);
            $om->flush();
        }
    }

}