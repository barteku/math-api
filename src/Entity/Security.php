<?php

namespace App\Entity;

use App\Repository\SecurityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass: SecurityRepository::class)
 * @ORM\Index(name: "symbol_idx", columns: ["symbol"])
 */
class Security
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column
     */
    private ?int $id = null;

    /**
     * @ORM\Column(length: 255)
     */
    private ?string $symbol = null;

    /**
     * @ORM\OneToMany(targetEntity:"Fact", mappedBy:"attribute")
     */
    private ?Collection $facts;

    /**
     * Security constructor.
     * @param int|null $id
     * @param string|null $symbol
     */
    public function __construct(int $id = null, string $symbol = null)
    {
        $this->facts = new ArrayCollection();

        if($id){
            $this->id = $id;
        }

        if($symbol){
            $this->symbol = $symbol;
        }
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * @return Collection<int, Fact>
     */
    public function getFacts(): Collection
    {
        return $this->facts;
    }

    public function addFact(Fact $fact): self
    {
        if (!$this->facts->contains($fact)) {
            $this->facts->add($fact);
            $fact->setAttribute($this);
        }

        return $this;
    }

    public function removeFact(Fact $fact): self
    {
        if ($this->facts->removeElement($fact)) {
            // set the owning side to null (unless already changed)
            if ($fact->getAttribute() === $this) {
                $fact->setAttribute(null);
            }
        }

        return $this;
    }
}
