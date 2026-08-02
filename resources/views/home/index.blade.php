@extends('layouts.master', ['title' => 'Tableau de bord'])

@push('scripts')
    <script>
        // ── Graphique "Statistiques revenu" (#chart) ──
        var revenueOptions = {
            series: [{
                name: 'Revenus bruts',
                data: @json($monthValues)
            }],
            chart: {
                type: 'area',
                height: 280,
                toolbar: {
                    show: false
                }
            },
            xaxis: {
                categories: @json($monthLabels)
            },
            colors: ['#487FFF'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val.toLocaleString('fr-FR') + ' FCFA';
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#chart"), revenueOptions).render();

        // ── Graphique "Statistiques Gains" (#paymentStatusChart) ──
        var paymentStatusOptions = {
            series: @json($paymentStatusValues),
            chart: {
                type: 'donut',
                height: 280
            },
            labels: @json($paymentStatusLabels),
            colors: ['#FFC107', '#0d6efd', '#28a745'],
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                formatter: function(val, opts) {
                    return opts.w.config.series[opts.seriesIndex].toLocaleString('fr-FR');
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val.toLocaleString('fr-FR') + ' FCFA';
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#paymentStatusChart"), paymentStatusOptions).render();
    </script>
@endpush

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Tableau de bord</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="#" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Tableau de bord
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Accueil</li>
            </ul>
        </div>

        <div class="row row-cols-xxxl-5 row-cols-lg-3 row-cols-sm-2 row-cols-1 gy-4">
            <div class="col">
                <div class="card shadow-none border bg-gradient-start-1 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total client</p>
                                <h6 class="mb-0">{{ $client }}</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="gridicons:multiple-users"
                                    class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div><!-- card end -->
            </div>
            <div class="col">
                <div class="card shadow-none border bg-gradient-start-3 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Totale Coiffeuse</p>
                                <h6 class="mb-0">{{ $hair }}</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-info rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="fluent:people-20-filled"
                                    class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div><!-- card end -->
            </div>
            <div class="col">
                <div class="card shadow-none border bg-gradient-start-2 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Réservation terminée</p>
                                <h6 class="mb-0">{{ $reservationTerminee }}</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-success rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="fa-solid:award" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div><!-- card end -->
            </div>
            <div class="col">
                <div class="card shadow-none border bg-gradient-start-2 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Réservation encours</p>
                                <h6 class="mb-0">{{ $reservationEncours }}</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-warning rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="fa-solid:award" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div><!-- card end -->
            </div>
            <div class="col">
                <div class="card shadow-none border bg-gradient-start-4 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Revenus totaux</p>
                                <h6 class="mb-0">{{ $total }} CFA</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-success-main rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="solar:wallet-bold" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-none border bg-gradient-start-4 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Commissions</p>
                                <h6 class="mb-0">{{ $commission }} CFA</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="solar:wallet-bold" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-none border bg-gradient-start-4 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Revenus Coiffeuses</p>
                                <h6 class="mb-0">{{ $coiffeuse }} CFA</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-info-main rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="solar:wallet-bold" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-none border bg-gradient-start-4 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">En attente</p>
                                <h6 class="mb-0">{{ $attente }} CFA</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-warning-main rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="solar:wallet-bold" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4 mt-1">
            <div class="col-xxl-12 col-xl-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <h6 class="text-lg mb-0">Statistiques revenu</h6>
                            <select class="form-select bg-base form-select-sm w-auto">
                                <option>Yearly</option>
                                <option>Monthly</option>
                                <option>Weekly</option>
                                <option>Today</option>
                            </select>
                        </div>
                        <div class="d-flex flex-wrap align-items-center gap-2 mt-8">
                            <h6 class="mb-0">{{ $commission }} FCFA</h6>
                        </div>
                        <div id="chart" class="pt-28 apexcharts-tooltip-style-1"></div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                            <h6 class="mb-2 fw-bold text-lg mb-0">Statistiques Gains</h6>
                            <select class="form-select form-select-sm w-auto bg-base border text-secondary-light">
                                <option>Today</option>
                                <option>Weekly</option>
                                <option>Monthly</option>
                                <option>Yearly</option>
                            </select>
                        </div>

                        <ul class="d-flex flex-wrap align-items-center mt-3 gap-3">
                            <li class="d-flex align-items-center gap-2">
                                <span class="w-12-px h-12-px rounded-circle bg-primary-600"></span>
                                <span class="text-secondary-light text-sm fw-semibold">Revenus:
                                    <span class="text-primary-light fw-bold">{{ $coiffeuse }} FCFA</span>
                                </span>
                            </li>
                            <li class="d-flex align-items-center gap-2">
                                <span class="w-12-px h-12-px rounded-circle bg-yellow"></span>
                                <span class="text-secondary-light text-sm fw-semibold">Commissions:
                                    <span class="text-primary-light fw-bold">{{ $commission }} FCFA</span>
                                </span>
                            </li>
                        </ul>

                        <div class="mt-40">
                            <div id="paymentStatusChart" class="margin-16-minus"></div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xxl-12 col-xl-12">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <div class="d-flex flex-wrap align-items-center gap-1 justify-content-between mb-16">
                            <ul class="nav border-gradient-tab nav-pills mb-0" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link d-flex align-items-center active" id="pills-recent-leads-tab"
                                        ...>
                                        Dernière Réservation
                                        <span
                                            class="text-sm fw-semibold py-6 px-12 bg-neutral-500 rounded-pill text-white line-height-1 ms-12 notification-alert">
                                            {{ $recentReservations->count() }}
                                        </span>
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-to-do-list" role="tabpanel"
                                aria-labelledby="pills-to-do-list-tab" tabindex="0">
                                <div class="table-responsive scroll-sm">
                                    <table class="table bordered-table sm-table mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Client</th>
                                                <th scope="col">Service</th>
                                                <th scope="col">Date</th>
                                                <th scope="col" class="text-center">Statut</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentReservations as $r)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $r->client_photo ? asset('storage/' . $r->client_photo) : asset('assets/images/user-default.png') }}"
                                                                alt=""
                                                                class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden object-fit-cover">
                                                            <div class="flex-grow-1">
                                                                <h6 class="text-md mb-0 fw-medium">{{ $r->client_prenom }}
                                                                    {{ $r->client_nom }}</h6>
                                                                <span
                                                                    class="text-sm text-secondary-light fw-medium">{{ $r->client_email ?? $r->numero_reservation }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $r->service_libelle }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($r->date_reservation)->format('d M Y') }}
                                                    </td>
                                                    <td class="text-center">
                                                        @php
                                                            $statutColors = [
                                                                'en_attente' => 'warning',
                                                                'confirmee' => 'info',
                                                                'en_cours' => 'primary',
                                                                'terminee' => 'success',
                                                                'annulee' => 'danger',
                                                                'no_show' => 'danger',
                                                            ];
                                                            $color = $statutColors[$r->statut] ?? 'secondary';
                                                        @endphp
                                                        <span
                                                            class="bg-{{ $color }}-focus text-{{ $color }}-main px-24 py-4 rounded-pill fw-medium text-sm">
                                                            {{ ucfirst(str_replace('_', ' ', $r->statut)) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-40 text-secondary-light">
                                                        Aucune réservation récente.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
