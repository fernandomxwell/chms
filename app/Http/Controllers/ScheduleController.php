<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexScheduleRequest;
use App\Http\Requests\StoreScheduleRequest;
use App\Services\ScheduleService;
use App\Services\ServiceTypeService;
use App\Traits\HandlesControllerErrors;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ScheduleController extends Controller implements HasMiddleware
{
    use HandlesControllerErrors;

    private $scheduleService;
    private $serviceTypeService;

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('menu', only: [
                'index',
                'create',
                'show',
            ]),
        ];
    }

    public function __construct(ScheduleService $scheduleService, ServiceTypeService $serviceTypeService)
    {
        $this->scheduleService = $scheduleService;
        $this->serviceTypeService = $serviceTypeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexScheduleRequest $request)
    {
        try {
            $scheduleGroups = $this->scheduleService->getPaginatedScheduleGroup($request);

            $scheduleGroups->makeHidden(['activity_id']);

            return view('schedules.index', [
                'scheduleGroups' => $scheduleGroups,
            ]);
        } catch (\Exception $e) {
            return $this->handleException($e, 'schedules.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $serviceTypes = $this->serviceTypeService->getAll([
                'id',
                'name',
            ]);

            return view('schedules.create', [
                'serviceTypes' => $serviceTypes,
            ]);
        } catch (\Exception $e) {
            return $this->handleException($e, 'schedules.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScheduleRequest $request)
    {
        try {
            $this->scheduleService->create($request);

            return redirect()
                ->route('schedules.index')
                ->with('success', 'Schedule created successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'schedules.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $scheduleGroup = $this->scheduleService->show($id);

            return view('schedules.show', $scheduleGroup);
        } catch (\Exception $e) {
            return $this->handleException($e, 'schedules.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $this->scheduleService->delete($id);

            return redirect()
                ->route('schedules.index')
                ->with('success', 'Schedule deleted successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'schedules.index');
        }
    }
}
