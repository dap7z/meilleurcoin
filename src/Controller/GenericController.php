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

class GenericController extends Controller
{


    protected function buildMenu(){

        $menu = new \ArrayObject();
        $menu['main_index'] = 'Accueil';
        $menu['ad_add'] = 'Déposer une annonce';
        $menu['ad_index'] = 'Liste des annonces';

//        //TODO: si non connecté:
//        $menu['nom_route3'] = 'Inscription';
//        $menu['nom_route4'] = 'Connexion';
//
//        //TODO: si connecté
//        $menu['nom_route5'] = 'Mes annonces';
//        $menu['nom_route6'] = 'Mes favoris';

        $menu['faq'] = 'FAQ';
        $menu['cgu'] = 'CGU';

        return $menu;
    }


}