<?php

/**
 * Created by PhpStorm.
 * User: dpointier2017
 * Date: 02/07/2018
 * Time: 14:12
 */
namespace App\Controller;

use App\Form\AdFilterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/", name="main_") */
class MainController extends GenericController
{

    /**
     * Homepage
     *
     * @Route("/", name="index")
     */
    public function index(Request $request){
        return $this->render('main/index.html.twig', [
            'formSearch' => $this->buildFormSearch($request)->createView()
        ]);
    }


}