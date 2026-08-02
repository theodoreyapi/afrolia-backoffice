@extends('layouts.master', ['title' => 'Rapport financier mensuel'])

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Rapport financier mensuel</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ url('/') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Tableau de bord
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Rapport financier mensuel</li>
            </ul>
        </div>

        <div class="row row-cols-lg-4 row-cols-2 gy-4 mb-24">
            <div class="col">
                <div class="card">
                    <div class="card-body p-20">
                        <p class="fw-medium text-primary-light mb-1">Revenu brut total</p>
                        <h6 class="mb-0">{{ number_format($totalBrut, 0, ',', ' ') }} F</h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body p-20">
                        <p class="fw-medium text-primary-light mb-1">Commissions totales</p>
                        <h6 class="mb-0">{{ number_format($totalCommission, 0, ',', ' ') }} F</h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body p-20">
                        <p class="fw-medium text-primary-light mb-1">Revenus coiffeuses</p>
                        <h6 class="mb-0">{{ number_format($totalNet, 0, ',', ' ') }} F</h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body p-20">
                        <p class="fw-medium text-primary-light mb-1">Évolution vs mois dernier</p>
                        @if ($evolution !== null)
                            <h6 class="mb-0 {{ $evolution >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ $evolution >= 0 ? '+' : '' }}{{ $evolution }}%
                            </h6>
                        @else
                            <h6 class="mb-0 text-secondary-light">—</h6>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-24">
                <h6 class="mb-16">Évolution sur 12 mois</h6>
                <div id="chartFinancier"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        new ApexCharts(document.querySelector("#chartFinancier"), {
            series: [{
                    name: 'Brut',
                    data: @json($bruts)
                },
                {
                    name: 'Commission',
                    data: @json($commissions)
                },
                {
                    name: 'Net coiffeuses',
                    data: @json($nets)
                },
            ],
            chart: {
                type: 'bar',
                height: 350,
                stacked: false,
                toolbar: {
                    show: false
                }
            },
            xaxis: {
                categories: @json($months)
            },
            colors: ['#487FFF', '#FFC107', '#28a745'],
            dataLabels: {
                enabled: false
            },
            tooltip: {
                y: {
                    formatter: v => v.toLocaleString('fr-FR') + ' FCFA'
                }
            }
        }).render();
    </script>
@endpush
