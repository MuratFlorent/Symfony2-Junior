<?php

namespace s2\todoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use s2\todoBundle\Entity\Event;
use s2\todoBundle\Form\EventType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BackController extends Controller {

    public function homeAction() {
        $repository = $this->getDoctrine()->getManager()->getRepository('s2todoBundle:Event');

        $oEvents = $repository->myfindAll();
        return $this->render('s2todoBundle:Back:home.html.twig', array(
                    "events" => $oEvents
        ));
    }

    public function ficheAction($id) {
        $repository = $this->getDoctrine()->getManager()->getRepository('s2todoBundle:Event');
        try {
            $oEvent = $repository->myfindOne($id);
        } catch (\Doctrine\Orm\NoResultException $e) {
            throw new NotFoundHttpException("Event not found");
        }
        return $this->render('s2todoBundle:Back:fiche.html.twig', array(
                    "event" => $oEvent
        ));
    }

    public function formAction($id = 0, Request $request) {
        $user = $this->getUser()->getRoles();
        if (!in_array("ROLE_SUPER_ADMIN", $user)) {
            throw new NotFoundHttpException("Page not found");
        }
        $file = null;
        if (!empty($id)) {
            $repository = $this->getDoctrine()->getManager()->getRepository('s2todoBundle:Event');
            try {
                $oEvent = $repository->myfindOne($id);
                $file = $oEvent->getDocument();
            } catch (\Doctrine\Orm\NoResultException $e) {
                throw new NotFoundHttpException("Event not found");
            }
        } else {
            $oEvent = new Event();
        }

        $form = $this->createForm(new EventType(), $oEvent);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            if ($oEvent->getDocument() != $file && empty($file)) {
                $oEvent->deleteFile();
            }

            $oEvent->upload();
            $em->persist($oEvent);
            $em->flush();


            return $this->redirect($this->generateUrl('home_back'));
        }

        return $this->render('s2todoBundle:Back:form.html.twig', array(
                    'form' => $form->createView(),
                    'event' => $oEvent
        ));
    }

    public function deleteAction($id) {
        $user = $this->getUser()->getRoles();
        if (!in_array("ROLE_SUPER_ADMIN", $user)) {
            throw new NotFoundHttpException("Page not found");
        }

        $repository = $this->getDoctrine()->getManager()->getRepository('s2todoBundle:Event');
        try {
            $oEvent = $repository->myfindOne($id);
            $oEvent->deleteFile();
        } catch (\Doctrine\Orm\NoResultException $e) {
            throw new NotFoundHttpException("Event not found");
        }

        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($oEvent);
        $em->flush();

        return $this->redirect($this->generateUrl('home_back'));
    }

}
