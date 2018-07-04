<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SerieController extends Controller
{
    /**
     * @Route("/serie", name="serie")
     */
    public function index()
    {
        return $this->render('serie/index.html.twig', [
            'controller_name' => 'SerieController',
        ]);
    }
}
