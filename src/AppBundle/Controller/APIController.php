<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of APIController
 * 
 * @Route("/api")
 * @author George
 */
class APIController extends FOSRestController
{

    /**
     * @Rest\Get("/get_users", name="api_get_users")
     * 
     * @return View
     */
    public function getUsersAction() {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('AppBundle:Member')->findAll();
        $view = $this->view($data, 200)
                ->setFormat('json')
                ->setTemplate("AppBundle:Users:getUsers.html.twig")
                ->setTemplateVar('users')
        ;

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/get_user/{email}", name="api_get_user")
     * 
     * @return View
     */
    public function getUserAction($email) {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('AppBundle:Member')->findBy(['email' => $email]);
        if (!$data) {
            throw $this->createNotFoundException('Unable to find user entity');
        }
        $view = $this->view($data, 200)
                ->setTemplate("AppBundle:Users:getUsers.html.twig")
                ->setTemplateVar('user')
        ;

        return $this->handleView($view);
    }

    /**
     * Set member password
     * 
     * Member entity is found in controller rather than service for better
     * exception handling
     * 
     * @Rest\Post("/set_password", name="api_set_password")
     * 
     * @param Request $request
     * @return View
     */
    public function setMemberPassword(Request $request) {
        $email = $request->get('email');
        $em = $this->getDoctrine()->getManager();
        $member = $em->getRepository('AppBundle:Member')->findOneBy(['email' => $email]);
        if (!$member) {
            throw $this->createNotFoundException('Unable to find member entity');
        }
        $rest = $this->container->get('app.rest_data');
        $data = $rest->setMemberPassword($member, $email);
        
        $view = $this->view($data, 200)
                ->setTemplate("AppBundle:Users:getUsers.html.twig")
                ->setTemplateVar('user')
        ;

        return $this->handleView($view);
    }

    /**
     * Reset member password
     * 
     * Member entity is found in controller rather than service for better
     * exception handling
     * 
     * @Rest\Post("/reset_password", name="api_reset_password")
     * 
     * @param Request $request
     * @return View
     */
    public function resetMemberPassword(Request $request) {
        $email = $request->get('email');
        $hash = $request->get('hash');
        $em = $this->getDoctrine()->getManager();
        $member = $em->getRepository('AppBundle:Member')->findOneBy(['email' => $email]);
        if (!$member) {
            throw $this->createNotFoundException('Unable to find member entity');
        }
        $rest = $this->container->get('app.rest_data');
        $data = $rest->resetMemberPassword($member, $hash);
        
        $view = $this->view($data, 200)
                ->setTemplate("AppBundle:Users:getUsers.html.twig")
                ->setTemplateVar('user')
        ;

        return $this->handleView($view);
    }

}
