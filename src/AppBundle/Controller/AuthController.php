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
 * @Route("/")
 * @author George
 */
class AuthController extends FOSRestController
{

    /**
     * @Rest\Get("/{type}/get_user/{email}", 
     * requirements={"type":"api|basic|none"})
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
     * @Rest\Get("/{type}/get_users",
     * requirements={"type":"api|basic|none"})
     *
     * @return View
     */
    public function getUsersAction() {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('AppBundle:Member')->findAll();
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
     * @Rest\Post("/{type}/set_password", 
     * requirements={"type":"api|basic|none"})
     * 
     * @param Request $request
     * @return View
     */
    public function setMemberPassword(Request $request) {
        $email = $request->get('email');
        $hash = $request->get('hash');
        $em = $this->getDoctrine()->getManager();
        $member = $em->getRepository('AppBundle:Member')->findOneBy(['email' => $email]);
        if (!$member) {
            throw $this->createNotFoundException('Unable to find member entity');
        }
        $rest = $this->container->get('app.rest_data');
        $data = $rest->setMemberPassword($member, $hash);
        
        $view = $this->view($data, 200)
                ->setTemplate("AppBundle:Users:getUsers.html.twig")
                ->setTemplateVar('user')
        ;

        return $this->handleView($view);
    }

}
