<?php
namespace AppBundle\Controller;

use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserController extends Controller
{
    public function registerAction(Request $request /*,UserPasswordEncoderInterface $passwordEncode, EntityManagerInterface $em*/)
    {
        $user = new User();
        $user->setRoles("ROLE_USER");
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //$password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            //$user->setPassword($password);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }

    public function loginAction(){
        return $this->render(
            'login/login.html.twig',
            array()
        );
    }
}
?>