<?php

namespace App\Entity;

use App\Repository\AttributeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttributeRepository::class)]
#[ORM\Index(name: "name_idx", columns: ["name"])]
class Attribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity:"Fact", mappedBy:"attribute")]
    private ?Collection $facts;

    /**
     * Attribute constructor.
     * @param int|null $id
     * @param string|null $name
     */
    public function __construct(int $id = null, string $name = null)
    {
        $this->facts = new ArrayCollection();

        if($id){
            $this->id = $id;
        }

        if($name){
            $this->name = $name;
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Fact>
     */
    public function getFacts(): Collection
    {
        return $this->facts;
    }

    /**
     * @param Fact $fact
     * @return $this
     */
    public function addFact(Fact $fact): self
    {
        if (!$this->facts->contains($fact)) {
            $this->facts->add($fact);
            $fact->setAttribute($this);
        }

        return $this;
    }

    /**
     * @param Fact $fact
     * @return $this
     */
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



    public function getFactForSecurity(Security $security): Fact|false
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->eq('security', $security));
        return $this->facts->matching($criteria)->first();
    }

}
