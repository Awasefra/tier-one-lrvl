<?php

namespace App\Interfaces;

use App\Models\Customer;

interface CustomerInterface
{
    // lookup
    public function findByPhone(string $phone): ?Customer;
    public function findActiveById(int $id): Customer;
    public function findByIdIncludingTrashed(int $id): Customer;

    // state change
    public function deactivate(Customer $customer): void;
    public function reactivate(Customer $customer): void;
}
