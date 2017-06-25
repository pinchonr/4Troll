<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\GagType;
use AppBundle\Form\CommentType;
use AppBundle\Entity\Gag;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Vote;

class ClownController extends Controller
{
    /**
    *
    * Get the home page and render all gags
    *
    */
    public function indexAction(Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        $gags= $em->getRepository('AppBundle:Gag')->findAllGagsByDate();
        return $this->render('home/home.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'gags' => $gags
        ]);
    }

    /**
    *
    * Create a new gag 
    *
    */
    public function newGagAction(Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        $gag = new Gag();
        
        $form = $this->createForm(GagType::class, $gag);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $gag->setAuthor($this->getUser());
            //we get the file (form field is not so explicit but only the FileName will be stored in DB)
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

    /**
    *
    * Get the gag, a form to add comments and action links to vote 
    *
    */
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
       //array containing number of upvotes and number of downvotes
       $votes= $this->calculateVotesForGag($gag);

        return $this->render(
            'gag/detailGag.html.twig',
            array("form" => $form->createView(),
                  "gag" => $gag,
                  "upvotes"=> $votes['upvotes'],
                  "downvotes" => $votes['downvotes']
            )
        );
    }

    /**
    *
    * Set the vote for user. If user select twice the same button, vote is cancelled.
    *
    */
    public function gagVoteAction(Gag $gag, string $voteType)
    {
        //verifying if user is connected and redirect him to login page if not
        if(!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('login');
        }

        $em= $this->getDoctrine()->getManager();
        //if user has already voted
        try{
            
            $oldVote=$em->getRepository('AppBundle:Vote')->getVoteForUserAndGag($this->getUser(),$gag);
            //change the value of the vote if different
            if($oldVote->getVote() != $voteType){
                $oldVote->setVote($voteType);
                $em->merge($oldVote);
                $em->flush();
            }
            //or remove the vote (double vote -> vote cancelled)
            else{
                $oldVote->setVote(null);
                $em->merge($oldVote);
                $em->flush();
            }

        }
        //if user has never voted
        catch(\Doctrine\ORM\NoResultException $e){
            $vote= new Vote();
            $vote->setVote($voteType);
            $vote->setUser($this->getUser());
            $vote->setGag($gag);
            $em->persist($vote);
            $gag->addVote($vote);
            $em->persist($gag);
            $em->flush();
            $votes= $gag->getVotes();
        }

       return $this->redirectToRoute('gagDetail', ['id' => $gag->getId()]);
    }

    /**
    *
    * Calculate the number of upvotes and downvotes and return an array with those values
    *
    */
    private function calculateVotesForGag(Gag $gag){
        $votes=$gag->getVotes();
        $upvotes=0;
        $downvotes=0;
        foreach($votes as $vote){
            if($vote->getVote() == "downvote"){
                $downvotes++;
            }
            else if ($vote->getVote() == "upvote"){
                $upvotes++;
            }
            //else the vote is null, don't count it
        }
        return array("upvotes" => $upvotes, "downvotes" => $downvotes);
    }
}
