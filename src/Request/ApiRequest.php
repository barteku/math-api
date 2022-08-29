<?php


namespace App\Request;


use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use App\Request\ApiExpression;
use App\Entity\Security;


class ApiRequest extends ApiBaseRequest
{
    #[Type(ApiExpression::class)]
    #[NotBlank()]
    public ?ApiExpression $expression;

    #[Type(Security::class)]
    #[NotBlank()]
    public ?Security $security;


    /**
     * @return float
     */
    public function calculateValue(): float
    {
        return $this->expression->calculateValue($this->security);
    }

}
