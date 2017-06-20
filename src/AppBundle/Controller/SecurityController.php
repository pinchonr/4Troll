<?php

namespace AppBundle\Controller;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\UserType;
use AppBundle\Form\GagType;
use AppBundle\Entity\User;
use AppBundle\Entity\Gag;
use Symfony\Component\Validator\Constraints\DateTime;

class SecurityController extends Controller
{
    public function registerAction(Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        $passwordEncoder=$this->container->get("security.password_encoder");
        
        $user = new User();
        $user->setRoles(array('ROLE_USER'));
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render(
            'security/register.html.twig',
            array('form' => $form->createView())
        );
    }

    public function loginAction(Request $request)
    {
        $authUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();
        
        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();
        
        return $this->render('security/login.html.twig', array(
                'last_username' => $lastUsername,
                'error' => $error
        ));
    }

    public function editProfileAction(Request $request)
    {
        //TODO display form with user values and make an update in DB on submit
    }
}
