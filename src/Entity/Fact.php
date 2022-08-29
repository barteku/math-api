<?php

namespace App\Entity;

use App\Repository\FactRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactRepository::class)]
class Fact
{
    #[ORM\Column(length: 255)]
    private string $value;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity:"Attribute", inversedBy:"facts")]
    #[ORM\JoinColumn(name:"attribute_id", referencedColumnName:"id")]
    private Attribute $attribute;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity:"Security", inversedBy:"facts")]
    #[ORM\JoinColumn(name:"security_id", referencedColumnName:"id")]
    private Security $security;

    /**
     * Fact constructor.
     * @param string|null $value
     */
    public function __construct(string $value = null)
    {
        if($value){
            $this->value = $value;
        }

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getAttribute(): ?Attribute
    {
        return $this->attribute;
    }

    public function setAttribute(?Attribute $attribute): self
    {
        $this->attribute = $attribute;

        return $this;
    }

    public function getSecurity(): ?Security
    {
        return $this->security;
    }

    public function setSecurity(?Security $security): self
    {
        $this->security = $security;

        return $this;
    }


}
