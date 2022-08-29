<?php

namespace App\Serializer;


use App\Entity\Security;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;


class SecurityDenormalizer implements DenormalizerInterface
{
    private ObjectManager $objectManager;


    public function __construct(ObjectManager $objectManager){
        $this->objectManager = $objectManager;
    }



    public function denormalize(mixed $data, string $type, string $format = null, array $context = []) : mixed
    {
        return $this->objectManager->getRepository(Security::class)->findOneBy([
            'symbol' => $data['symbol']
        ]);
    }


    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return is_array($data) && array_key_exists('symbol', $data);
    }

}
