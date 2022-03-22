<?php

declare(strict_types = 1);

namespace App\Core\Gift\Domain\Entity;

use App\Core\Gift\Infrastructure\Repository\CategoryRepository;
use App\Shared\Aggregate\AggregateRoot;
use App\Shared\ValueObject\CategoryId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category extends AggregateRoot
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

    #[ORM\ManyToMany(targetEntity: Gift::class, inversedBy: 'categories')]
    private $gifts;

    #[ORM\Column(type: 'boolean', options:['default' => 'true'])]
    private $active;

    public function __construct(CategoryId $id, string $name)
    {
        $this->id = $id->getValue();
        $this->name = $name;
        $this->gifts = new ArrayCollection();
        $this->active = true;
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public static function create(CategoryId $id, string $name): self
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
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return Category
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
     * @return Category
     */
    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|\App\Core\Gift\Domain\Entity\Gift[]
     */
    public function getGifts(): Collection
    {
        return $this->gifts;
    }

    public function addGift(Gift $gift): self
    {
        if (!$this->gifts->contains($gift)) {
            $this->gifts[] = $gift;
        }

        return $this;
    }

    public function removeGift(Gift $gift): self
    {
        $this->gifts->removeElement($gift);

        return $this;
    }
}
