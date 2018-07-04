<?php

/**
 * Created by PhpStorm.
 * User: dpointier2017
 * Date: 02/07/2018
 * Time: 14:12
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class FaqController extends GenericController
{

    /**
     * @Route("/faq", name="faq")
     */
    public function index(){
        return $this->render('faq/index.html.twig', array(
            'menu' => $this->buildMenu()
        ));
    }


}