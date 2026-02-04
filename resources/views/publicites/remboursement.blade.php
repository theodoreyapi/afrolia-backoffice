@extends('layouts.master', ['title' => 'Remboursements'])

@push('scripts')
    <script>
        let table = new DataTable('#dataTable');
    </script>
@endpush

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Remboursements</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ url('/') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Tableau de bord
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Liste des Remboursements</li>
            </ul>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <p class="fw-medium text-primary-light mb-1">En attente</p>
                        <h6 class="mb-0 text-warning">{{ $attente }}</h6>
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
                                <th scope="col">Prix Service</th>
                                <th scope="col">Statut</th>
                                <th scope="col">Raison</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong>#AR001567</strong>
                                    <br>
                                    Demandé le 20/03/2024 à 10:30
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
                                    <h6 style="color: red">17 250 CFA</h6>
                                    <em>Stripe</em>
                                </td>
                                <td>
                                    <span
                                        class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Traité</span>
                                    <span
                                        class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">Rejeté</span>
                                    <span
                                        class="bg-warning-focus text-warning-main px-24 py-4 rounded-pill fw-medium text-sm">En
                                        attente</span>
                                </td>
                                <td>
                                    <div class="alert alert-dark alert-dismissible fade show">
                                        Urgence familiale
                                        <br>
                                        Le 24/03/2024 à 16:30
                                        <br>
                                        par Client ou Coiffeuse
                                    </div>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" title="Traiter"
                                            class="btn bg-success-focus text-success-main d-inline-flex align-items-center justify-content-center"
                                            data-bs-toggle="modal" data-bs-target="#reactivateModal">
                                            <iconify-icon icon="lucide:check"></iconify-icon> Traiter
                                        </a>
                                        <div class="modal fade" id="reactivateModal" tabindex="-1"
                                            aria-labelledby="reactivateModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog modal-dialog-centered">
                                                <div class="modal-content radius-16 bg-base">
                                                    <div
                                                        class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0 bg-success-600">
                                                        <h1 class="modal-title fs-5 text-white" id="reactivateModalLabel">
                                                            Traiter
                                                        </h1>
                                                        <button type="button" class="btn-close"
                                                            style="background-color: white" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-24">
                                                        <form action="#">
                                                            <div class="row">
                                                                <p>
                                                                    Êtes-vous sûr de vouloir traiter ce remboursement ?
                                                                </p>
                                                                <div
                                                                    class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                                                    <button type="reset" data-bs-dismiss="modal"
                                                                        aria-label="Close"
                                                                        class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-50 py-11 radius-8">
                                                                        Annuler
                                                                    </button>
                                                                    <button type="submit"
                                                                        class="btn btn-success border border-success-600 text-md px-50 py-12 radius-8">
                                                                        Oui, Traiter
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0)" title="Rejeter"
                                            class="btn bg-danger-focus text-danger-main d-inline-flex align-items-center justify-content-center"
                                            data-bs-toggle="modal" data-bs-target="#suspendModal">
                                            <iconify-icon icon="lucide:x"></iconify-icon> Rejeter
                                        </a>
                                        <div class="modal fade" id="suspendModal" tabindex="-1"
                                            aria-labelledby="suspendModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog modal-dialog-centered">
                                                <div class="modal-content radius-16 bg-base">
                                                    <div
                                                        class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0 bg-danger-600">
                                                        <h1 class="modal-title fs-5 text-white" id="suspendModalLabel">
                                                            Rejeter
                                                        </h1>
                                                        <button type="button" class="btn-close"
                                                            style="background-color: white" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-24">
                                                        <form action="#">
                                                            <div class="row">
                                                                <p>
                                                                    Êtes-vous sûr de vouloir rejeter ce remboursement ?
                                                                </p>
                                                                <div
                                                                    class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                                                    <button type="reset" data-bs-dismiss="modal"
                                                                        aria-label="Close"
                                                                        class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-50 py-11 radius-8">
                                                                        Annuler
                                                                    </button>
                                                                    <button type="submit"
                                                                        class="btn btn-danger border border-danger-600 text-md px-50 py-12 radius-8">
                                                                        Oui, Rejeter
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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
