<?php

/**
 * Created by PhpStorm.
 * User: dpointier2017
 * Date: 02/07/2018
 * Time: 14:12
 */
namespace App\Controller;

use App\Entity\Ad;
use App\Entity\AdDataClass;
use App\Form\AdFilterType;
use App\Form\AdType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GenericController extends Controller
{
    const NB_RESULT_PER_PAGE = 2;

    protected function buildFormSearch(Request $request){
        $formSearch = $this->createForm(AdFilterType::class);
        $formSearch->handleRequest($request);

        return $formSearch;
    }

}