<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Interfaces\CustomerInterface;

class CustomerRepository implements CustomerInterface
{
    public function findByPhone(string $phone): ?Customer
    {
        return Customer::withTrashed()
            ->where('phone', $phone)
            ->first();
    }

    public function findActiveById(int $id): Customer
    {
        return Customer::findOrFail($id);
    }

    public function findByIdIncludingTrashed(int $id): Customer
    {
        return Customer::withTrashed()->findOrFail($id);
    }

    public function deactivate(Customer $customer): void
    {
        if (! $customer->trashed()) {
            $customer->update(['is_active' => false]);
            $customer->delete();
        }
    }

    public function reactivate(Customer $customer): void
    {
        if ($customer->trashed()) {
            $customer->restore();
        }

        $customer->update(['is_active' => true]);
    }
}
