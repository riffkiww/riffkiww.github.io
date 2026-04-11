<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $tableExists = Schema::hasTable('patients');

        $latestPatients = $tableExists
            ? Patient::query()->latest()->limit(5)->get()
            : collect();

        return view('dashboard', [
            'totalPatients' => $tableExists ? Patient::count() : 0,
            'activePatients' => $tableExists ? Patient::where('status', 'Aktif')->count() : 0,
            'newThisMonth' => $tableExists
                ? Patient::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count()
                : 0,
            'latestPatients' => $latestPatients,
        ]);
    }
}