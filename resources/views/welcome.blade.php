<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afrolia - La coiffure Afro à portée de main</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">
</head>

<body>

    <header class="hero-section d-flex align-items-center text-white">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-6 col-md-8">
                    <p class="brand-text mb-2"><span class="star-icon me-2">✨</span>Afrolia</p>

                    <h1 class="display-3 fw-bold mb-3">
                        La coiffure Afro <span class="highlight-text">à portée de main</span>
                    </h1>

                    <p class="lead mb-4 description-text">
                        Trouvez les meilleures coiffeuses près de chez vous. Réservez en quelques clics.
                    </p>

                    <div class="d-flex mb-4">
                        <button class="btn btn-lang active me-2">Français</button>
                        <button class="btn btn-lang">English</button>
                    </div>

                    <div class="d-flex mb-5">
                        <button class="btn btn-primary btn-action me-3">S'inscrire</button>
                        <button class="btn btn-outline-light btn-connect">Se connecter</button>
                    </div>

                    <div class="d-flex stats-row">
                        <div class="me-4 stat-item">
                            <p class="stat-number">500+</p>
                            <p class="stat-label">Coiffeuses</p>
                        </div>
                        <div class="me-4 stat-item">
                            <p class="stat-number">10K+</p>
                            <p class="stat-label">Réservations</p>
                        </div>
                        <div class="stat-item">
                            <p class="stat-number">4.8<span class="star-icon">★</span></p>
                            <p class="stat-label">Note moyenne</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="how-it-works-section py-5 my-5">
        <div class="container">

            <!-- Titre principal -->
            <div class="text-center mb-5">
                <p class="tagline text-uppercase fw-semibold mb-2">Facile, rapide, efficace</p>
                <h2 class="display-6 fw-bold text-dark mb-3">Comment ça marche ?</h2>
                <p class="lead-subtitle">
                    Réserver votre coiffeuse n’a jamais été aussi simple avec <span
                        class="highlight-text">Afrolia</span>.
                </p>
            </div>

            <!-- Étapes -->
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="step-card p-4 text-center h-100 position-relative">
                        <span class="step-number">1</span>
                        <div class="icon-box mb-3 mx-auto">
                            <span class="icon-placeholder">🔍</span>
                        </div>
                        <h3 class="step-title fw-bold">Trouvez votre coiffeuse</h3>
                        <p class="step-description">
                            Parcourez les profils, découvrez les spécialités, tarifs et avis des coiffeuses autour de
                            vous.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="step-card p-4 text-center h-100 position-relative">
                        <span class="step-number">2</span>
                        <div class="icon-box mb-3 mx-auto">
                            <span class="icon-placeholder">🗓️</span>
                        </div>
                        <h3 class="step-title fw-bold">Réservez en ligne</h3>
                        <p class="step-description">
                            Choisissez un créneau disponible et réservez votre rendez-vous en quelques clics.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="step-card p-4 text-center h-100 position-relative">
                        <span class="step-number">3</span>
                        <div class="icon-box mb-3 mx-auto">
                            <span class="icon-placeholder">⭐</span>
                        </div>
                        <h3 class="step-title fw-bold">Profitez et notez</h3>
                        <p class="step-description">
                            Profitez d’une coiffure parfaite, puis laissez votre avis pour aider d’autres clientes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="develop-activity-section py-5 my-5">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="image-stats-card p-3 shadow-lg">
                        <div class="image-container-activity mb-3">
                            <img src="{{ URL::asset('assets/images/coiffeuse.jpg') }}" alt="Coiffeuse professionnelle"
                                class="img-fluid rounded-top-lg">
                        </div>

                        <div class="stats-bar row text-center">
                            <div class="col-4">
                                <p class="stat-large">+40%</p>
                                <p class="stat-small">Revenus</p>
                            </div>
                            <div class="col-4 border-start border-end border-white-50">
                                <p class="stat-large">85%</p>
                                <p class="stat-small">Taux de remplissage</p>
                            </div>
                            <div class="col-4">
                                <p class="stat-large">4.8<span class="star-icon">★</span></p>
                                <p class="stat-small">Satisfaction</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 ps-lg-5">
                    <p class="tagline-coiffeuse text-uppercase mb-2">Pour les coiffeuses</p>

                    <h2 class="display-5 fw-bold mb-3">
                        Développez votre activité <br><span class="highlight-text">avec Afrolia</span>
                    </h2>
                    <p class="lead-text mb-4">
                        Rejoignez notre communauté de coiffeuses professionnelles et boostez vos revenus
                    </p>

                    <div class="benefits-grid row g-4 mb-4">

                        <div class="col-sm-6 d-flex">
                            <span class="benefit-icon me-3">🗓️</span>
                            <div>
                                <p class="benefit-title fw-bold mb-0">Gestion simplifiée</p>
                                <p class="benefit-description mb-0">Gérez vos disponibilités et réservations en temps
                                    réel</p>
                            </div>
                        </div>

                        <div class="col-sm-6 d-flex">
                            <span class="benefit-icon me-3">🧑🏽‍🦱</span>
                            <div>
                                <p class="benefit-title fw-bold mb-0">Nouvelle clientèle</p>
                                <p class="benefit-description mb-0">Accédez à des milliers de clientes potentielles</p>
                            </div>
                        </div>

                        <div class="col-sm-6 d-flex">
                            <span class="benefit-icon me-3">💳</span>
                            <div>
                                <p class="benefit-title fw-bold mb-0">Paiements sécurisés</p>
                                <p class="benefit-description mb-0">Recevez vos paiements rapidement et en toute
                                    sécurité</p>
                            </div>
                        </div>

                        <div class="col-sm-6 d-flex">
                            <span class="benefit-icon me-3">📈</span>
                            <div>
                                <p class="benefit-title fw-bold mb-0">Développez votre activité</p>
                                <p class="benefit-description mb-0">Statistiques et outils pour optimiser vos revenus
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <button class="btn btn-action me-3">Devenir coiffeuse partenaire</button>
                        <button class="btn btn-outline-secondary btn-connect">En savoir plus</button>
                    </div>

                    <p class="footer-note-activity mt-3">
                        <span class="fw-bold">*</span> Commission de seulement 15% • Paiements sous 48h
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="find-stylist-section py-5 my-5">
        <div class="container">
            <div class="row align-items-center">

                <!-- LEFT TEXT SECTION -->
                <div class="col-lg-6 mb-5 mb-lg-0 pe-lg-5">
                    <p class="tagline-clientele text-uppercase mb-3">Pour les clientes</p>

                    <h2 class="display-5 fw-bold mb-3">
                        Trouvez la coiffeuse <span class="highlight-text">parfaite</span> pour vous
                    </h2>
                    <p class="lead-text mb-4">
                        Des centaines de coiffeuses talentueuses vous attendent. Réservez votre rendez-vous en toute
                        simplicité.
                    </p>

                    <div class="benefits-list mb-5">

                        <div class="benefit-item d-flex mb-3">
                            <div class="benefit-icon me-3">
                                <span>📍</span>
                            </div>
                            <div>
                                <p class="benefit-title fw-bold mb-0">Coiffeuses près de chez vous</p>
                                <p class="benefit-description mb-0">Trouvez facilement des professionnelles dans votre
                                    quartier</p>
                            </div>
                        </div>

                        <div class="benefit-item d-flex mb-3">
                            <div class="benefit-icon me-3">
                                <span>🕐</span>
                            </div>
                            <div>
                                <p class="benefit-title fw-bold mb-0">Réservation instantanée</p>
                                <p class="benefit-description mb-0">Prenez rendez-vous 24h/24, 7j/7 en quelques clics
                                </p>
                            </div>
                        </div>

                        <div class="benefit-item d-flex mb-3">
                            <div class="benefit-icon me-3">
                                <span>💳</span>
                            </div>
                            <div>
                                <p class="benefit-title fw-bold mb-0">Paiement sécurisé</p>
                                <p class="benefit-description mb-0">Carte bancaire et mobile money acceptés</p>
                            </div>
                        </div>

                        <div class="benefit-item d-flex">
                            <div class="benefit-icon me-3">
                                <span>💖</span>
                            </div>
                            <div>
                                <p class="benefit-title fw-bold mb-0">Satisfaction garantie</p>
                                <p class="benefit-description mb-0">Notez et partagez votre expérience</p>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex flex-wrap">
                        <button class="btn btn-action me-3 mb-3">Trouver une coiffeuse</button>
                        <button class="btn btn-outline-secondary btn-how-it-works mb-3">Voir comment ça marche</button>
                    </div>
                </div>

                <!-- RIGHT IMAGE + TESTIMONIAL -->
                <div class="col-lg-6">
                    <div class="testimonial-card-container">
                        <img src="{{ URL::asset('assets/images/client.jpg') }}" alt="Cliente satisfaite"
                            class="img-fluid rounded-lg-custom">

                        <div class="testimonial-box p-3 p-md-4 shadow-sm">
                            <div class="d-flex align-items-start">
                                <span class="initials-circle me-3">JD</span>
                                <div>
                                    <p class="mb-1 fw-bold name-review">
                                        Jessica D. <span class="rating-star">★★★★★</span>
                                    </p>
                                    <p class="mb-0 review-text">
                                        "Service impeccable ! Ma coiffeuse était très professionnelle et le résultat est
                                        magnifique."
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section class="why-choose-section py-5 my-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-dark">
                    Pourquoi choisir <span class="highlight-text">Afrolia</span> ?
                </h2>
                <p class="lead-subtitle-why">
                    Une plateforme complète pensée pour vous offrir la meilleure expérience
                </p>
            </div>

            <div class="row justify-content-center g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="benefit-box p-4 h-100">
                        <div class="icon-box-small mb-3">
                            <span class="icon-placeholder-small">📱</span>
                        </div>
                        <h3 class="benefit-title-small">Application mobile</h3>
                        <p class="benefit-description-small">
                            Disponible sur iOS et Android pour réserver où que vous soyez
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="benefit-box p-4 h-100">
                        <div class="icon-box-small mb-3">
                            <span class="icon-placeholder-small">💳</span>
                        </div>
                        <h3 class="benefit-title-small">Paiements flexibles</h3>
                        <p class="benefit-description-small">
                            Carte bancaire, mobile money et autres moyens de paiement
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="benefit-box p-4 h-100">
                        <div class="icon-box-small mb-3">
                            <span class="icon-placeholder-small">💬</span>
                        </div>
                        <h3 class="benefit-title-small">Support client</h3>
                        <p class="benefit-description-small">
                            Notre équipe est là pour vous aider 7j/7
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="benefit-box p-4 h-100">
                        <div class="icon-box-small mb-3">
                            <span class="icon-placeholder-small">🔒</span>
                        </div>
                        <h3 class="benefit-title-small">Sécurité garantie</h3>
                        <p class="benefit-description-small">
                            Vos données et paiements sont protégés
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="benefit-box p-4 h-100">
                        <div class="icon-box-small mb-3">
                            <span class="icon-placeholder-small">⭐</span>
                        </div>
                        <h3 class="benefit-title-small">Avis vérifiés</h3>
                        <p class="benefit-description-small">
                            Consultez les notes et commentaires des autres clientes
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="benefit-box p-4 h-100">
                        <div class="icon-box-small mb-3">
                            <span class="icon-placeholder-small">⏰</span>
                        </div>
                        <h3 class="benefit-title-small">Disponibilité 24/7</h3>
                        <p class="benefit-description-small">
                            Réservez à tout moment, même en dehors des horaires d'ouverture
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <footer class="main-footer py-5">
        <div class="container">
            <div class="row gy-4">

                <div class="col-lg-4 col-md-12">
                    <p class="footer-brand"><span class="star-icon">✨</span>Afrolia</p>
                    <p class="footer-tagline">La coiffure Afro à portée de main</p>
                    <div class="social-icons d-flex mt-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>

                <div class="col-6 col-md-4 col-lg-2">
                    <h5 class="footer-heading">Pour les clientes</h5>
                    <ul class="footer-list list-unstyled mt-3">
                        <li><a href="#">Trouver une coiffeuse</a></li>
                        <li><a href="#">Comment ça marche</a></li>
                        <li><a href="#">Tarifs</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>

                <div class="col-6 col-md-4 col-lg-3">
                    <h5 class="footer-heading">Pour les coiffeuses</h5>
                    <ul class="footer-list list-unstyled mt-3">
                        <li><a href="#">Devenir partenaire</a></li>
                        <li><a href="#">Avantages</a></li>
                        <li><a href="#">Tarification</a></li>
                        <li><a href="#">Support pro</a></li>
                    </ul>
                </div>

                <div class="col-6 col-md-4 col-lg-3">
                    <h5 class="footer-heading">Entreprise</h5>
                    <ul class="footer-list list-unstyled mt-3">
                        <li><a href="#">À propos</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Carrières</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
            </div>

            <hr class="footer-divider my-4">

            <div class="row align-items-center">
                <div class="col-md-6 text-md-start text-center mb-2 mb-md-0">
                    <p class="copyright-text">© 2025 Afrolia. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-md-end text-center">
                    <p class="legal-links mb-0">
                        <a href="#">Mentions légales</a> •
                        <a href="#">Confidentialité</a> •
                        <a href="#">CGU</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK42wQeMybL7T6E/2t2F5P6L"
        crossorigin="anonymous"></script>
</body>

</html>
