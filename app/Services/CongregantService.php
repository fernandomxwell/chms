<?php

namespace App\Services;

use App\Http\Requests\IndexCongregantRequest;
use App\Http\Requests\StoreCongregantRequest;
use App\Http\Requests\UpdateCongregantRequest;
use App\Models\Congregant;
use Illuminate\Http\Request;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class CongregantService
{
    public function getPaginatedCongregants(IndexCongregantRequest $request)
    {
        $validatedData = $request->validated();

        return Congregant::searchBy($validatedData)
            ->when($validatedData['status'] ?? null, function ($query) use ($validatedData) {
                $query->where('status', $validatedData['status']);
            })
            ->when($validatedData['gender'] ?? null, function ($query) use ($validatedData) {
                $query->where('gender', $validatedData['gender']);
            })
            ->select([
                'id',
                'full_name',
                'gender',
                'phone_number',
                'email',
                'status',
            ])
            ->paginate()
            ->withQueryString();
    }

    public function create(StoreCongregantRequest $request)
    {
        $data = $request->validated();
        $data['phone_number'] = $this->normalizePhoneNumber($data['phone_number'] ?? null);

        return Congregant::create($data);
    }

    public function update(UpdateCongregantRequest $request, int $id)
    {
        $congregant = Congregant::findOrFail($id, ['id']);

        $data = $request->validated();
        $data['phone_number'] = $this->normalizePhoneNumber($data['phone_number'] ?? null);

        $congregant->update($data);

        return $congregant;
    }

    public function delete(int $id)
    {
        Congregant::findOrFail($id, ['id'])->delete();
    }

    public function getCongregantsForAjax(Request $request)
    {
        return Congregant::query()
            // ->where('status', 'member')
            ->searchBy($request->all())
            ->doesntHave('serviceTypes')
            ->orderBy('full_name')
            ->select([
                'id',
                'full_name',
            ])
            ->simplePaginate();
    }

    private function normalizePhoneNumber(?string $phoneNumber)
    {
        if (! $phoneNumber) {
            return null;
        }

        try {
            $phoneNumberUtil = PhoneNumberUtil::getInstance();
            $phoneNumberProto = $phoneNumberUtil->parse($phoneNumber, 'ID');

            return $phoneNumberUtil->format($phoneNumberProto, PhoneNumberFormat::E164);
        } catch (NumberParseException $e) {
            // [TODO] Log the error or handle it as needed
            return null;
        }
    }
}
