<?php

namespace App\Serializer;

use App\ApiFunction\ApiFunctionInterface;
use App\Entity\Attribute;
use App\Request\ApiExpression;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;


class ApiExpressionDenormalizer implements DenormalizerInterface
{
    use SerializerAwareTrait;

    /**
     * @var array
     */
    private array $availableApiFunctions;

    /**
     * @var ObjectManager
     */
    private ObjectManager $objectManager;


    /**
     * ApiExpressionDenormalizer constructor.
     * @param array $availableApiFunctions
     * @param ObjectManager $objectManager
     */
    public function __construct(array $availableApiFunctions, ObjectManager $objectManager){
        $this->availableApiFunctions = $availableApiFunctions;
        $this->objectManager = $objectManager;
    }


    /**
     * @param mixed $data
     * @param string $type
     * @param string|null $format
     * @param array $context
     * @return ApiExpression|null
     */
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []) : ApiExpression|null
    {
        if(
            !array_key_exists('fn', $data) ||
            !array_key_exists('a', $data) ||
            !array_key_exists('b', $data)
        ){
            return null;
        }

        $object = new ApiExpression();
        $function = $this->findApiFunctionClass($data['fn']);

        if(!$function instanceof ApiFunctionInterface){
            return null;
        }

        $object->fn = $function;
        $object->a = $this->findArgument($data['a'], $type, $format, $context);
        $object->b = $this->findArgument($data['b'], $type, $format, $context);

        return $object;
    }


    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
       return $type === ApiExpression::class;
    }

    /**
     * used to find aggregate function
     * supported functions passed as global parameter in constructor
     *
     * @param string $fn
     * @return mixed
     */
    private function findApiFunctionClass(string $fn){
        foreach ($this->availableApiFunctions as $apiFunction){
            if($apiFunction::ACTION === $fn){
                return new $apiFunction;
            }
        }
    }

    /**
     * Used to find argument value from request
     *
     * @param mixed $argumentValue
     * @param $type
     * @param $format
     * @param $context
     * @return float|mixed
     */
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
