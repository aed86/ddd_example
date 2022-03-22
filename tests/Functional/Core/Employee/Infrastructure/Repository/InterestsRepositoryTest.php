<?php

declare(strict_types = 1);

namespace App\Tests\Functional\Core\Employee\Infrastructure\Repository;

use App\Core\Employee\Domain\Entity\Interest;
use App\Core\Employee\Domain\Repository\InterestRepositoryInterface;
use App\Shared\ValueObject\InterestId;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InterestsRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    private InterestRepositoryInterface $repository;

    public function testSave(): void
    {
        $interest = Interest::create(
            new InterestId(Uuid::uuid4()->toString()),
            "test interest",
        );

        $this->repository->save($interest);
        /** @var Interest $result */
        $result = $this->repository->findOneBy(['id' => $interest->getId()]);
        $this->assertNotEmpty($result, "interest should not be empty");
        $this->assertEquals($interest, $result, "result is not equal");
    }

    public function testFindBy(): void
    {
        $interest = Interest::create(
            new InterestId(Uuid::uuid4()->toString()),
            "test interest",
        );

        $this->repository->save($interest);
        /** @var \App\Core\Employee\Domain\Entity\Interest $interest */
        $result = $this->repository->findOneBy(['id' => $interest->getId()]);

        $this->assertEquals($interest->getName(), $result->getName(), "wrong name");
        $this->assertCount(0, $interest->getEmployees()->toArray(), "wrong employees count");
    }

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->repository = $this->entityManager->getRepository(Interest::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
