<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Breed;
use App\Models\Farm;
use App\Models\FeedingRecord;
use App\Models\Vaccination;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'animalCount' => Animal::count(),
            'activeAnimalCount' => Animal::where('status', 'active')->count(),
            'farmCount' => Farm::count(),
            'breedCount' => Breed::count(),
            'vaccinationCount' => Vaccination::count(),
            'feedingRecordCount' => FeedingRecord::count(),
            'upcomingVaccinations' => Vaccination::with('animal')->whereNotNull('next_due_date')->whereDate('next_due_date', '>=', today())->orderBy('next_due_date')->limit(5)->get(),
            'recentFeedings' => FeedingRecord::with('animal')->latest('fed_at')->limit(5)->get(),
        ]);
    }
}
