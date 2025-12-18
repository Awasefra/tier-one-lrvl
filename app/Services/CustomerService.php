<?php

namespace App\Services;

use App\Models\Customer;
use App\Services\Base\BaseCrudService;
use Illuminate\Database\Eloquent\Model;

class CustomerService extends BaseCrudService
{
    protected function model(): Model
    {
        return new Customer();
    }
}
