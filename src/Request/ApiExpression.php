<?php


namespace App\Request;


use App\ApiFunction\ApiFunctionInterface;
use App\Entity\Attribute;
use App\Entity\Security;

class ApiExpression
{
    /**
     * @var ApiFunctionInterface
     */
    public ApiFunctionInterface $fn;

    /**
     * @var Attribute|ApiExpression|float
     */
    public float | ApiExpression | Attribute $a;

    /**
     * @var Attribute|ApiExpression|float
     */
    public float | ApiExpression | Attribute $b;


    /**
     * @param Security $security
     * @return float
     */
    public function calculateValue(Security $security) : float
    {
        $a = $this->getParameterValue($this->a, $security);
        $b = $this->getParameterValue($this->b, $security);

        return $this->fn->calculate($a, $b);
    }


    /**
     * @param Attribute|ApiExpression|float $param
     * @param Security $security
     * @return Attribute|ApiExpression|float|string|null
     */
    private function getParameterValue(float | ApiExpression | Attribute $param, Security $security){
        if($param instanceof ApiExpression){
            return $param->calculateValue($security);
        }elseif ($param instanceof Attribute){
            $fact = $param->getFactForSecurity($security);
            if($fact){
                return $fact->getValue();
            }else {
                return null;
            }
        }else{
            return $param;
        }
    }

}
