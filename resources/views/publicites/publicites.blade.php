@extends('layouts.master', ['title' => 'Paiements'])

@push('scripts')
    <script>
        let table = new DataTable('#dataTable');
    </script>
@endpush

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Paiements</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ url('/') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Tableau de bord
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Liste des paiements</li>
            </ul>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <p class="fw-medium text-primary-light mb-1">Réussis</p>
                        <h6 class="mb-0 text-success">{{ $succeeded }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <p class="fw-medium text-primary-light mb-1">En attente</p>
                        <h6 class="mb-0 text-warning">{{ $pending }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <p class="fw-medium text-primary-light mb-1">Échoués</p>
                        <h6 class="mb-0 text-danger">{{ $failed }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <p class="fw-medium text-primary-light mb-1">Remboursés</p>
                        <h6 class="mb-0 text-info">{{ $refunded }}</h6>
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
                                <th scope="col">Coiffeuse</th>
                                <th scope="col">Prix Service</th>
                                <th scope="col">Statut</th>
                                <th scope="col">Raison</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($paiements as $item)
                                <tr>
                                    <td>
                                        <strong>#{{ $item->numero_reservation }}</strong>
                                        <br>
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }} •
                                        {{ ucfirst(str_replace('_', ' ', $item->payment_method)) }}
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
                                        <h6 style="color: red">{{ number_format($item->prix_service, 0, ',', ' ') }} CFA</h6>
                                        <em style="color: green">Commission : {{ number_format($item->montant_commission, 0, ',', ' ') }} CFA</em>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'succeeded'  => 'success',
                                                'failed'     => 'danger',
                                                'pending'    => 'warning',
                                                'processing' => 'info',
                                                'cancelled'  => 'secondary',
                                                'refunded'   => 'info',
                                            ];
                                            $color = $statusColors[$item->status] ?? 'secondary';
                                            $labels = [
                                                'succeeded'  => 'Terminé',
                                                'failed'     => 'Échoué',
                                                'pending'    => 'En attente',
                                                'processing' => 'En cours',
                                                'cancelled'  => 'Annulé',
                                                'refunded'   => 'Remboursé',
                                            ];
                                        @endphp
                                        <span class="bg-{{ $color }}-focus text-{{ $color }}-main px-24 py-4 rounded-pill fw-medium text-sm">
                                            {{ $labels[$item->status] ?? ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($item->status === 'failed' && $item->failure_reason)
                                            <div class="alert alert-danger alert-dismissible fade show">
                                                Échec: {{ $item->failure_reason }}
                                            </div>
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-40 text-secondary-light">
                                        Aucun paiement pour le moment.
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
