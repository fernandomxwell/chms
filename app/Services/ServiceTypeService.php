<?php

namespace App\Services;

use App\Http\Requests\IndexServiceTypeRequest;
use App\Http\Requests\StoreServiceTypeRequest;
use App\Http\Requests\UpdateServiceTypeRequest;
use App\Models\ServiceType;

class ServiceTypeService
{
    public function getPaginatedServiceTypes(IndexServiceTypeRequest $request)
    {
        $validatedData = $request->validated();

        return ServiceType::searchBy($validatedData)
            ->select([
                'id',
                'name',
            ])
            ->paginate()
            ->withQueryString();
    }

    public function create(StoreServiceTypeRequest $request): ServiceType
    {
        $data = $request->validated();

        $serviceType = ServiceType::withTrashed()
            ->where('name', $data['name'])
            ->first();

        if ($serviceType) {
            if ($serviceType->trashed()) {
                $serviceType->restore();
            }

            $serviceType->fill($data)->save();

            return $serviceType;
        }

        return ServiceType::create($data);
    }

    public function update(UpdateServiceTypeRequest $request, int $id): ServiceType
    {
        $serviceType = ServiceType::findOrFail($id, ['id']);

        $data = $request->validated();

        $serviceType->update($data);

        return $serviceType;
    }

    public function delete(int $id): void
    {
        ServiceType::findOrFail($id, ['id'])->delete();
    }

    public function getAll($attributes = ['*'])
    {
        return ServiceType::select($attributes)->get();
    }
}
