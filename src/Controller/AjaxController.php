<?php

namespace App\Controller;

use App\Entity\City;
use ReflectionClass;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends Controller {

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/a3commun-ui-load_ajax", name="a3_commun_uibundle_ajax_entity")
     */
    public function autoCompleteTypeAction(Request $request){

        $srvPropertyAccessor = $this->get('property_accessor');

        //Récupération des paramètres
        $qFilter = $request->get('q');
        $entity = $request->get('entity');
        $primary = $request->get('primary');
        $textProperty = $request->get('textProperty');
        $searchProperty = $request->get('searchProperty');


        /* @var EntityManager */
        //$em = $this->getDoctrine()->getManagerForClass($entity);  //NOK "City"
        $em = $this->getDoctrine()->getManagerForClass(City::class);

        /* @var DoctrineQueryBuilder */
        $queryBuilder = $em->createQueryBuilder()
            ->select('entity')
            //->from($entity, 'entity') //NOK "City"
            ->from(City::class, 'entity')
        ;

        $tabFieldSearch = explode('|',$searchProperty);

        foreach($tabFieldSearch as $i => $fieldSearch){
            $queryBuilder->orWhere(
                $queryBuilder->expr()->like('entity.'.$fieldSearch, ':fullText'.$i)
            )->setParameter('fullText'.$i, '%'.$qFilter.'%');
        }


        $entities = $queryBuilder->distinct()->setFirstResult(0)->setMaxResults(30)->getQuery()->getResult();

        $result = array();
        foreach($entities as $entity){
            $result[] = array(
                'id' => $srvPropertyAccessor->getValue($entity, $primary),
                'text' => ($textProperty=='') ? (string) $entity : $srvPropertyAccessor->getValue($entity, $textProperty),
            );
        }

        return new JsonResponse($result);
    }

}
