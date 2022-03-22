<?php

declare(strict_types = 1);

namespace App\Core\Employee\Domain\Entity;

use App\Core\Employee\Infrastructure\Repository\EmployeeRepository;
use App\Shared\Aggregate\AggregateRoot;
use App\Shared\ValueObject\EmployeeId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid', unique: true)]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private $updatedAt;

    #[ORM\ManyToMany(targetEntity: Interest::class, mappedBy: 'employees')]
    private $interests;

    public function __construct(EmployeeId $id, string $name)
    {
        $this->id = $id->getValue();
        $this->name = $name;
        $this->interests = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public static function create(EmployeeId $id, string $name): self
    {
        return new self(
            $id,
            $name,
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return Employee
     */
    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     * @return Employee
     */
    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Interest[]
     */
    public function getInterests(): Collection
    {
        return $this->interests;
    }

    public function addInterest(Interest $interest): self
    {
        if (!$this->interests->contains($interest)) {
            $this->interests[] = $interest;
            $interest->addEmployees($this);
        }

        return $this;
    }

    public function removeInterest(Interest $interest): self
    {
        if ($this->interests->removeElement($interest)) {
            $interest->removeEmployee($this);
        }

        return $this;
    }
}
