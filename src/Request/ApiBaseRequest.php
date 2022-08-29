<?php


namespace App\Request;


use App\Entity\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiBaseRequest
{

    private ValidatorInterface $validator;

    private ApiRequestSerializer $serializer;

    private RequestStack $request;


    public function __construct(ValidatorInterface $validator, ApiRequestSerializer $serializer, RequestStack $request)
    {
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->request = $request;

        $this->populate();
    }

    public function validate(): void
    {
        $errors = $this->validator->validate($this);

        $messages = ['message' => 'validation_failed', 'errors' => []];

        /** @var \Symfony\Component\Validator\ConstraintViolation  */
        foreach ($errors as $message) {
            $messages['errors'][] = [
                'property' => $message->getPropertyPath(),
                'value' => $message->getInvalidValue(),
                'message' => $message->getMessage(),
            ];
        }

        if (count($messages['errors']) > 0) {
            $response = new JsonResponse($messages);
            $response->send();

            exit;
        }
    }

    protected function populate(): void
    {
        foreach ($this->request->getMainRequest()->toArray() as $property => $value) {
            if (property_exists($this, $property)) {
                if($property === 'expression'){
                    $this->{$property} = $this->serializer->denormalize($value, ApiExpression::class, 'json', []);
                }elseif($property === 'security') {
                    $this->{$property} = $this->serializer->denormalize(['symbol' => $value], Security::class, 'json', []);
                }
            }
        }
    }
}
