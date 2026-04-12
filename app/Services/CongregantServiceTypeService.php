<?php

namespace App\Services;

use App\Http\Requests\IndexCongregantServiceTypeRequest;
use App\Http\Requests\StoreCongregantServiceTypeRequest;
use App\Http\Requests\UpdateCongregantServiceTypeRequest;
use App\Models\Congregant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CongregantServiceTypeService
{
    public function index(IndexCongregantServiceTypeRequest $request)
    {
        $validatedData = $request->validated();

        return Congregant::query()
            ->with([
                'activities:name',
                'serviceTypes:name',
            ])
            ->when($validatedData['search'] ?? null, function (Builder $query) use ($validatedData) {
                $query->searchBy($validatedData)
                    ->orWhereHas('activities', function (Builder $query) use ($validatedData) {
                        $query->searchBy($validatedData);
                    })
                    ->orWhereHas('serviceTypes', function (Builder $query) use ($validatedData) {
                        $query->searchBy($validatedData);
                    });
            }, function (Builder $query) use ($validatedData) {
                $query->searchBy($validatedData)
                    ->has('activities')
                    ->orHas('serviceTypes');
            })
            ->select([
                'id',
                'full_name',
                'can_serve_consecutively',
            ])
            ->orderBy('full_name')
            ->paginate()
            ->withQueryString();
    }

    public function create(StoreCongregantServiceTypeRequest $request)
    {
        $validatedData = $request->validated();

        $congregantId = $validatedData['congregant_id'];
        $canServeConsecutively = $validatedData['can_serve_consecutively'];
        $activityIds = $validatedData['activity_ids'];
        $serviceTypeIds = $validatedData['service_type_ids'];

        $this->assign($congregantId, $canServeConsecutively, $activityIds, $serviceTypeIds);
    }

    public function update(UpdateCongregantServiceTypeRequest $request, int $congregantId)
    {
        $validatedData = $request->validated();

        $canServeConsecutively = $validatedData['can_serve_consecutively'];
        $activityIds = $validatedData['activity_ids'];
        $serviceTypeIds = $validatedData['service_type_ids'];

        $this->assign($congregantId, $canServeConsecutively, $activityIds, $serviceTypeIds);
    }

    public function delete(int $congregantId)
    {
        $congregant = Congregant::findOrFail($congregantId, ['id']);
        $congregant->serviceTypes()->detach();
    }

    protected function assign(int $congregantId, bool $canServeConsecutively, array $activityIds, array $serviceTypeIds): void
    {
        DB::transaction(function () use ($congregantId, $canServeConsecutively, $activityIds, $serviceTypeIds) {
            $congregant = Congregant::findOrFail($congregantId, ['id']);

            $congregant->update([
                'can_serve_consecutively' => $canServeConsecutively,
            ]);
            $congregant->activities()->sync($activityIds);
            $congregant->serviceTypes()->sync($serviceTypeIds);
        });
    }
}
