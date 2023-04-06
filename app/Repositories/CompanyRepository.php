<?php

namespace App\Repositories;

use App\Models\Company;
use Illuminate\Support\Collection;

class CompanyRepository
{
    function pluck()
    {
        $data = [];
        $companies = Company::orderBy('name')->get();
        foreach ($companies as $company)
        {
            $data[$company->id] = $company->name;
        }

        return $data;
    }
}
