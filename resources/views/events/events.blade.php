@extends('layouts.master', ['title' => 'Reservations'])

@push('scripts')
    <script>
        let table = new DataTable('#dataTable');
    </script>
@endpush

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Réservations</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ url('/') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Tableau de bord
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Liste des réservations</li>
            </ul>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <p class="fw-medium text-primary-light mb-1">Terminées</p>
                        <h6 class="mb-0 text-success">{{ $terminee }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <p class="fw-medium text-primary-light mb-1">Confirmée</p>
                        <h6 class="mb-0 text-info">{{ $confirmee }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <p class="fw-medium text-primary-light mb-1">En attente</p>
                        <h6 class="mb-0 text-warning">{{ $enattente }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <p class="fw-medium text-primary-light mb-1">Annulées</p>
                        <h6 class="mb-0 text-danger">{{ $annulee }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card h-100 p-0 radius-12">
            <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px">
                        <option>Status</option>
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="card-body p-24">
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Coiffeuse</th>
                                <th scope="col">Service</th>
                                <th scope="col">Note</th>
                                <th scope="col">Statut</th>
                                <th scope="col">Raison</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reservations as $item)
                                <tr>
                                    <td>
                                        <strong>#{{ $item->numero_reservation }}</strong>
                                        <br>
                                        Créé le {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y à H:i') }}
                                        <br>
                                        @if($item->statut_paiement === 'paye')
                                            <span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Payé</span>
                                        @elseif($item->statut_paiement === 'rembourse')
                                            <span class="bg-info-focus text-info-main px-24 py-4 rounded-pill fw-medium text-sm">Remboursé</span>
                                        @elseif($item->statut_paiement === 'echoue')
                                            <span class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">Échoué</span>
                                        @else
                                            <span class="bg-warning-focus text-warning-main px-24 py-4 rounded-pill fw-medium text-sm">En attente</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img height="48" width="48"
                                                src="{{ $item->client_photo ? asset('storage/'.$item->client_photo) : asset('assets/images/user-default.png') }}"
                                                alt="" class="flex-shrink-0 me-12 radius-8">
                                            <h6 class="text-md mb-0 fw-medium flex-grow-1">
                                                {{ $item->client_prenom }} {{ $item->client_nom }}
                                                <br>
                                                {{ $item->client_phone }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img height="48" width="48"
                                                src="{{ $item->coiffeuse_photo ? asset('storage/'.$item->coiffeuse_photo) : asset('assets/images/user-default.png') }}"
                                                alt="" class="flex-shrink-0 me-12 radius-8">
                                            <h6 class="text-md mb-0 fw-medium flex-grow-1">
                                                {{ $item->coiffeuse_prenom }} {{ $item->coiffeuse_nom }}
                                                <br>
                                                {{ $item->coiffeuse_phone }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <span>{{ $item->service_libelle }}</span>
                                        <h6>{{ number_format($item->montant_total, 0, ',', ' ') }} CFA</h6>
                                        {{ \Carbon\Carbon::parse($item->date_reservation)->format('d/m/Y') }} à
                                        {{ \Carbon\Carbon::parse($item->heure_reservation)->format('H:i') }}
                                        <br>
                                        {{ $item->service_duree }} minutes
                                        <br>
                                        <span>Service: {{ number_format($item->prix_service, 0, ',', ' ') }} CFA</span>
                                        <br>
                                        <span style="color: green">Commission: {{ number_format($item->montant_commission, 0, ',', ' ') }} CFA</span>
                                        <br>
                                        <em>{{ ucfirst($item->methode_paiement) }}</em>
                                    </td>
                                    <td>
                                        @if($item->notes)
                                            <div class="alert alert-warning alert-dismissible fade show">
                                                {{ $item->notes }}
                                            </div>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $statutColors = [
                                                'en_attente' => 'warning',
                                                'confirmee'  => 'info',
                                                'en_cours'   => 'primary',
                                                'terminee'   => 'success',
                                                'annulee'    => 'danger',
                                                'no_show'    => 'danger',
                                            ];
                                            $color = $statutColors[$item->statut] ?? 'secondary';
                                        @endphp
                                        <span class="bg-{{ $color }}-focus text-{{ $color }}-main px-24 py-4 rounded-pill fw-medium text-sm">
                                            {{ ucfirst(str_replace('_', ' ', $item->statut)) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($item->statut === 'annulee' && $item->raison_annulation)
                                            <div class="alert alert-danger alert-dismissible fade show">
                                                {{ $item->raison_annulation }}
                                                @if($item->annule_le)
                                                    <br>
                                                    Le {{ \Carbon\Carbon::parse($item->annule_le)->format('d/m/Y à H:i') }}
                                                @endif
                                                @if($item->annule_par)
                                                    <br>
                                                    par {{ ucfirst($item->annule_par) }}
                                                @endif
                                            </div>
                                        @endif

                                        @if($item->review_rating)
                                            <div class="alert alert-success alert-dismissible fade show">
                                                {{ $item->review_rating }}/5
                                                @if($item->review_comment)
                                                    <br>
                                                    "{{ $item->review_comment }}"
                                                @endif
                                                @if($item->termine_le)
                                                    <br>
                                                    Terminé le {{ \Carbon\Carbon::parse($item->termine_le)->format('d/m/Y à H:i') }}
                                                @endif
                                            </div>
                                        @endif

                                        @if(!$item->raison_annulation && !$item->review_rating)
                                            —
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-40 text-secondary-light">
                                        Aucune réservation pour le moment.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
