<?php

namespace App\Http\Controllers\Backend;

/**
 * Class DashboardController.
 */
class DashboardController
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return view('backend.dashboard');
    }
}
