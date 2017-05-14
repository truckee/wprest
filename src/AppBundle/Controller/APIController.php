<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @Route("/set_password", name="api_set_password")
     * 
     * @param Request $request
     * @return View
     */
    public function setUserPassword(Request $request) {
        $email = $request->get('email');
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('AppBundle:Member')->findOneBy(['email' => $email]);
        if (!$data) {
            throw $this->createNotFoundException('Unable to find member entity');
        }
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr(str_shuffle($chars), 0, 8);
        $crypted = password_hash($password, PASSWORD_BCRYPT);
        $data->setPassword($crypted);
        $em->persist($data);
        $em->flush();
        $member = [
            'email' => $email,
            'password' => $password,
            'enabled' => $data->getEnabled()
        ];
        
        $view = $this->view($member, 200)
                ->setTemplate("AppBundle:Users:getUsers.html.twig")
                ->setTemplateVar('user')
        ;

        return $this->handleView($view);
    }

}
