<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Warta;
use App\Models\Jemaat;
use App\Models\Pastoral;
use App\Models\Departemen;
use App\Models\JadwalIbadah;
use Illuminate\Http\Request;
use App\Models\PermohonanDoa;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalUsers' => User::count(),
            'totalWarta' => Warta::count(),
            'totalJemaat' => Jemaat::count(),
            'totalPastoral' => Pastoral::count(),
            'totalIbadah' => JadwalIbadah::count(),
            'totalDepartemen' => Departemen::count(),
            'totalEvent' => Event::count(),
            'totalDoa' => PermohonanDoa::count(),
            'latestWarta' => Warta::latest()->take(5)->get(),
        ]);
    }
}
