<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Toy;
use AppBundle\Entity\People;
use AppBundle\Event\PeopleCreatedEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class LuckyController extends Controller

{
    /**
     * @return Response
     *
     * @Route("/testUC1/people/list/", name="people_dump")
     * @Method({"GET"})
     */
    public function listPeopleUC1Action()
    {
        $people = $this->getDoctrine()->getRepository(People::class)->findAll();

        return $this->render('AppBundle:Default:dump.html.twig', [
            'people' => $people
        ]);
    }

    /**
     * @return Response
     *
     * @Route("/testUC2/people/list/", name="people_index")
     * @Method({"GET"})
     */
    public function listPeopleUC2Action()
    {
        $people = $this->getDoctrine()->getRepository(People::class)->findAll();

        return $this->render('AppBundle:Default:index.html.twig', [
            'people' => $people
        ]);
    }

    /**
     * @param $request Request
     * @return Response
     *
     * @Route("/testUC3/people/create/", name="people_create")
     * @Method({"GET", "POST"})
     */
    public function createPeopleUC3Action(Request $request)
    {
        $person = new People();
        $form = $this->createForm('AppBundle\Form\PeopleType', $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();

            $this->addFlash('success', sprintf("Person \"%s\" has been added to your list.", $person->getName()));

            return $this->redirectToRoute('people_index');
        }

        return $this->render('AppBundle:Default:new.html.twig', array(
            'person' => $person,
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $person People
     * @return Response
     *
     * @Route("/testUC3/people/{id}", name="person_show", requirements={"id": "\d+"})
     * @Method({"GET"})
     */
    public function showAction(People $person)
    {
        return $this->render('AppBundle:Default:show.html.twig', [
            'person' => $person
        ]);
    }
}
