@extends('layouts.master', ['title' => 'Statistiques utilisateurs'])

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Statistiques utilisateurs</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium"><a href="{{ url('/') }}" class="hover-text-primary">Tableau de bord</a></li>
                <li>-</li>
                <li class="fw-medium">Statistiques utilisateurs</li>
            </ul>
        </div>

        <div class="row row-cols-lg-4 row-cols-2 gy-4 mb-24">
            <div class="col">
                <div class="card">
                    <div class="card-body p-20">
                        <p class="fw-medium text-primary-light mb-1">Total clients</p>
                        <h6 class="mb-0">{{ $totalClients }}</h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body p-20">
                        <p class="fw-medium text-primary-light mb-1">Total coiffeuses</p>
                        <h6 class="mb-0">{{ $totalCoiffeuses }}</h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body p-20">
                        <p class="fw-medium text-primary-light mb-1">Clients actifs</p>
                        <h6 class="mb-0 text-success">{{ $clientsActifs }}</h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body p-20">
                        <p class="fw-medium text-primary-light mb-1">Coiffeuses actives</p>
                        <h6 class="mb-0 text-success">{{ $coiffeusesActives }}</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4">
            <div class="col-lg-7">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <h6 class="mb-16">Nouvelles inscriptions (12 mois)</h6>
                        <div id="chartInscriptions"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <h6 class="mb-16">Top 5 clients</h6>
                        @forelse($topClients as $c)
                            <div class="d-flex align-items-center justify-content-between mb-16">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $c->photo ? asset('storage/' . $c->photo) : asset('assets/images/user-default.png') }}"
                                        class="w-40-px h-40-px rounded-circle object-fit-cover">
                                    <div>
                                        <h6 class="text-md mb-0">{{ $c->name }} {{ $c->last_name }}</h6>
                                        <span class="text-secondary-light text-sm">{{ $c->nb_reservations }}
                                            réservations</span>
                                    </div>
                                </div>
                                <span class="fw-bold text-success">{{ number_format($c->total_depense, 0, ',', ' ') }}
                                    F</span>
                            </div>
                        @empty
                            <p class="text-secondary-light text-center py-20">Aucune donnée.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        new ApexCharts(document.querySelector("#chartInscriptions"), {
            series: [{
                    name: 'Clients',
                    data: @json($clientsParMois)
                },
                {
                    name: 'Coiffeuses',
                    data: @json($coiffeusesParMois)
                },
            ],
            chart: {
                type: 'line',
                height: 320,
                toolbar: {
                    show: false
                }
            },
            xaxis: {
                categories: @json($months)
            },
            colors: ['#487FFF', '#e87e2f'],
            stroke: {
                curve: 'smooth',
                width: 2
            },
        }).render();
    </script>
@endpush
