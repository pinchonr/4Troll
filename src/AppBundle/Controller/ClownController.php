<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\GagType;
use AppBundle\Form\CommentType;
use AppBundle\Entity\Gag;
use AppBundle\Entity\Comment;

class ClownController extends Controller
{
    public function indexAction(Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        $gags= $em->getRepository('AppBundle:Gag')->findAllGagsByDate();
        return $this->render('home/home.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'gags' => $gags
        ]);
    }

    public function newGagAction(Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        $gag = new Gag();
        
        $form = $this->createForm(GagType::class, $gag);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $gag->setAuthor($this->getUser());
            //we get the file (field is not explicit but only the FileName will be stored in DB)
            $file=$gag->getFileName();
            //creating unique file name
            $filename=md5(uniqid()).'.'.$file->guessExtension();
            //we move the file in the upload dir
            $file->move($gag->getUploadRootDir(), $filename);
            //we change the file name
            $gag->setFileName($filename);
            $em->persist($gag);
            $em->flush();

            return $this->redirectToRoute('app');
        }

        return $this->render(
            'gag/uploadGag.html.twig',
            array('form' => $form->createView())
        );
    }

    public function gagDetailAction(Request $request, Gag $gag)
    {
        $em= $this->getDoctrine()->getManager();
        $comment= new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setAuthor($this->getUser());
            $comment->setGag($gag);
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('gagDetail', ['id' => $gag->getId()]);
        }

        return $this->render(
            'gag/detailGag.html.twig',
            array("form" => $form->createView(),
                  "gag" => $gag
            )
        );
    }

    public function addUpVoteForGag(Gag $gag)
    {
        $em= $this->getDoctrine()->getManager();
        $vote= new Vote();
        $vote->setUpVote(true);
        $vote->setUser($this->getUser());
        $vote->setGag($gag);
        $gag->addVote($vote);

        return $this->redirectToRoute('gagDetail', ['id' => $gag->getId()]);
    }
}
