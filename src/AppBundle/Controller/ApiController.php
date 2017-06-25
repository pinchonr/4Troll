<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\GagType;
use AppBundle\Form\CommentType;
use AppBundle\Entity\Gag;
use AppBundle\Entity\Comment;

/**
*
* Class managin all request under the /api route. You must authenticate via http basic in order to be able to
* use the service
*/
class ApiController extends Controller
{
    /**
    *
    * Get all gags in database
    *
    */
    public function getGagsAction(Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        $gags= $em->getRepository('AppBundle:Gag')->findAllGagsByDate();
        
        if (empty($gags)) {
            return new JsonResponse(['message' => 'There is no gag at the moment'], Response::HTTP_NOT_FOUND);
        }

        foreach ($gags as $gag) {
            //set the comments for the gag
            $comments = $em->getRepository('AppBundle:Comment')->findCommentsByGag($gag->getId());
            $comments_json = [];
            foreach ($comments as $comment) {
                $comments_json[] = [
                    'id' => $comment->getId(),
                    'message' => $comment->getMessage(),
                    'published_at' => $comment->getPublishedAt(),
                    'author' => $comment->getAuthor(),
                ];
            }
            //set the gag
            $json[] = [
               'id' => $gag->getId(),
               'author' => $gag->getAuthor()->getUsername(),
               'title' => $gag->getTitle(),
               'last_modified' => $gag->getLastModified(),
               'image' => $gag->getWebPath(),
               'comments' => $comments_json,
            ];
        }

        return new JsonResponse($json);
    }

    /**
    *
    * Get a specific gag by it's id (given in url)
    *
    */
    public function getGagAction(Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        $gag= $em->getRepository('AppBundle:Gag')->findOneById($request->get('id'));

        if (empty($gag)) {
            return new JsonResponse(['message' => 'No gag found for the given id : '.$request->get('id')], Response::HTTP_NOT_FOUND);
        }

        $comments = $em->getRepository('AppBundle:Comment')->findCommentsByGag($gag->getId());
        foreach ($comments as $comment) {
            //set the comments for the gag
            $comments_json[] = [
                'id' => $comment->getId(),
                'message' => $comment->getMessage(),
                'published_at' => $comment->getPublishedAt(),
                'author' => $comment->getAuthor()->getUsername(),
            ];
        }

        $json = [
            //set the gag
            'id' => $gag->getId(),
            'author' => $gag->getAuthor()->getUsername(),
            'title' => $gag->getTitle(),
            'last_modified' => $gag->getLastModified(),
            'image' => $gag->getWebPath(),
            'comments' => $comments_json,
        ];

        return new JsonResponse($json);
    }

    /**
    *
    * Post a new gag
    *
    */
    public function newGagAction(Request $request)
    {
        $data = $request->getContent();
        $arrayData= json_decode($data, true);
        $gag= new Gag();
        $gag->setAuthor($this->getUser());
        $gag->setTitle($arrayData['title']);
        $gag->setFileName($arrayData['fileName']);
        $em=$this->getDoctrine()->getManager();
        $em->persist($gag);
        $em->flush();


        $json = [
            'status' => 201,
            'message' => "created"
        ];
        
        return new JsonResponse($json);
    }


    /**
    *
    * Get all comments for given gag
    *
    */
    public function getCommentsAction(Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        $gag= $em->getRepository('AppBundle:Gag')->findOneById($request->get('id'));

        if (empty($gag)) {
            return new JsonResponse(['message' => 'No gag found for the given id : '.$request->get('id')], Response::HTTP_NOT_FOUND);
        }

        $comments = $em->getRepository('AppBundle:Comment')->findCommentsByGag($gag->getId());
        $json = [];
        foreach ($comments as $comment) {
            $json[] = [
                'id' => $comment->getId(),
                'message' => $comment->getMessage(),
                'published_at' => $comment->getPublishedAt(),
                'author' => $comment->getAuthor()->getUsername(),
            ];
        }

        return new JsonResponse($json);
    }

    /**
    *
    * get a specific comment by getting the gag where the comment is and it's id
    *
    */
    public function getCommentAction(Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        $gag= $em->getRepository('AppBundle:Gag')->findOneById($request->get('id_gag'));

        if (empty($gag)) {
            return new JsonResponse(['message' => 'No gag found for the given id : '.$request->get('id_gag')], Response::HTTP_NOT_FOUND);
        }

        $comment = $em->getRepository('AppBundle:Comment')->fingCommentByIdAndGagId($gag->getId(), $request->get('id_comment'));
        if (empty($comment)) {
            return new JsonResponse(['message' => 'No comment found for the given id : '.$request->get('id_comment').' for the Gag with id : '.$request->get('id_gag')], Response::HTTP_NOT_FOUND);
        }

        $json = [
            'id' => $comment->getId(),
            'message' => $comment->getMessage(),
            'published_at' => $comment->getPublishedAt(),
            'author' => $comment->getAuthor()->getUsername(),
        ];

        return new JsonResponse($json);
    }
}
