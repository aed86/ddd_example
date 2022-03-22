<?php

declare(strict_types = 1);

namespace App\Tests\Unit\Core\Employee\Application\Model;

use App\Core\Employee\Application\Model\CreateEmployeeCommand;
use PHPUnit\Framework\TestCase;

class CreateEmployeeCommandTest extends TestCase
{

    public function testCreateEmployeeCommand_Success(): void
    {
        $command = new CreateEmployeeCommand("name", ["uuid"]);

        $this->assertEquals("name", $command->getName());
        $this->assertEquals(["uuid"], $command->getInterestIds());
    }
}
