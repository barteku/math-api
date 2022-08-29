<?php


namespace App\Request;


use App\Serializer\ApiExpressionDenormalizer;
use App\Serializer\SecurityDenormalizer;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiRequestSerializer
{
    private array $availableApiFunctions;

    private ObjectManager $objectManager;



    public function __construct(array $availableApiFunctions, ObjectManager $objectManager){
        $this->availableApiFunctions = $availableApiFunctions;
        $this->objectManager = $objectManager;
    }



    public function denormalize($value){
        $apiFunctionDenormalizer = new ApiExpressionDenormalizer($this->availableApiFunctions, $this->objectManager);
        $serializer = new Serializer([$apiFunctionDenormalizer, new SecurityDenormalizer($this->objectManager) ], [new JsonEncoder()]);

        $apiFunctionDenormalizer->setSerializer($serializer);


        return $serializer->denormalize($value, ApiExpression::class, 'json');

    }


}
