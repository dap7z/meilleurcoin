<?php
/**
 * Created by PhpStorm.
 * User: dpointier2017
 * Date: 06/07/2018
 * Time: 10:30
 */

namespace App\Services;


use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MenuService
{
    private $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    public function menuTop(){

        $user = $this->token->getToken()->getUser();
        if(($user instanceof User) === false){
            $user = null;
        }

        $menu = new \ArrayObject();
        $menu['main_index'] = 'Accueil';
        $menu['ad_add'] = 'Déposer une annonce';
        $menu['ad_index'] = 'Liste des annonces';

        $menu['faq'] = 'FAQ';
        $menu['cgu'] = 'CGU';


        if($user && $this->token->getToken()->getUser()->hasRole('ROLE_USER')){
            $menu['ad_myads_index'] = 'Mes annonces';
            $menu['ad_favoriteads_index'] = 'Mes favoris';
            $menu['logout'] = 'Déconnexion';
        }else{
            $menu['register'] = 'Créer un compte';
            $menu['login'] = 'Connexion';
        }


        return $menu;
    }
}