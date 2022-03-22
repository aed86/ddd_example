<?php

namespace App\DataFixtures;

use App\Core\Employee\Domain\Entity\Interest;
use App\Core\Gift\Domain\Entity\Category;
use App\Shared\ValueObject\CategoryId;
use App\Shared\ValueObject\EmployeeId;
use App\Shared\ValueObject\GiftId;
use App\Shared\ValueObject\InterestId;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class Gifts extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $giftsJson = file_get_contents('./src/DataFixtures/Data/gifts.json');
        $data = json_decode($giftsJson, true, 512, JSON_THROW_ON_ERROR);

        $categories = [];
        foreach ($data as $d) {
            $categories[] = $d['categories'];
        }

        $categories = array_values(array_unique(array_merge(...$categories)));
        $categoriesAsKey = array_keys($categories);
        foreach ($categories as $c) {
            $category = Category::create(
                new CategoryId(Uuid::uuid4()->toString()),
                $c,
            );
            $manager->persist($category);
            $categoriesAsKey[$c] = $category;
        }

        foreach ($data as $d) {
            $gift = \App\Core\Gift\Domain\Entity\Gift::create(
                new GiftId(Uuid::uuid4()->toString()),
                $d['name'],
            );

            foreach ($d['categories'] as $i) {
                $gift->addCategory($categoriesAsKey[$i]);
            }

            $manager->persist($gift);
        }

        $manager->flush();
    }
}
