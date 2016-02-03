<?php

namespace s2\todoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use s2\todoBundle\Entity\Event;

class FrontController extends Controller {

    public function homeAction() {
        $repository = $this->getDoctrine()->getManager()->getRepository('s2todoBundle:Event');

        $oEvents = $repository->myfindAll(true);
        return $this->render('s2todoBundle:Front:home.html.twig', array(
                    "events" => $oEvents
        ));
    }

    public function ficheAction($id) {

        $repository = $this->getDoctrine()->getManager()->getRepository('s2todoBundle:Event');
        try {
            $oEvent = $repository->myfindOne($id, true);
        } catch (\Doctrine\Orm\NoResultException $e) {
            throw new NotFoundHttpException("Event not found");
        }
        return $this->render('s2todoBundle:Front:fiche.html.twig', array(
                    "event" => $oEvent
        ));
    }

}
