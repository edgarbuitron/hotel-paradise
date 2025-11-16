<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - Hotel Paradise Cancún</title>
    <?php include('../includes/cabecera.php'); ?>
</head>
<body>
    <?php include('../includes/menu_publico.php'); ?>

    <!-- Hero Section -->
    <section class="hero-section" style="background: linear-gradient(135deg, rgba(42, 157, 143, 0.8), rgba(138, 201, 38, 0.8)), url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Servicios & Amenities</h1>
                <p class="hero-subtitle">Descubre todo lo que tenemos para ofrecerte</p>
            </div>
        </div>
    </section>

    <!-- Servicios Principales -->
    <div class="container my-5">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="services-title">Servicios de Lujo</h2>
                <p class="services-subtitle">Diseñados para tu máximo confort y bienestar</p>
            </div>
        </div>

        <div class="row">
            <!-- Spa -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card service-card h-100">
                    <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                         class="card-img-top" alt="Spa Caribeño" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-spa me-2 text-primary"></i>Spa "Caribe Wellness"</h5>
                        <p class="card-text">Tratamientos rejuvenecedores con ingredientes naturales del Caribe. Masajes, faciales y experiencias de temazal maya.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Masajes terapéuticos</li>
                            <li><i class="fas fa-check text-success me-2"></i>Tratamientos faciales</li>
                            <li><i class="fas fa-check text-success me-2"></i>Experiencia temazal</li>
                            <li><i class="fas fa-check text-success me-2"></i>Yoga al amanecer</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Piscinas -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card service-card h-100">
                    <img src="https://images.unsplash.com/photo-1575429198097-0414ec08e8cd?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                         class="card-img-top" alt="Piscina Infinity" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-infinity me-2 text-primary"></i>Piscinas Infinity</h5>
                        <p class="card-text">Tres piscinas conectadas con cascadas, bar en el agua y camas balinesas. Vista panorámica al Mar Caribe.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Piscina principal infinity</li>
                            <li><i class="fas fa-check text-success me-2"></i>Piscina familiar</li>
                            <li><i class="fas fa-check text-success me-2"></i>Jacuzzis climatizados</li>
                            <li><i class="fas fa-check text-success me-2"></i>Bar en la piscina</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Restaurante -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card service-card h-100">
                    <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                         class="card-img-top" alt="Restaurante" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-utensils me-2 text-primary"></i>Gastronomía</h5>
                        <p class="card-text">Restaurante "La Concha" con cocina caribeña contemporánea y bar "La Palapa" con cócteles tropicales.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Cocina caribeña fusion</li>
                            <li><i class="fas fa-check text-success me-2"></i>Mariscos frescos del día</li>
                            <li><i class="fas fa-check text-success me-2"></i>Bar con vista al mar</li>
                            <li><i class="fas fa-check text-success me-2"></i>Room service 24/7</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Más Servicios -->
        <div class="row mt-5">
            <div class="col-12 text-center mb-5">
                <h3 class="services-title">Más Amenities</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 text-center mb-4">
                <div class="service-circle">
                    <i class="fas fa-dumbbell service-icon"></i>
                </div>
                <h5>Gimnasio</h5>
                <p>Equipo de última generación con vista al mar</p>
            </div>
            <div class="col-md-3 text-center mb-4">
                <div class="service-circle">
                    <i class="fas fa-wifi service-icon"></i>
                </div>
                <h5>WiFi Premium</h5>
                <p>Internet de alta velocidad en todas las áreas</p>
            </div>
            <div class="col-md-3 text-center mb-4">
                <div class="service-circle">
                    <i class="fas fa-car service-icon"></i>
                </div>
                <h5>Valet Parking</h5>
                <p>Estacionamiento con servicio de valet</p>
            </div>
            <div class="col-md-3 text-center mb-4">
                <div class="service-circle">
                    <i class="fas fa-concierge-bell service-icon"></i>
                </div>
                <h5>Concierge</h5>
                <p>Asistencia personalizada 24 horas</p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <section class="welcome-section">
        <div class="container text-center">
            <h2 class="welcome-title">¿Listo para tu Escape Caribeño?</h2>
            <p class="welcome-subtitle mb-4">Reserva ahora y vive la experiencia Paradise</p>
            <a href="reservar.php" class="cta-button">
                <i class="fas fa-calendar-check me-2"></i>Reservar Ahora
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="public-footer">
        <div class="container text-center">
            <p class="mb-1">&copy; <?php echo date("Y"); ?> Hotel Paradise Cancún. Todos los derechos reservados.</p>
            <p class="mb-0">
                <strong>Reservaciones:</strong> +52 998 123 4567 | 
                <a href="contacto.php">Contacto</a> | 
                <a href="aviso_privacidad.php">Aviso de Privacidad</a>
            </p>
        </div>
    </footer>
</body>
</html>