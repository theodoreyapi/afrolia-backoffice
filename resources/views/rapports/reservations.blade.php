@extends('layouts.master', ['title' => 'Performances des réservations'])

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Performances des réservations</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium"><a href="{{ url('/') }}" class="hover-text-primary">Tableau de bord</a></li>
                <li>-</li>
                <li class="fw-medium">Performances des réservations</li>
            </ul>
        </div>

        <div class="row row-cols-lg-4 row-cols-2 gy-4 mb-24">
            <div class="col">
                <div class="card">
                    <div class="card-body p-20">
                        <p class="fw-medium text-primary-light mb-1">Total réservations</p>
                        <h6 class="mb-0">{{ $total }}</h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body p-20">
                        <p class="fw-medium text-primary-light mb-1">Taux de complétion</p>
                        <h6 class="mb-0 text-success">{{ $tauxCompletion }}%</h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body p-20">
                        <p class="fw-medium text-primary-light mb-1">Taux d'annulation</p>
                        <h6 class="mb-0 text-danger">{{ $tauxAnnulation }}%</h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body p-20">
                        <p class="fw-medium text-primary-light mb-1">Taux de no-show</p>
                        <h6 class="mb-0 text-warning">{{ $tauxNoShow }}%</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4">
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <h6 class="mb-16">Réservations sur 12 mois</h6>
                        <div id="chartReservations"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <h6 class="mb-16">Services les plus demandés</h6>
                        @forelse($parSpecialite as $s)
                            <div class="d-flex align-items-center justify-content-between mb-12">
                                <span class="text-secondary-light">{{ $s->libelle }}</span>
                                <span class="fw-bold">{{ $s->total }}</span>
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
        new ApexCharts(document.querySelector("#chartReservations"), {
            series: [{
                name: 'Réservations',
                data: @json($reservationsParMois)
            }],
            chart: {
                type: 'bar',
                height: 320,
                toolbar: {
                    show: false
                }
            },
            xaxis: {
                categories: @json($months)
            },
            colors: ['#487FFF'],
            dataLabels: {
                enabled: false
            },
        }).render();
    </script>
@endpush
