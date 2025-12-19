<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use App\Interfaces\CustomerInterface;
use App\Services\Base\BaseCrudService;
use Illuminate\Database\Eloquent\Model;

class CustomerService extends BaseCrudService
{

    protected function model(): Model
    {
        return new Customer();
    }

    public function __construct(
        private CustomerInterface $repo
    ) {}

    public function register(array $payload): Customer
    {
        return DB::transaction(function () use ($payload) {
            $existing = $this->repo->findByPhone($payload['phone']);

            if ($existing) {
                if ($existing->trashed()) {
                    return $this->repo->reactivate($existing, $payload);
                }

                throw new \DomainException('Nomor sudah terdaftar');
            }

            return $this->create($payload);
        });
    }
    
    public function deactivateById(int $customerId): void
    {
        $customer = $this->repo->findByIdIncludingTrashed($customerId);

        if ($customer->trashed()) {
            throw new \DomainException('Customer already deactivated');
        }

        $this->repo->deactivate($customer);
    }


    public function reactivateById(int $customerId): void
    {
        $customer = $this->repo->findByIdIncludingTrashed($customerId);

        if (! $customer->trashed()) {
            throw new \DomainException('Customer already active');
        }

        $this->repo->reactivate($customer);
    }
}
