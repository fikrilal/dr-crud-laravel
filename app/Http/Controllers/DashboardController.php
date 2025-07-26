<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        switch ($user->user_type) {
            case 'admin':
                return $this->adminDashboard();
            case 'pharmacist':
                return $this->pharmacistDashboard();
            case 'customer':
                return $this->customerDashboard();
            default:
                abort(403, 'Invalid user type');
        }
    }

    private function adminDashboard()
    {
        return view('dashboards.admin', [
            'title' => 'Admin Dashboard',
            'user' => auth()->user()
        ]);
    }

    private function pharmacistDashboard()
    {
        return view('dashboards.pharmacist', [
            'title' => 'Pharmacist Dashboard',
            'user' => auth()->user()
        ]);
    }

    private function customerDashboard()
    {
        return view('dashboards.customer', [
            'title' => 'Customer Dashboard',
            'user' => auth()->user()
        ]);
    }
}
