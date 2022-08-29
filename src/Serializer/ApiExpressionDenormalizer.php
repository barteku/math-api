<?php

namespace App\Serializer;

use App\Entity\Attribute;
use App\Request\ApiExpression;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;


class ApiExpressionDenormalizer implements DenormalizerInterface
{
    use SerializerAwareTrait;

    private array $availableApiFunctions;

    private ObjectManager $objectManager;


    public function __construct(array $availableApiFunctions, ObjectManager $objectManager){
        $this->availableApiFunctions = $availableApiFunctions;
        $this->objectManager = $objectManager;
    }



    public function denormalize(mixed $data, string $type, string $format = null, array $context = []) : mixed
    {
        $object = new ApiExpression();
        $object->fn = $this->findApiFunctionClass($data['fn']);

        $object->a = $this->findArgument($data['a'], $type, $format, $context);
        $object->b = $this->findArgument($data['b'], $type, $format, $context);

        return $object;
    }


    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return is_array($data) && array_key_exists('fn', $data);
    }


    private function findApiFunctionClass(string $fn){
        foreach ($this->availableApiFunctions as $apiFunction){
            if($apiFunction::ACTION === $fn){
                return new $apiFunction;
            }
        }
    }


    private function findArgument(mixed $argumentValue, $type, $format, $context){
        if(is_numeric($argumentValue)){
            return (float) $argumentValue;
        }elseif (is_array($argumentValue)){
            return $this->serializer->deserialize(json_encode($argumentValue), $type, $format, $context);
        }else{
            return $this->objectManager->getRepository(Attribute::class)->findOneBy([
                'name' => $argumentValue
            ]);
        }

    }
}
