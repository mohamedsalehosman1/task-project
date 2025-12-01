<?php

namespace Modules\Orders\Entities;

use App\Enums\OrderStatusEnum;
use App\Enums\TransactionTypeEnum;

trait OrderHelper
{

    public function getStatusColor()
    {
        return TransactionTypeEnum::colors($this->status);
    }

    public function getStatusName()
    {
        return TransactionTypeEnum::translatedName($this->status);
    }


    public function getStatus()
    {
        return "<span class='badge text-white' style='background-color: {$this->getStatusColor()}'>{$this->getStatusName()}</span>";
    }

    public function isPending()
    {
        return $this->status == OrderStatusEnum::Pending->value;
    }
}
