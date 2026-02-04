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
            <div
                class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
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
                            <tr>
                                <td>
                                    <strong>#AR001567</strong>
                                    <br>
                                    Créé le 20/03/2024 à 10:30
                                    <br>
                                    <span
                                        class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Payé</span>
                                    <span
                                        class="bg-warning-focus text-warning-main px-24 py-4 rounded-pill fw-medium text-sm">En
                                        attente</span>
                                    <span
                                        class="bg-info-focus text-info-main px-24 py-4 rounded-pill fw-medium text-sm">Remboursé</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src=" url($item->photo) ? $item->photo : url($item->photo)" alt=""
                                            class="flex-shrink-0 me-12 radius-8">
                                        <h6 class="text-md mb-0 fw-medium flex-grow-1">
                                            Yapi n'guessan kouassi theodore
                                            <br>
                                            +2250585831647
                                        </h6>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src=" url($item->photo) ? $item->photo : url($item->photo)" alt=""
                                            class="flex-shrink-0 me-12 radius-8">
                                        <h6 class="text-md mb-0 fw-medium flex-grow-1">
                                            Yapi theodore
                                            <br>
                                            +2250585831648
                                        </h6>
                                    </div>
                                </td>
                                <td>
                                    <span>Tresses Africaines</span>
                                    <h6>17 250 CFA</h6>
                                    22/03/2024 à 14:00
                                    <br>
                                    120 minutes
                                    <br>
                                    <span>Service: 15 000 CFA</span>
                                    <br>
                                    <span style="color: green">Commission: 2 250 CFA</span>
                                    <br>
                                    <em>Stripe</em>
                                </td>
                                <td>
                                    <div class="alert alert-warning alert-dismissible fade show">
                                        Client préfère les tresses box braids
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Terminée</span>
                                    <span
                                        class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">Annulée</span>
                                    <span
                                        class="bg-warning-focus text-warning-main px-24 py-4 rounded-pill fw-medium text-sm">En
                                        attente</span>
                                    <span
                                        class="bg-info-focus text-info-main px-24 py-4 rounded-pill fw-medium text-sm">Confirmée</span>
                                </td>
                                <td>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        Urgence familiale
                                        <br>
                                        Le 24/03/2024 à 16:30
                                        <br>
                                        par Client ou Coiffeuse
                                    </div>
                                    <div class="alert alert-success alert-dismissible fade show">
                                        5/5
                                        <br>
                                        "Excellent travail, très satisfaite!"
                                        <br>
                                        Terminé le 22/03/2024 à 18:00
                                    </div>
                                </td>
                            </tr>
                            @foreach ($reservations as $item)
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
