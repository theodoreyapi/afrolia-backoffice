@extends('layouts.master', ['title' => 'Profil de la coiffeuse'])

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Profil de la coiffeuse</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ url('index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Tableau de bord
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium"><a href="{{ route('hair.index') }}" class="hover-text-primary">Coiffeuses</a></li>
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
                            <img src="{{ $hair->photo ? asset('storage/' . $hair->photo) : asset('assets/images/user-grid/user-grid-img14.png') }}"
                                alt=""
                                class="border br-white border-width-2-px w-200-px h-200-px rounded-circle object-fit-cover">
                            <h6 class="mb-0 mt-16">{{ $hair->name }} {{ $hair->last_name }}</h6>
                            <span class="text-secondary-light mb-16">{{ $hair->email ?? 'Aucun e-mail renseigné' }}</span>
                            <div class="mt-8">
                                @if ($hair->statut === 'Active')
                                    <span
                                        class="bg-success-focus text-success-main px-16 py-4 rounded-pill fw-medium text-sm">Active</span>
                                @else
                                    <span
                                        class="bg-danger-focus text-danger-main px-16 py-4 rounded-pill fw-medium text-sm">Suspendue</span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-24">
                            <h6 class="text-xl mb-16">Informations personnelles</h6>
                            <ul>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Nom complet</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $hair->name }}
                                        {{ $hair->last_name }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Téléphone</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $hair->phone }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Commune</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $hair->commune ?? '—' }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Adresse</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $hair->adresse ?? '—' }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Expérience</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $hair->experience ?? '—' }}
                                        an(s)</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Inscrite le</span>
                                    <span class="w-70 text-secondary-light fw-medium">:
                                        {{ $hair->created_at->format('d/m/Y') }}</span>
                                </li>
                                @if ($hair->presentation)
                                    <li class="d-flex align-items-start gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light">Présentation</span>
                                        <span class="w-70 text-secondary-light fw-medium">:
                                            {{ $hair->presentation }}</span>
                                    </li>
                                @endif
                                @if ($hair->statut !== 'Active' && $hair->raison_suspension)
                                    <li class="d-flex align-items-center gap-1">
                                        <span class="w-30 text-md fw-semibold text-primary-light">Raison</span>
                                        <span class="w-70 text-danger-main fw-medium">:
                                            {{ $hair->raison_suspension }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        {{-- ── Spécialités ─────────────────────────────────────── --}}
                        @if ($specialites->isNotEmpty())
                            <div class="mt-24">
                                <h6 class="text-xl mb-12">Spécialités</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($specialites as $s)
                                        <span
                                            class="bg-primary-focus text-primary-600 px-16 py-4 rounded-pill text-sm">{{ $s }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- ── Langues ─────────────────────────────────────────── --}}
                        @if ($langues->isNotEmpty())
                            <div class="mt-16">
                                <h6 class="text-xl mb-12">Langues parlées</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($langues as $l)
                                        <span
                                            class="bg-info-focus text-info-main px-16 py-4 rounded-pill text-sm">{{ $l }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- ── Méthodes de paiement acceptées ───────────────────── --}}
                        @if ($methodesPaiement->isNotEmpty())
                            <div class="mt-16">
                                <h6 class="text-xl mb-12">Paiements acceptés</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($methodesPaiement as $m)
                                        <span
                                            class="bg-success-focus text-success-main px-16 py-4 rounded-pill text-sm">{{ $m }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- ── Réseaux sociaux ───────────────────────────────────── --}}
                        @if ($sociaux)
                            <div class="mt-16">
                                <h6 class="text-xl mb-12">Réseaux sociaux</h6>
                                <div class="d-flex gap-3">
                                    @if ($sociaux->instagram)
                                        <a href="{{ $sociaux->instagram }}" target="_blank"
                                            class="text-primary-600"><iconify-icon icon="mdi:instagram"
                                                class="text-2xl"></iconify-icon></a>
                                    @endif
                                    @if ($sociaux->facebook)
                                        <a href="{{ $sociaux->facebook }}" target="_blank"
                                            class="text-primary-600"><iconify-icon icon="mdi:facebook"
                                                class="text-2xl"></iconify-icon></a>
                                    @endif
                                    @if ($sociaux->whatsapp)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sociaux->whatsapp) }}"
                                            target="_blank" class="text-success-main"><iconify-icon icon="mdi:whatsapp"
                                                class="text-2xl"></iconify-icon></a>
                                    @endif
                                    @if ($sociaux->tiktok)
                                        <a href="{{ $sociaux->tiktok }}" target="_blank"
                                            class="text-primary-light"><iconify-icon icon="ic:baseline-tiktok"
                                                class="text-2xl"></iconify-icon></a>
                                    @endif
                                </div>
                            </div>
                        @endif

                        {{-- ── Statistiques ──────────────────────────────────────── --}}
                        <div class="mt-24">
                            <h6 class="text-xl mb-16">Statistiques</h6>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="border radius-8 p-16 text-center">
                                        <h6 class="mb-0 text-primary-600">{{ $hair->reservations_count }}</h6>
                                        <span class="text-secondary-light text-sm">Prestations réalisées</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border radius-8 p-16 text-center">
                                        <h6 class="mb-0 text-warning-main">
                                            {{ $avgRatingReceived ? number_format($avgRatingReceived, 1) : '—' }}
                                            @if ($avgRatingReceived)
                                                <iconify-icon icon="solar:star-bold"
                                                    class="text-warning-main"></iconify-icon>
                                            @endif
                                        </h6>
                                        <span class="text-secondary-light text-sm">Note moyenne</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border radius-8 p-16 text-center">
                                        <h6 class="mb-0 text-success-main">
                                            {{ number_format($gainsParStatut['disponible'] ?? 0, 0, ',', ' ') }} F</h6>
                                        <span class="text-secondary-light text-sm">Gains disponibles</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border radius-8 p-16 text-center">
                                        <h6 class="mb-0 text-info-main">
                                            {{ number_format($gainsParStatut['paye'] ?? 0, 0, ',', ' ') }} F</h6>
                                        <span class="text-secondary-light text-sm">Gains payés</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Contenu principal (onglets) ───────────────────────────────── --}}
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <ul class="nav border-gradient-tab nav-pills mb-20 d-inline-flex flex-wrap" id="pills-tab"
                            role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link d-flex align-items-center px-24 active" data-bs-toggle="pill"
                                    data-bs-target="#pills-services" type="button">
                                    Services ({{ $services->count() }})
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link d-flex align-items-center px-24" data-bs-toggle="pill"
                                    data-bs-target="#pills-reservations" type="button">
                                    Réservations ({{ $reservations->count() }})
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link d-flex align-items-center px-24" data-bs-toggle="pill"
                                    data-bs-target="#pills-avis" type="button">
                                    Avis reçus ({{ $reviews->count() }})
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link d-flex align-items-center px-24" data-bs-toggle="pill"
                                    data-bs-target="#pills-dispo" type="button">
                                    Disponibilités
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link d-flex align-items-center px-24" data-bs-toggle="pill"
                                    data-bs-target="#pills-galerie" type="button">
                                    Galerie ({{ $gallery->count() }})
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content">
                            {{-- ── Services ─────────────────────────────────────── --}}
                            <div class="tab-pane fade show active" id="pills-services" role="tabpanel">
                                @if ($services->isEmpty())
                                    <p class="text-secondary-light text-center py-40">Aucun service proposé.</p>
                                @else
                                    <div class="table-responsive scroll-sm">
                                        <table class="table bordered-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Spécialité</th>
                                                    <th>Prix</th>
                                                    <th>Durée</th>
                                                    <th>Commission</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($services as $s)
                                                    <tr>
                                                        <td>{{ $s->specialite_libelle }}</td>
                                                        <td>{{ number_format($s->prix, 0, ',', ' ') }} F</td>
                                                        <td>{{ $s->minute }} min</td>
                                                        <td>{{ number_format($s->commission, 0, ',', ' ') }} F</td>
                                                        <td>{{ $s->description ?? '—' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            {{-- ── Réservations ─────────────────────────────────── --}}
                            <div class="tab-pane fade" id="pills-reservations" role="tabpanel">
                                @if ($reservations->isEmpty())
                                    <p class="text-secondary-light text-center py-40">Aucune réservation pour cette
                                        coiffeuse.</p>
                                @else
                                    <div class="table-responsive scroll-sm">
                                        <table class="table bordered-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>N°</th>
                                                    <th>Client</th>
                                                    <th>Service</th>
                                                    <th>Date</th>
                                                    <th>Montant</th>
                                                    <th>Statut</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($reservations as $r)
                                                    <tr>
                                                        <td>{{ $r->numero_reservation }}</td>
                                                        <td>{{ $r->client_prenom }} {{ $r->client_nom }}</td>
                                                        <td>{{ $r->service_libelle }}</td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($r->date_reservation)->format('d/m/Y') }}
                                                            {{ \Carbon\Carbon::parse($r->heure_reservation)->format('H:i') }}
                                                        </td>
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
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            {{-- ── Avis reçus ───────────────────────────────────── --}}
                            <div class="tab-pane fade" id="pills-avis" role="tabpanel">
                                @if ($reviews->isEmpty())
                                    <p class="text-secondary-light text-center py-40">Cette coiffeuse n'a reçu aucun avis.
                                    </p>
                                @else
                                    @foreach ($reviews as $review)
                                        <div class="border radius-8 p-16 mb-12">
                                            <div class="d-flex align-items-center justify-content-between mb-8">
                                                <div>
                                                    <h6 class="mb-0 text-md">
                                                        @if ($review->is_anonymous)
                                                            Client anonyme
                                                        @else
                                                            {{ $review->client_prenom }} {{ $review->client_nom }}
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
                                                <p class="text-secondary-light mb-0">{{ $review->comment }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            {{-- ── Disponibilités ───────────────────────────────── --}}
                            <div class="tab-pane fade" id="pills-dispo" role="tabpanel">
                                @if ($disponibilites->isEmpty())
                                    <p class="text-secondary-light text-center py-40">Aucune disponibilité renseignée.</p>
                                @else
                                    @foreach ($disponibilites as $jour => $creneaux)
                                        <div class="mb-16">
                                            <h6 class="text-md mb-8">{{ $jour }}</h6>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach ($creneaux as $c)
                                                    <span
                                                        class="bg-primary-focus text-primary-600 px-16 py-4 rounded-pill text-sm">{{ $c->heure_libelle }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            {{-- ── Galerie ───────────────────────────────────────── --}}
                            <div class="tab-pane fade" id="pills-galerie" role="tabpanel">
                                @if ($gallery->isEmpty())
                                    <p class="text-secondary-light text-center py-40">Aucune photo dans la galerie.</p>
                                @else
                                    <div class="row g-3">
                                        @foreach ($gallery as $g)
                                            <div class="col-4">
                                                <img src="{{ asset('storage/' . $g->image) }}" alt=""
                                                    class="w-100 radius-8 object-fit-cover" style="height: 150px;">
                                                @if ($g->description)
                                                    <p class="text-secondary-light text-sm mt-4">{{ $g->description }}</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
