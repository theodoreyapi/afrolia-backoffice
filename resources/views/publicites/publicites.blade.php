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
                                <th scope="col">Coiffeuse</th>
                                <th scope="col">Prix Service</th>
                                <th scope="col">Statut</th>
                                <th scope="col">Raison</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong>#OM240318001</strong>
                                    <br>
                                    18/03/2024 • Stripe
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
                                    <h6 style="color: red">38 000 CFA</h6>
                                    <em style="color: green">Commission : 5 700 CFA</em>
                                </td>
                                <td>
                                    <span
                                        class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Terminé</span>
                                    <span
                                        class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">Échoué</span>
                                </td>
                                <td>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        Échec: Compte inactif
                                    </div>
                                </td>
                            </tr>
                            @foreach ($remboursement as $item)
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
