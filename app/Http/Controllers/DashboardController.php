<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Registration;
use App\Models\Polyclinic;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPatients = Patient::where('is_active', true)->count();

        $todayVisits = Registration::whereDate(
            'visit_date',
            today()
        )->count();

        $waitingVisits = Registration::whereDate('visit_date', today())
            ->where('status', 'MENUNGGU')
            ->count();

        $inProgressVisits = Registration::whereDate('visit_date', today())
            ->where('status', 'DIPERIKSA')
            ->count();

        $completedVisits = Registration::whereDate('visit_date', today())
            ->where('status', 'SELESAI')
            ->count();

        $polyclinicStats = Polyclinic::withCount([
            'registrations as visits_today_count' => function ($query) {
                $query->whereDate('visit_date', today());
            }
        ])
            ->orderByDesc('visits_today_count')
            ->get();

        return view('dashboard.index', compact(
            'totalPatients',
            'todayVisits',
            'waitingVisits',
            'inProgressVisits',
            'completedVisits',
            'polyclinicStats'
        ));
    }
}
