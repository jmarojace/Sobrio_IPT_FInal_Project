@extends('layouts.app', ['title' => 'Overview'])

@section('content')
    <style>
        .welcome-banner { position:relative; overflow:hidden; min-height:250px; padding:36px 40px; border-radius:22px; color:#fffdf4; background:linear-gradient(112deg,#1a4832 0%,#286044 62%,#3d7651 100%); box-shadow:0 16px 35px #1b493020; }
        .welcome-banner::before,.welcome-banner::after { content:''; position:absolute; border:1px solid #ffffff15; border-radius:50%; pointer-events:none; }
        .welcome-banner::before { width:350px; height:350px; right:135px; top:-220px; }
        .welcome-banner::after { width:470px; height:470px; right:75px; top:-280px; }
        .welcome-copy { position:relative; z-index:2; max-width:490px; }
        .welcome-eyebrow { display:inline-flex; align-items:center; gap:8px; color:#d8e6ce; font-size:11px; font-weight:700; letter-spacing:.13em; text-transform:uppercase; }
        .welcome-eyebrow svg { width:15px; height:15px; }
        .welcome-title { margin:16px 0 10px; color:#fffdf4; font-size:clamp(28px,3vw,38px); font-weight:800; letter-spacing:-.055em; line-height:1.12; }
        .welcome-description { max-width:390px; color:#d1dfd2; font-size:14px; line-height:1.7; }
        .welcome-button { color:#214b35; background:#f1e8d3; border-color:#f1e8d3; }
        .welcome-button:hover { color:#173d2b; background:#fff7e5; border-color:#fff7e5; }
        .farm-illustration { position:absolute; width:min(43%,390px); right:16px; bottom:0; z-index:1; }
        .stat-card { --stat-tint:#e9f0e5; --stat-color:#24583f; }
        .stat-card:nth-child(2) { --stat-tint:#f6eadb; --stat-color:#a56538; }
        .stat-card:nth-child(3) { --stat-tint:#e8edf3; --stat-color:#586f8a; }
        .stat-card:nth-child(4) { --stat-tint:#f5e8e5; --stat-color:#a75b4d; }
        .stat-card:nth-child(5) { --stat-tint:#f2efd9; --stat-color:#8e7a2e; }
        .dashboard-section-heading { letter-spacing:-.025em; }
        @media(max-width:767px) { .welcome-banner { min-height:245px; padding:28px 24px; } .welcome-copy { max-width:100%; } .welcome-description { max-width:300px; } .farm-illustration { width:210px; right:-38px; opacity:.44; } }
    </style>
    <div class="welcome-banner mb-4 mb-lg-5">
        <div class="welcome-copy">
            <div class="welcome-eyebrow"><svg><use href="#icon-sun"></use></svg> Your farm at a glance</div>
            <h1 class="welcome-title">A better day<br>for your herd.</h1>
            <p class="welcome-description mb-4">Keep your livestock, health schedules, and daily feeding in one peaceful place.</p>
            <a href="{{ route('animals.create') }}" class="btn welcome-button rounded-3 px-3 py-2">＋ Register an animal</a>
        </div>
        <svg class="farm-illustration" viewBox="0 0 390 240" fill="none" aria-hidden="true">
            <circle cx="293" cy="61" r="27" fill="#EFC98D"/>
            <path d="M0 170c41-35 86-46 132-24 44 22 79 7 118-17 46-28 93-28 140 1v110H0V170Z" fill="#769C69"/>
            <path d="M0 197c55-37 111-35 160-13 58 26 107 15 151-11 26-15 52-19 79-7v74H0v-43Z" fill="#A8B979"/>
            <path d="M211 103h92v92h-92z" fill="#F1DFB9"/>
            <path d="m197 108 60-51 60 51v11H197v-11Z" fill="#B76C4A"/>
            <path d="M242 151a15 15 0 0 1 30 0v44h-30v-44Z" fill="#876445"/>
            <path d="M225 123h19v20h-19zM270 123h19v20h-19z" fill="#9FC0AA"/>
            <path d="M30 207v-37m0 13 30-15m-30 31 35-13m-35 28 36-10m87-32v-45m0 19 31-18m-31 37 36-13m-36 30 34-9" stroke="#E5D4A7" stroke-width="5" stroke-linecap="round"/>
            <path d="M0 214h390" stroke="#E5D4A7" stroke-width="4"/>
            <path d="M93 177c6-9 17-12 28-8l10 4 11-3c8-2 16 3 17 11l-2 14h-61l-3-18Zm17-8 6-8 8 2 6 9m16 2 4-10 8 2 2 10" fill="#F7F2E6"/>
            <circle cx="111" cy="183" r="2" fill="#3E4A3D"/><circle cx="151" cy="183" r="2" fill="#3E4A3D"/>
            <path d="M104 198v10m40-10v10m17-19 9 3" stroke="#6B5947" stroke-width="4" stroke-linecap="round"/>
            <path d="M19 224h352" stroke="#F4E6C6" stroke-width="3" stroke-linecap="round" opacity=".8"/>
        </svg>
    </div>

    <div class="row g-3 mb-4">
        @foreach ([['Animals', $animalCount, 'icon-animal', $activeAnimalCount.' active'], ['Farms', $farmCount, 'icon-farm', 'Locations'], ['Breeds', $breedCount, 'icon-breed', 'Registered'], ['Vaccinations', $vaccinationCount, 'icon-health', 'Health records'], ['Feeding logs', $feedingRecordCount, 'icon-feed', 'Care entries']] as [$label, $value, $icon, $caption])
            <div class="col-6 col-xl">
                <div class="card stat-card h-100 p-3 p-lg-4">
                    <div class="d-flex justify-content-between align-items-start mb-3"><span class="small fw-semibold text-muted-custom">{{ $label }}</span><span class="stat-icon"><svg><use href="#{{ $icon }}"></use></svg></span></div>
                    <div class="h2 fw-bold mb-1">{{ $value }}</div><div class="small text-muted-custom">{{ $caption }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-xl-7">
            <div class="card h-100">
                <div class="d-flex justify-content-between align-items-center p-4 border-bottom" style="border-color:var(--line)!important">
                    <div><div class="fw-bold dashboard-section-heading">Vaccinations coming up</div><div class="small text-muted-custom">Keep preventive care on schedule</div></div>
                    <a href="{{ route('vaccinations.index') }}" class="btn btn-sm btn-outline-success rounded-3">View all</a>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0"><thead><tr><th class="ps-4">Animal</th><th>Vaccine</th><th class="pe-4">Due date</th></tr></thead><tbody>
                    @forelse ($upcomingVaccinations as $vaccination)
                        <tr><td class="ps-4 fw-semibold">{{ $vaccination->animal->tag_number }} <span class="text-muted-custom fw-normal">{{ $vaccination->animal->name }}</span></td><td>{{ $vaccination->vaccine_name }}</td><td class="pe-4">{{ $vaccination->next_due_date->format('M j, Y') }}</td></tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted-custom py-5">No upcoming vaccinations recorded.</td></tr>
                    @endforelse
                    </tbody></table>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card h-100">
                <div class="d-flex justify-content-between align-items-center p-4 border-bottom" style="border-color:var(--line)!important">
                    <div><div class="fw-bold dashboard-section-heading">Recent feeding records</div><div class="small text-muted-custom">Latest care activity</div></div>
                    <a href="{{ route('feeding-records.index') }}" class="btn btn-sm btn-outline-success rounded-3">View all</a>
                </div>
                <div class="p-2">
                    @forelse ($recentFeedings as $feeding)
                        <div class="d-flex justify-content-between align-items-center p-3 border-bottom" style="border-color:var(--line)!important">
                            <div><div class="fw-semibold">{{ $feeding->animal->tag_number }} <span class="text-muted-custom fw-normal">· {{ $feeding->feed_type }}</span></div><div class="small text-muted-custom">{{ $feeding->fed_at->format('M j, Y · g:i A') }}</div></div>
                            <span class="badge rounded-pill text-bg-light">{{ $feeding->quantity_kg }} kg</span>
                        </div>
                    @empty
                        <div class="text-center text-muted-custom py-5">No feeding records yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
