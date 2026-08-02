@extends('layouts.master', ['title' => 'Satisfaction client'])

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Satisfaction client</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium"><a href="{{ url('/') }}" class="hover-text-primary">Tableau de bord</a></li>
                <li>-</li>
                <li class="fw-medium">Satisfaction client</li>
            </ul>
        </div>

        <div class="row row-cols-lg-2 gy-4 mb-24">
            <div class="col">
                <div class="card">
                    <div class="card-body p-20">
                        <p class="fw-medium text-primary-light mb-1">Note moyenne</p>
                        <h6 class="mb-0">{{ $noteMoyenne ? number_format($noteMoyenne, 2) : '—' }} / 5</h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body p-20">
                        <p class="fw-medium text-primary-light mb-1">Total avis approuvés</p>
                        <h6 class="mb-0">{{ $totalAvis }}</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4">
            <div class="col-lg-5">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <h6 class="mb-16">Répartition des notes</h6>
                        <div id="chartSatisfaction"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <h6 class="mb-16">Top coiffeuses (min. 3 avis)</h6>
                        @forelse($topCoiffeuses as $c)
                            <div class="d-flex align-items-center justify-content-between mb-16">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $c->photo ? asset('storage/' . $c->photo) : asset('assets/images/user-default.png') }}"
                                        class="w-40-px h-40-px rounded-circle object-fit-cover">
                                    <div>
                                        <h6 class="text-md mb-0">{{ $c->name }} {{ $c->last_name }}</h6>
                                        <span class="text-secondary-light text-sm">{{ $c->nb_avis }} avis</span>
                                    </div>
                                </div>
                                <span class="fw-bold text-warning">{{ number_format($c->note_moyenne, 1) }} ★</span>
                            </div>
                        @empty
                            <p class="text-secondary-light text-center py-20">Aucune donnée.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-24">
            <div class="card-body p-24">
                <h6 class="mb-16">Avis nécessitant attention (≤ 2 étoiles)</h6>
                @forelse($avisNegatifs as $a)
                    <div class="border radius-8 p-16 mb-12">
                        <div class="d-flex align-items-center justify-content-between mb-8">
                            <h6 class="mb-0 text-md">
                                {{ $a->is_anonymous ? 'Anonyme' : $a->client_prenom . ' ' . $a->client_nom }}
                                → {{ $a->stylist_prenom }} {{ $a->stylist_nom }}
                            </h6>
                            <span class="text-danger fw-bold">{{ $a->rating }}/5</span>
                        </div>
                        @if ($a->comment)
                            <p class="text-secondary-light mb-0">{{ $a->comment }}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-secondary-light text-center py-20">Aucun avis négatif récent.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        new ApexCharts(document.querySelector("#chartSatisfaction"), {
            series: @json(array_values($repartitionData)),
            chart: {
                type: 'donut',
                height: 300
            },
            labels: ['1 étoile', '2 étoiles', '3 étoiles', '4 étoiles', '5 étoiles'],
            colors: ['#dc3545', '#e87e2f', '#FFC107', '#0d6efd', '#28a745'],
            legend: {
                position: 'bottom'
            },
        }).render();
    </script>
@endpush
