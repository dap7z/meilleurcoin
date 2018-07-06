<?php
/**
 * Created by PhpStorm.
 * User: aae
 * Date: 12/05/17
 * Time: 08:44
 */

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\PropertyAccess\PropertyAccess;

class EntitiesToPropertyTransformer implements DataTransformerInterface
{

    /** @var  ObjectManager */
    protected $em;

    /** @var  string */
    protected $className;

    /** @var  string */
    protected $textProperty;

    /** @var  string */
    protected $primaryKey;

    /** @var PropertyAccessor */
    protected $accessor;

    /**
     * EntityToPropertyTransformer constructor.
     */
    public function __construct(ObjectManager $em,$class,$textProperty,$primary)
    {
        $this->em = $em;
        $this->className = $class;
        $this->textProperty = $textProperty;
        $this->primaryKey = $primary;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    public function transform($entities)
    {
        if (empty($entities)) {
            return array();
        }
        $data = array();
        foreach ($entities as $entity) {
            $text = '';
            if(is_null($this->textProperty)){
                //$text = (string) $entity;
                //$text = get_class($entity);
                $r = new \ReflectionClass($entity);
                //$text = $r->getShortName();
                $text = (string) $r->getName();
            }else{
                $text = $this->accessor->getValue($entity, $this->textProperty);
            }

            if ($this->em->contains($entity)) {
                $value = $this->accessor->getValue($entity, $this->primaryKey);
            }
            $data[$value] = $text;
        }
        return $data;
    }

    public function reverseTransform($values)
    {
        if (!is_array($values) || empty($values)) {
            return array();
        }

        try {
            // get multiple entities with one query
            $entities = $this->em->createQueryBuilder()
                ->select('entity')
                ->from($this->className, 'entity')
                ->where('entity.'.$this->primaryKey.' IN (:ids)')
                ->setParameter('ids', $values)
                ->getQuery()
                ->getResult();
        }
        catch (\Exception $ex) {
            // this will happen if the form submits invalid data
            throw new TransformationFailedException('One or more id values are invalid');
        }
        return $entities;
    }


}