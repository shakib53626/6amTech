<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;

if (!function_exists('handleException')) {
    function handleException(string $message, Exception $e): RedirectResponse
    {
        Log::error($message . ': ' . $e->getMessage());
        return redirect()->back()->with([ 'error' => 'Something went wrong.' ]);
    }
}
