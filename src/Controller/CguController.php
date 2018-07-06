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

class CguController extends GenericController
{

    /**
     * @Route("/cgu", name="cgu")
     */
    public function index(){
        return $this->render('cgu/index.html.twig', [

        ]);
    }


}