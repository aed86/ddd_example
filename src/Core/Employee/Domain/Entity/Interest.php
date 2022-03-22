<?php

declare(strict_types = 1);

namespace App\Core\Employee\Domain\Entity;

use App\Core\Employee\Domain\Event\CategoryCreatedEvent;
use App\Core\Employee\Infrastructure\Repository\InterestRepository;
use App\Shared\Aggregate\AggregateRoot;
use App\Shared\ValueObject\CategoryId;
use App\Shared\ValueObject\InterestId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InterestRepository::class)]
class Interest extends AggregateRoot
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

    #[ORM\ManyToMany(targetEntity: Employee::class, inversedBy: 'interests')]
    private $employees;

    #[ORM\Column(type: 'boolean', options:['default' => 'true'])]
    private $active;

    public function __construct(InterestId $id, string $name)
    {
        $this->id = $id->getValue();
        $this->name = $name;
        $this->employees = new ArrayCollection();
        $this->active = true;
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public static function create(InterestId $id, string $name): self
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

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection|\App\Core\Employee\Domain\Entity\Employee[]
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployees(Employee $employee): self
    {
        if (!$this->employees->contains($employee)) {
            $this->employees[] = $employee;
        }

        return $this;
    }

    public function removeEmployee(Employee $element): self
    {
        $this->employees->removeElement($element);

        return $this;
    }
}
