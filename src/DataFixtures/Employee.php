<?php

namespace App\DataFixtures;

use App\Core\Employee\Domain\Entity\Interest;
use App\Shared\ValueObject\EmployeeId;
use App\Shared\ValueObject\InterestId;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class Employee extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $employeesJson = file_get_contents('./src/DataFixtures/Data/employees.json');
        $data = json_decode($employeesJson, true, 512, JSON_THROW_ON_ERROR);

        $interests = [];
        foreach ($data as $d) {
            $interests[] = $d['interests'];
        }

        $interests = array_values(array_unique(array_merge(...$interests)));
        $interestsAsKey = array_keys($interests);
        foreach ($interests as $i) {
            $interest = Interest::create(
                new InterestId(Uuid::uuid4()->toString()),
                $i,
            );
            $manager->persist($interest);
            $interestsAsKey[$i] = $interest;
        }

        foreach ($data as $d) {
            $employee = \App\Core\Employee\Domain\Entity\Employee::create(
                new EmployeeId(Uuid::uuid4()->toString()),
                $d['name'],
            );

            foreach ($d['interests'] as $i) {
                $employee->addInterest($interestsAsKey[$i]);
            }

            $manager->persist($employee);
        }

        $manager->flush();
    }
}
