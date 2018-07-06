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

class EntityToPropertyTransformer implements DataTransformerInterface
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

    public function transform($entity)
    {
        $data = array();
        if (empty($entity)) {
            return $data;
        }

        $text = '';
        if(is_null($this->textProperty)){
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
        return $data;
    }

    public function reverseTransform($value)
    {
        if (empty($value)) {
            return null;
        }

        try {
            $entity = $this->em->createQueryBuilder()
                ->select('entity')
                ->from($this->className, 'entity')
                ->where('entity.'.$this->primaryKey.' = :id')
                ->setParameter('id', $value)
                ->getQuery()
                ->getSingleResult();
        }
        catch (\Exception $ex) {
            // this will happen if the form submits invalid data
            throw new TransformationFailedException(sprintf('The choice "%s" does not exist or is not unique', $value));
        }

        if (!$entity) {
            return null;
        }
        return $entity;
    }


}