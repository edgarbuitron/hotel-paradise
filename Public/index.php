<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Paradise Cancún - Luxury Beach Resort</title>
    <?php include('../includes/cabecera.php'); ?>
</head>
<body>
    <?php include('../includes/menu_publico.php'); ?>

    <!-- Hero Section Mejorada -->
    <section class="hero-section position-relative overflow-hidden">
        <div class="container">
            <div class="row align-items-center min-vh-80">
                <div class="col-lg-6">
                    <div class="hero-content text-white">
                        <h1 class="hero-title fw-light mb-4">
                            Bienvenido al <span class="fw-bold">Paraíso</span>
                        </h1>
                        <p class="hero-subtitle lead mb-5">
                            Donde el azul del Caribe se encuentra con el lujo exclusivo. 
                            Vive una experiencia inolvidable en el corazón de Cancún.
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="reservar.php" class="btn btn-lg btn-warning fw-semibold px-4 py-3">
                                <i class="fas fa-calendar-check me-2"></i>Reservar Ahora
                            </a>
                            <a href="habitaciones.php" class="btn btn-lg btn-outline-light fw-semibold px-4 py-3">
                                <i class="fas fa-bed me-2"></i>Ver Habitaciones
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4">
            <a href="#habitaciones" class="text-white text-decoration-none">
                <div class="d-flex flex-column align-items-center">
                    <span class="small mb-2">Descubre más</span>
                    <i class="fas fa-chevron-down fa-bounce"></i>
                </div>
            </a>
        </div>
    </section>

    <!-- Sección de Características -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-umbrella-beach fa-3x text-primary"></i>
                    </div>
                    <h5 class="fw-bold">Playa Privada</h5>
                    <p class="text-muted">Acceso exclusivo a nuestra playa privada con servicio de hamacas y sombrillas</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-infinity fa-3x text-primary"></i>
                    </div>
                    <h5 class="fw-bold">Piscina Infinity</h5>
                    <p class="text-muted">Piscina con vista panorámica al mar Caribe y bar en la piscina</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-spa fa-3x text-primary"></i>
                    </div>
                    <h5 class="fw-bold">Spa & Wellness</h5>
                    <p class="text-muted">Tratamientos de lujo y experiencias de relajación únicas</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Habitaciones -->
    <section id="habitaciones" class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="fw-bold text-primary mb-3">Nuestras Habitaciones</h2>
                    <p class="lead text-muted">Diseñadas para tu máximo confort con vista al mar Caribe</p>
                </div>
            </div>

            <div class="row g-4">
                <?php
                require_once('../includes/Habitacion.php');
                $habitacionObj = new Habitacion();
                $habitaciones = $habitacionObj->consultar("estado='Disponible' LIMIT 3");

                if (count($habitaciones) > 0) {
                    foreach ($habitaciones as $h) {
                        $imagenesHabitaciones = [
                            'Individual' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                            'Doble' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                            'Suite' => 'https://images.unsplash.com/photo-1582719478254-c79a8dc4ad0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                            'Familiar' => 'https://images.unsplash.com/photo-1566665797739-1674de10a4d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'
                        ];
                        
                        $imagenDefault = 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80';
                        $imagenHabitacion = $imagenesHabitaciones[$h->tipo] ?? $imagenDefault;
                ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card room-card h-100 border-0 shadow-sm">
                        <img src="<?php echo $imagenHabitacion; ?>" 
                             class="card-img-top room-card-img" 
                             alt="Habitación <?php echo $h->tipo; ?>"
                             style="height: 250px; object-fit: cover;">
                        
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title fw-bold text-primary mb-0"><?php echo $h->tipo; ?></h5>
                                <span class="badge bg-success">Disponible</span>
                            </div>
                            
                            <div class="mb-3">
                                <span class="h4 fw-bold text-warning">$<?php echo number_format($h->precio, 2); ?></span>
                                <small class="text-muted">/noche</small>
                            </div>
                            
                            <ul class="list-unstyled mb-3">
                                <li class="mb-2">
                                    <i class="fas fa-users text-muted me-2"></i>
                                    <small>Capacidad: <?php echo $h->capacidad; ?> personas</small>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-eye text-muted me-2"></i>
                                    <small>Vista al Mar Caribe</small>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-wifi text-muted me-2"></i>
                                    <small>WiFi Premium</small>
                                </li>
                            </ul>
                            
                            <p class="card-text text-muted small flex-grow-1">
                                <?php echo $h->descripcion ?: 'Habitación de lujo con todas las comodidades para una estancia perfecta.'; ?>
                            </p>
                            
                            <div class="mt-auto">
                                <a href="reservar.php?habitacion_id=<?php echo $h->idHabitacion; ?>" 
                                   class="btn btn-primary w-100">
                                    <i class="fas fa-calendar-check me-2"></i>Reservar Ahora
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                } else {
                ?>
                <div class="col-12 text-center">
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle me-2"></i>
                        Próximamente disponibles nuevas habitaciones de lujo.
                    </div>
                </div>
                <?php } ?>
            </div>

            <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="habitaciones.php" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-bed me-2"></i>Ver Todas las Habitaciones
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Servicios Destacados -->
    <section class="py-5 bg-dark text-white">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="fw-bold mb-3">Servicios Exclusivos</h2>
                    <p class="lead opacity-75">Disfruta de experiencias únicas en nuestro resort</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-flex mb-3">
                            <i class="fas fa-utensils fa-2x text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Gastronomía</h5>
                        <p class="opacity-75">Restaurantes con cocina internacional y mariscos frescos</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-flex mb-3">
                            <i class="fas fa-swimming-pool fa-2x text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Piscinas</h5>
                        <p class="opacity-75">3 piscinas infinity con vistas espectaculares</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-flex mb-3">
                            <i class="fas fa-spa fa-2x text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Spa & Wellness</h5>
                        <p class="opacity-75">Tratamientos rejuvenecedores y temazal maya</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-flex mb-3">
                            <i class="fas fa-concierge-bell fa-2x text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Servicio 24/7</h5>
                        <p class="opacity-75">Concierge y room service disponible todo el día</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h3 class="fw-bold mb-2">¿Listo para tu escape perfecto?</h3>
                    <p class="mb-0 opacity-75">Reserva ahora y obtén un 10% de descuento en estadías de 5 noches o más</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="reservar.php" class="btn btn-warning btn-lg fw-semibold px-4">
                        <i class="fas fa-gift me-2"></i>Reservar con Oferta
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="public-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-umbrella-beach me-2"></i>Hotel Paradise Cancún
                    </h5>
                    <p class="opacity-75">Donde el Caribe se encuentra con el lujo. Experiencias inolvidables en el corazón de Cancún.</p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h6 class="fw-bold mb-3">Contacto</h6>
                    <p class="mb-2 opacity-75">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Blvd. Kukulcán KM 16.5, Zona Hotelera, Cancún
                    </p>
                    <p class="mb-2 opacity-75">
                        <i class="fas fa-phone me-2"></i>
                        +52 998 123 4567
                    </p>
                    <p class="mb-0 opacity-75">
                        <i class="fas fa-envelope me-2"></i>
                        info@hotelparadise.com
                    </p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h6 class="fw-bold mb-3">Enlaces Rápidos</h6>
                    <div class="row">
                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="habitaciones.php" class="text-decoration-none opacity-75">Habitaciones</a></li>
                                <li class="mb-2"><a href="servicios.php" class="text-decoration-none opacity-75">Servicios</a></li>
                                <li class="mb-2"><a href="reservar.php" class="text-decoration-none opacity-75">Reservar</a></li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="#" class="text-decoration-none opacity-75">Galería</a></li>
                                <li class="mb-2"><a href="#" class="text-decoration-none opacity-75">Contacto</a></li>
                                <li class="mb-2"><a href="#" class="text-decoration-none opacity-75">Aviso Legal</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="opacity-25">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-0 opacity-75">
                        &copy; <?php echo date("Y"); ?> Hotel Paradise Cancún. Todos los derechos reservados.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll para el indicador
        document.addEventListener('DOMContentLoaded', function() {
            const scrollLink = document.querySelector('a[href="#habitaciones"]');
            if (scrollLink) {
                scrollLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            }
        });
    </script>
</body>
</html>