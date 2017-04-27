<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Description of APIController
 * 
 * @Route("/api")
 * @author George
 */
class APIController extends FOSRestController
{

    /**
     * @Route("/get_users", name="api_get_users")
     * 
     * @return View
     */
    public function getUsersAction() {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('AppBundle:User')->findAll();
        $view = $this->view($data, 200)
                ->setFormat('json')
                ->setTemplate("AppBundle:Users:getUsers.html.twig")
                ->setTemplateVar('users')
        ;

        return $this->handleView($view);
    }

    /**
     * @Route("/get_user/{email}", name="api_get_user")
     * 
     * @return View
     */
    public function getUserAction($email) {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('AppBundle:User')->findBy(['email' => $email]);
        
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
     * @Route("/get_hash/{username}", name="api_get_hash")
     * 
     * @return View
     */
    public function getUserHashAction($username) {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('AppBundle:User')->getApiUserHash($username);
        
        if (!$data) {
            throw $this->createNotFoundException('Unable to find user entity');
        }
        $view = $this->view($data, 200)
                ->setTemplate("AppBundle:Users:getUsers.html.twig")
                ->setTemplateVar('user')
        ;

        return $this->handleView($view);
    }

}
