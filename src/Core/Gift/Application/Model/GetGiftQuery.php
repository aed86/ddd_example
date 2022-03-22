<?php

declare(strict_types=1);

namespace App\Core\Gift\Application\Model;

final class GetGiftQuery
{
    private string $giftId;

    public function __construct(string $giftId)
    {
        $this->giftId = $giftId;
    }

    public function getGiftId(): string
    {
        return $this->giftId;
    }
}
