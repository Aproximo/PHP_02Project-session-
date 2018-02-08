<?php
/**
 * Created by PhpStorm.
 * User: or_os
 * Date: 20.11.2017
 * Time: 14:56
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



class ArticleController extends Controller
{

    /**
     * article list page
     *
     * @Route("/article", name="article")
     * @Template()
     */
    public function indexAction(Request $request){

        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM AppBundle:Article a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );
    
        return compact('pagination');
    }


//    public function listAction(Request $request)
//    {
//        $em    = $this->get('doctrine.orm.entity_manager');
//        $dql   = "SELECT a FROM AppBundle:Article a";
//        $query = $em->createQuery($dql);
//
//        $paginator  = $this->get('knp_paginator');
//        $pagination = $paginator->paginate(
//            $query, /* query NOT result */
//            $request->query->getInt('page', 1)/*page number*/,
//            10/*limit per page*/
//        );
//
//        // parameters to template
//        return ['pagination' => $pagination, 'article'=>];
//    }
    /**
     *
     * article by id
     * sl - for tralling slash if its needed
     *
     * @Route("/article/{id}{sl}", name="article_page", defaults={"sl" : ""}, requirements={"id" : "[1-9][0-9]*","sl":"/?"})
     * @Template()
     */
    public function showAction($id){
        $repo = $this->get('doctrine')->getRepository('AppBundle:Article');
        $article = $repo->find($id);

        if(!$article){
            throw $this -> createNotFoundException('Article not found');
        }

        return compact('article');
    }




}