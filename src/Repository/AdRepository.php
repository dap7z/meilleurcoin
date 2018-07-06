<?php

namespace App\Repository;

use App\Entity\Ad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ad[]    findAll()
 * @method Ad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ad::class);
    }


    public function search($value, $first_result = 0, $max_results = 20)
    {
        $query = $this->createQueryBuilder('a');
        if(! empty($value)){
            $query->andWhere('a.title LIKE :val')
                ->orWhere('a.description LIKE :val')
                ->setParameter('val', "%$value%")
            ;
        }
        //$query->orderBy('a.id', 'DESC');

        return $query;
    }

}
