@extends('layouts.master', ['title' => 'Litiges & réclamations'])

@push('scripts')
    <script>
        let table = new DataTable('#dataTable');
    </script>
@endpush

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Litiges & réclamations</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium"><a href="{{ url('/') }}" class="hover-text-primary">Tableau de bord</a></li>
                <li>-</li>
                <li class="fw-medium">Litiges & réclamations</li>
            </ul>
        </div>

        <div class="row row-cols-lg-4 row-cols-2 gy-4 mb-24">
            <div class="col">
                <div class="card">
                    <div class="card-body p-20">
                        <p class="fw-medium text-primary-light mb-1">Ouverts</p>
                        <h6 class="mb-0 text-danger">{{ $ouverts }}</h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body p-20">
                        <p class="fw-medium text-primary-light mb-1">En cours</p>
                        <h6 class="mb-0 text-warning">{{ $enCours }}</h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body p-20">
                        <p class="fw-medium text-primary-light mb-1">Résolus</p>
                        <h6 class="mb-0 text-success">{{ $resolus }}</h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body p-20">
                        <p class="fw-medium text-primary-light mb-1">Rejetés</p>
                        <h6 class="mb-0 text-secondary">{{ $rejetes }}</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="card h-100 p-0 radius-12">
            <div class="card-body p-24">
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                        <thead>
                            <tr>
                                <th scope="col">Réservation</th>
                                <th scope="col">Plaignant</th>
                                <th scope="col">Type</th>
                                <th scope="col">Description</th>
                                <th scope="col">Statut</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($litiges as $item)
                                <tr>
                                    <td>
                                        <strong>#{{ $item->numero_reservation }}</strong>
                                        <br>
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y à H:i') }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img height="48" width="48"
                                                src="{{ $item->plaignant_photo ? asset('storage/' . $item->plaignant_photo) : asset('assets/images/user-default.png') }}"
                                                alt="" class="flex-shrink-0 me-12 radius-8">
                                            <h6 class="text-md mb-0 fw-medium">
                                                {{ $item->plaignant_prenom }} {{ $item->plaignant_nom }}
                                                <br>
                                                <span
                                                    class="text-sm text-secondary-light">{{ $item->plaignant_phone }}</span>
                                            </h6>
                                        </div>
                                    </td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $item->type)) }}</td>
                                    <td style="max-width: 250px;">{{ Str::limit($item->description, 100) }}</td>
                                    <td>
                                        @php
                                            $colors = [
                                                'ouvert' => 'danger',
                                                'en_cours' => 'warning',
                                                'resolu' => 'success',
                                                'rejete' => 'secondary',
                                            ];
                                            $labels = [
                                                'ouvert' => 'Ouvert',
                                                'en_cours' => 'En cours',
                                                'resolu' => 'Résolu',
                                                'rejete' => 'Rejeté',
                                            ];
                                            $color = $colors[$item->statut] ?? 'secondary';
                                        @endphp
                                        <span
                                            class="bg-{{ $color }}-focus text-{{ $color }}-main px-24 py-4 rounded-pill fw-medium text-sm">
                                            {{ $labels[$item->statut] }}
                                        </span>
                                    </td>
                                    <td>
                                        @if (in_array($item->statut, ['ouvert', 'en_cours']))
                                            @if ($item->statut === 'ouvert')
                                                <form action="{{ route('litiges.en-cours', $item->id_litige) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn bg-info-focus text-info-main btn-sm">Prendre en
                                                        charge</button>
                                                </form>
                                            @endif
                                            <a href="javascript:void(0)"
                                                class="btn bg-success-focus text-success-main btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#resoudreModal{{ $item->id_litige }}">Résoudre</a>
                                            <a href="javascript:void(0)" class="btn bg-danger-focus text-danger-main btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#rejeterModal{{ $item->id_litige }}">Rejeter</a>

                                            <div class="modal fade" id="resoudreModal{{ $item->id_litige }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content radius-16 bg-base">
                                                        <div class="modal-header py-16 px-24 bg-success-600">
                                                            <h1 class="modal-title fs-5 text-white">Résoudre le litige</h1>
                                                            <button type="button" class="btn-close"
                                                                style="background-color:white"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body p-24">
                                                            <form
                                                                action="{{ route('litiges.resoudre', $item->id_litige) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="mb-20">
                                                                    <label class="form-label fw-semibold">Résolution
                                                                        apportée <strong
                                                                            style="color:red">*</strong></label>
                                                                    <textarea name="resolution" required class="form-control radius-8" rows="4"></textarea>
                                                                </div>
                                                                <div class="d-flex justify-content-center gap-3 mt-24">
                                                                    <button type="reset" data-bs-dismiss="modal"
                                                                        class="border border-danger-600 text-danger-600 px-40 py-11 radius-8">Annuler</button>
                                                                    <button type="submit"
                                                                        class="btn btn-success px-40 py-11 radius-8">Confirmer</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="rejeterModal{{ $item->id_litige }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content radius-16 bg-base">
                                                        <div class="modal-header py-16 px-24 bg-danger-600">
                                                            <h1 class="modal-title fs-5 text-white">Rejeter le litige</h1>
                                                            <button type="button" class="btn-close"
                                                                style="background-color:white"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body p-24">
                                                            <form
                                                                action="{{ route('litiges.rejeter', $item->id_litige) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="mb-20">
                                                                    <label class="form-label fw-semibold">Raison du rejet
                                                                        <strong style="color:red">*</strong></label>
                                                                    <textarea name="resolution" required class="form-control radius-8" rows="4"></textarea>
                                                                </div>
                                                                <div class="d-flex justify-content-center gap-3 mt-24">
                                                                    <button type="reset" data-bs-dismiss="modal"
                                                                        class="border border-danger-600 text-danger-600 px-40 py-11 radius-8">Annuler</button>
                                                                    <button type="submit"
                                                                        class="btn btn-danger px-40 py-11 radius-8">Confirmer</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span
                                                class="text-secondary-light text-sm">{{ $item->resolution ? Str::limit($item->resolution, 40) : '—' }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-40 text-secondary-light">Aucun litige
                                        enregistré.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
