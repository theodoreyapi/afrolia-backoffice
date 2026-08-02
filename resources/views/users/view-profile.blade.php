@extends('layouts.master', ['title' => 'Profil du client'])

@push('scripts')
    <script>
        function initializePasswordToggle(toggleSelector) {
            $(toggleSelector).on('click', function() {
                $(this).toggleClass("ri-eye-off-line");
                var input = $($(this).attr("data-toggle"));
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
        }
        initializePasswordToggle('.toggle-password');
    </script>
@endpush

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Profil du client</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ url('index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Tableau de bord
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="{{ route('users.index') }}" class="hover-text-primary">Clients</a>
                </li>
                <li>-</li>
                <li class="fw-medium">Profil</li>
            </ul>
        </div>

        <div class="row gy-4">
            {{-- ── Carte identité ────────────────────────────────────────── --}}
            <div class="col-lg-4">
                <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                    <img src="{{ asset('assets/images/user-grid/user-grid-bg1.png') }}" alt=""
                        class="w-100 object-fit-cover">
                    <div class="pb-24 ms-16 mb-24 me-16 mt--100">
                        <div class="text-center border border-top-0 border-start-0 border-end-0">
                            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('assets/images/user-grid/user-grid-img14.png') }}"
                                alt=""
                                class="border br-white border-width-2-px w-200-px h-200-px rounded-circle object-fit-cover">
                            <h6 class="mb-0 mt-16">{{ $user->last_name }} {{ $user->name }}</h6>
                            <span class="text-secondary-light mb-16">{{ $user->email ?? 'Aucun e-mail renseigné' }}</span>
                            <div class="mt-8">
                                @if ($user->statut === 'Active')
                                    <span
                                        class="bg-success-focus text-success-main px-16 py-4 rounded-pill fw-medium text-sm">Active</span>
                                @else
                                    <span
                                        class="bg-danger-focus text-danger-main px-16 py-4 rounded-pill fw-medium text-sm">Suspendu</span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-24">
                            <h6 class="text-xl mb-16">Informations personnelles</h6>
                            <ul>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Nom complet</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $user->last_name }}
                                        {{ $user->name }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">E-mail</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $user->email ?? '—' }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Téléphone</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $user->phone }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Commune</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $user->commune ?? '—' }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Adresse</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $user->adresse ?? '—' }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Inscrit le</span>
                                    <span class="w-70 text-secondary-light fw-medium">:
                                        {{ $user->created_at->format('d/m/Y') }}</span>
                                </li>
                                @if ($user->statut !== 'Active' && $user->raison_suspension)
                                    <li class="d-flex align-items-center gap-1">
                                        <span class="w-30 text-md fw-semibold text-primary-light">Raison</span>
                                        <span class="w-70 text-danger-main fw-medium">:
                                            {{ $user->raison_suspension }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        {{-- ── Statistiques rapides ──────────────────────────────── --}}
                        <div class="mt-24">
                            <h6 class="text-xl mb-16">Statistiques</h6>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="border radius-8 p-16 text-center">
                                        <h6 class="mb-0 text-primary-600">{{ $user->reservations_count }}</h6>
                                        <span class="text-secondary-light text-sm">Réservations</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border radius-8 p-16 text-center">
                                        <h6 class="mb-0 text-success-main">
                                            {{ number_format($user->total_depenses ?? 0, 0, ',', ' ') }} F</h6>
                                        <span class="text-secondary-light text-sm">Dépensé</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border radius-8 p-16 text-center">
                                        <h6 class="mb-0 text-warning-main">
                                            {{ $avgRatingGiven ? number_format($avgRatingGiven, 1) : '—' }}
                                            @if ($avgRatingGiven)
                                                <iconify-icon icon="solar:star-bold"
                                                    class="text-warning-main"></iconify-icon>
                                            @endif
                                        </h6>
                                        <span class="text-secondary-light text-sm">Note moy. donnée</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border radius-8 p-16 text-center">
                                        <h6 class="mb-0 text-danger-main">{{ $favoritesCount }}</h6>
                                        <span class="text-secondary-light text-sm">Favoris</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Onglets : réservations / avis ────────────────────────────── --}}
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <ul class="nav border-gradient-tab nav-pills mb-20 d-inline-flex" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link d-flex align-items-center px-24 active" id="pills-reservations-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-reservations" type="button" role="tab"
                                    aria-controls="pills-reservations" aria-selected="true">
                                    Réservations ({{ $reservations->count() }})
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link d-flex align-items-center px-24" id="pills-avis-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-avis" type="button" role="tab"
                                    aria-controls="pills-avis" aria-selected="false" tabindex="-1">
                                    Avis laissés ({{ $reviews->count() }})
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            {{-- ── Réservations ────────────────────────────────── --}}
                            <div class="tab-pane fade show active" id="pills-reservations" role="tabpanel"
                                aria-labelledby="pills-reservations-tab" tabindex="0">
                                @if ($reservations->isEmpty())
                                    <p class="text-secondary-light text-center py-40">Aucune réservation pour ce client.
                                    </p>
                                @else
                                    <div class="table-responsive scroll-sm">
                                        <table class="table bordered-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>N° réservation</th>
                                                    <th>Coiffeur</th>
                                                    <th>Service</th>
                                                    <th>Date</th>
                                                    <th>Prix service</th>
                                                    <th>Montant</th>
                                                    <th>Statut</th>
                                                    <th>Paiement</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($reservations as $r)
                                                    <tr>
                                                        <td>{{ $r->numero_reservation }}</td>
                                                        <td>{{ $r->coiffeur_prenom }} {{ $r->coiffeur_nom }}</td>
                                                        <td>
                                                            {{ $r->service_libelle }}
                                                            <br>
                                                            <span
                                                                class="text-secondary-light text-sm">{{ $r->service_duree }}
                                                                min</span>
                                                        </td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($r->date_reservation)->format('d/m/Y') }}
                                                            {{ \Carbon\Carbon::parse($r->heure_reservation)->format('H:i') }}
                                                        </td>
                                                        <td>{{ number_format($r->service_prix, 0, ',', ' ') }} F</td>
                                                        <td>{{ number_format($r->montant_total, 0, ',', ' ') }} F</td>
                                                        <td>
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
                                                                class="bg-{{ $color }}-focus text-{{ $color }}-main px-16 py-4 rounded-pill fw-medium text-sm">
                                                                {{ ucfirst(str_replace('_', ' ', $r->statut)) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @if ($r->statut_paiement === 'paye')
                                                                <span
                                                                    class="bg-success-focus text-success-main px-16 py-4 rounded-pill fw-medium text-sm">Payé</span>
                                                            @elseif($r->statut_paiement === 'echoue')
                                                                <span
                                                                    class="bg-danger-focus text-danger-main px-16 py-4 rounded-pill fw-medium text-sm">Échoué</span>
                                                            @elseif($r->statut_paiement === 'rembourse')
                                                                <span
                                                                    class="bg-info-focus text-info-main px-16 py-4 rounded-pill fw-medium text-sm">Remboursé</span>
                                                            @else
                                                                <span
                                                                    class="bg-warning-focus text-warning-main px-16 py-4 rounded-pill fw-medium text-sm">En
                                                                    attente</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            {{-- ── Avis laissés ────────────────────────────────── --}}
                            <div class="tab-pane fade" id="pills-avis" role="tabpanel" aria-labelledby="pills-avis-tab"
                                tabindex="0">
                                @if ($reviews->isEmpty())
                                    <p class="text-secondary-light text-center py-40">Ce client n'a laissé aucun avis.</p>
                                @else
                                    @foreach ($reviews as $review)
                                        <div class="border radius-8 p-16 mb-12">
                                            <div class="d-flex align-items-center justify-content-between mb-8">
                                                <div>
                                                    <h6 class="mb-0 text-md">
                                                        @if ($review->is_anonymous)
                                                            Avis anonyme
                                                        @else
                                                            Pour {{ $review->stylist_prenom }} {{ $review->stylist_nom }}
                                                        @endif
                                                    </h6>
                                                    <span
                                                        class="text-secondary-light text-sm">{{ \Carbon\Carbon::parse($review->created_at)->format('d/m/Y') }}</span>
                                                </div>
                                                <div>
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <iconify-icon
                                                            icon="{{ $i <= $review->rating ? 'solar:star-bold' : 'solar:star-outline' }}"
                                                            class="text-warning-main"></iconify-icon>
                                                    @endfor
                                                </div>
                                            </div>
                                            @if ($review->comment)
                                                <p class="text-secondary-light mb-8">{{ $review->comment }}</p>
                                            @endif
                                            <div class="d-flex gap-2">
                                                @if ($review->status === 'approved')
                                                    <span
                                                        class="bg-success-focus text-success-main px-12 py-2 rounded-pill text-xs fw-medium">Approuvé</span>
                                                @elseif($review->status === 'pending')
                                                    <span
                                                        class="bg-warning-focus text-warning-main px-12 py-2 rounded-pill text-xs fw-medium">En
                                                        attente</span>
                                                @else
                                                    <span
                                                        class="bg-danger-focus text-danger-main px-12 py-2 rounded-pill text-xs fw-medium">Rejeté</span>
                                                @endif
                                                @if ($review->is_verified)
                                                    <span
                                                        class="bg-info-focus text-info-main px-12 py-2 rounded-pill text-xs fw-medium">Vérifié</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
