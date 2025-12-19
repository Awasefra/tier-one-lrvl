<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Customer;
use App\Services\CustomerService;
use App\Http\Resources\CustomerResource;
use App\Http\Requests\CustomerStoreRequest;

class CustomerController extends BaseApiController
{
    public function __construct(
        private CustomerService $service
    ) {}

    public function index()
    {
        $paginator = $this->service->paginate(10);

        return $this->paginate(
            $paginator,
            CustomerResource::collection($paginator->items()),
            'Customer list'
        );
    }

    public function store(CustomerStoreRequest $request)
    {
        // If use base
        // $customer = $this->service->create($request->validated());

        // If use Repo
        $customer = $this->service->create($request->validated());

        return $this->success(
            new CustomerResource($customer),
            'Customer created',
            201
        );
    }

    public function show(Customer $customer)
    {
        return $this->success(
            new CustomerResource($this->service->find($customer))
        );
    }

    public function update(CustomerStoreRequest $request, Customer $customer)
    {
        $customer = $this->service->update(
            $customer,
            $request->validated()
        );

        return $this->success(
            new CustomerResource($customer),
            'Customer updated'
        );
    }

    public function destroy(Customer $customer)
    {
        $this->service->delete($customer);

        return $this->success(null, 'Customer deleted');
    }

    public function deactivate(int $customer)
    {
        $this->service->deactivateById($customer);

        return $this->success(null, 'Customer deactivated');
    }

    public function reactivate(int $customer)
    {
        $this->service->reactivateById($customer);

        return $this->success(null, 'Customer reactivated');
    }
}
