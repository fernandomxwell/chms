<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

trait HandlesControllerErrors
{
    protected function handleException(\Exception $e, $redirectRoute)
    {
        Log::error($e);

        return redirect()->route($redirectRoute)
            ->with('error', __('error.' . Response::HTTP_INTERNAL_SERVER_ERROR))
            ->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
