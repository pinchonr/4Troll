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
		public function indexAction(Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        $gags= $em->getRepository('AppBundle:Gag')->findAll();
        return $this->render('home/home.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'gags' => $gags
        ]);
    }


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

            return $this->redirectToRoute('app');
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }

	public function loginAction(Request $request)
	{
		$authUtils = $this->get('security.authentication_utils');
		// get the login error if there is one
		$error = $authUtils->getLastAuthenticationError ();
		
		// last username entered by the user
		$lastUsername = $authUtils->getLastUsername ();
		
		return $this->render ( 'security/login.html.twig', array (
				'last_username' => $lastUsername,
				'error' => $error 
		) );
	}

	public function editProfileAction(Request $request){
		//TODO display form with user values and make an update in DB on submit
	}

	public function newGagAction(Request $request){
		//TODO put code to load a new gag
        $em= $this->getDoctrine()->getManager();
        $gag = new Gag();
        
        $form = $this->createForm(GagType::class, $gag);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $gag->setUser($this->getUser());
            //we get the file (field is not explicit but only the FileName will be stored in DB)
            $file=$gag->getFileName();
            //creating unique file name
            $filename=md5(uniqid()).'.'.$file->guessExtension();
            //we change the file name
            $gag->setFileName($filename);
            //we move the file in the upload dir
            $file->move($gag->getAbsolutePath());
            
            $gag->setLastModified();

            $em->persist($gag);
            $em->flush();

            return $this->redirectToRoute('app');
        }

        return $this->render(
            'upload/uploadGag.html.twig',
            array('form' => $form->createView())
        );
	}
}
?>