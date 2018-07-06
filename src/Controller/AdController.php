<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdFilterType;
use App\Form\AdType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/** @Route("/ad", name="ad_") */
class AdController extends GenericController
{

    /**
     * @Route("/add", name="add")
     */
    public function add(EntityManagerInterface $em, Request $request)
    {
        $ad = new Ad();
        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $ad->setDateCreated(new Datetime());
            $em->persist($ad);
            $em->flush();

            $this->addFlash('success', 'Votre annonce a été enregistrée');
            $this->redirectToRoute('ad_index');
        }

        return $this->render('ad/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/index", name="index")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $formSearch = $this->buildFormSearch($request);
        $search = $formSearch->getData();
        $pageCount = 0;
        $pageCurrent = $search['pageCurrent'];
        if($pageCurrent<1) $pageCurrent = 1;

        $elements = null;
        if ($formSearch->isSubmitted() && $formSearch->isValid()) {

            $first_result = ($pageCurrent-1) * self::NB_RESULT_PER_PAGE;
            $query = $em->getRepository(Ad::class)->search($search['q'], $first_result);
            $elements = $this->paginate($query);

            $pageCount = ceil(count($elements) / self::NB_RESULT_PER_PAGE);

//            //update form data:
//            $search['pageCurrent'] = $pageCurrent;
//            $search['pageCount'] = $pageCount;
//            $formSearch->setData($search);

            //test pagination
            //dump($elements);
            //die();
        }


        /*
        'pageCurrent' => $pageCurrent,
        'pageCount' => $pageCount,
        */

        $pagination = array(
            'page' => $page,
            'route' => 'article_list',
            'pages_count' => ceil($articles_count / $maxArticles),
            'route_params' => array()
        );
..

























        return $this->render('ad/index.html.twig', [
            'formSearch' => $formSearch->createView(),
            'elements' => $elements,
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/view/{id}", name="view")
     */
    public function view(EntityManagerInterface $em, $id)
    {
        $element = $em->getRepository(Ad::class)->find($id);

        return $this->render('ad/view.html.twig', [
            'element' => $element,
            'menu' => $this->buildMenu(),
        ]);
    }



    /**
     * @Route("/my", name="myads_index")
     */
    public function myAdsIndex(EntityManagerInterface $em, Request $request)
    {
        $formSearch = $this->buildFormSearch($request);
        $search = $formSearch->getData();
        $pageCount = 0;
        $pageCurrent = $search['pageCurrent'];
        if($pageCurrent<1) $pageCurrent = 1;

        $elements = null;
        if ($formSearch->isSubmitted() && $formSearch->isValid()) {

            $first_result = ($pageCurrent-1) * self::NB_RESULT_PER_PAGE;
            $elements = $em->getRepository(Ad::class)->search($search['q'], $first_result);

            $pageCount = ceil(count($elements) / self::NB_RESULT_PER_PAGE);
        }



        return $this->render('ad/index.html.twig', [
            'formSearch' => $formSearch->createView(),
            'elements' => $elements,
            'pageCurrent' => $pageCurrent,
            'pageCount' => $pageCount,
        ]);
    }


    /**
     * @Route("/favorites", name="favoriteads_index")
     */
    public function FavoriteAdsIndex(EntityManagerInterface $em, Request $request)
    {
        $formSearch = $this->buildFormSearch($request);
        $search = $formSearch->getData();
        $pageCount = 0;
        $pageCurrent = $search['pageCurrent'];
        if($pageCurrent<1) $pageCurrent = 1;

        $elements = null;
        if ($formSearch->isSubmitted() && $formSearch->isValid()) {

            $first_result = ($pageCurrent-1) * self::NB_RESULT_PER_PAGE;
            $elements = $em->getRepository(Ad::class)->search($search['q'], $first_result);

            $pageCount = ceil(count($elements) / self::NB_RESULT_PER_PAGE);
        }



        return $this->render('ad/index.html.twig', [
            'formSearch' => $formSearch->createView(),
            'elements' => $elements,
            'pageCurrent' => $pageCurrent,
            'pageCount' => $pageCount,
        ]);
    }


}
