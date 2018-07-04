<?php

namespace App\Controller;

use App\Entity\Ad;
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
    public function add()
    {
        return $this->render('ad/add.html.twig', [
            'menu' => $this->buildMenu(),
        ]);
    }

    /**
     * @Route("/index", name="index")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $q = $request->get('q');
//        dump("q:".$q);
//        die();

        $elements = $em->getRepository(Ad::class)->search($q);

        return $this->render('ad/index.html.twig', [
            'menu' => $this->buildMenu(),
            'elements' => $elements
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
}
