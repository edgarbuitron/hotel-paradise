<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitaciones & Suites - Hotel Paradise Cancún</title>
    <?php include('../includes/cabecera.php'); ?>
</head>
<body>
    <?php include('../includes/menu_publico.php'); ?>

    <!-- Hero Section -->
    <section class="hero-section" style="background: linear-gradient(135deg, rgba(139, 115, 85, 0.9), rgba(168, 146, 122, 0.8)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');">
        <div class="container">
            <div class="row align-items-center min-vh-60">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="hero-title fw-light mb-4">
                        Nuestras <span class="fw-bold">Habitaciones</span>
                    </h1>
                    <p class="hero-subtitle lead mb-5">
                        Descubre nuestro exclusivo catálogo de habitaciones y suites, 
                        diseñadas para ofrecerte el máximo confort con vistas espectaculares al Mar Caribe.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Filtros -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tipo de Habitación</label>
                    <select id="filtroTipo" class="form-select">
                        <option value="todos">Todas las habitaciones</option>
                        <option value="Individual">Individual</option>
                        <option value="Doble">Doble</option>
                        <option value="Suite">Suite</option>
                        <option value="Familiar">Familiar</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Rango de Precio</label>
                    <select id="filtroPrecio" class="form-select">
                        <option value="todos">Todos los precios</option>
                        <option value="0-1500">$0 - $1,500 MXN</option>
                        <option value="1500-3000">$1,500 - $3,000 MXN</option>
                        <option value="3000-5000">$3,000 - $5,000 MXN</option>
                        <option value="5000-10000">$5,000 - $10,000 MXN</option>
                        <option value="10000+">Más de $10,000 MXN</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">&nbsp;</label>
                    <button id="btnFiltrar" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Aplicar Filtros
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Catálogo de Habitaciones -->
    <section class="py-5">
        <div class="container">
            <div class="row" id="gridHabitaciones">
                <?php
                require_once('../includes/Habitacion.php');
                $habitacionObj = new Habitacion();
                $habitaciones = $habitacionObj->consultar("estado='Disponible'");

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
                        
                        $descripciones = [
                            'Individual' => 'Ideal para viajeros solitarios. Cama king size, escritorio ergonómico, baño privado con amenities de lujo y balcón con vista al mar.',
                            'Doble' => 'Perfecta para parejas. Cama king size, área de estar, minibar, baño con jacuzzi y balcón privado con hamaca.',
                            'Suite' => 'Amplia suite con sala independiente, dormitorio separado, jacuzzi privado, cocineta y terraza con vista panorámica al Caribe.',
                            'Familiar' => 'Espaciosa habitación familiar con dos camas queen, área de juegos infantil, cocineta y conexión con habitaciones contiguas.'
                        ];
                        
                        $descripcion = $descripciones[$h->tipo] ?? 'Experimenta el máximo confort en esta exclusiva habitación con vista al mar Caribe.';
                ?>
                <div class="col-lg-4 col-md-6 mb-4 habitacion-item" data-tipo="<?php echo $h->tipo; ?>" data-precio="<?php echo $h->precio; ?>">
                    <div class="card room-card h-100 border-0 shadow-sm position-relative">
                        <!-- Badge de Estado -->
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i>Disponible
                            </span>
                        </div>
                        
                        <img src="<?php echo $imagenHabitacion; ?>" 
                             class="card-img-top room-card-img" 
                             alt="Habitación <?php echo $h->tipo; ?>"
                             style="height: 250px; object-fit: cover;">
                        
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title fw-bold text-primary mb-0">Habitación <?php echo $h->tipo; ?></h5>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
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
                                <li class="mb-2">
                                    <i class="fas fa-tv text-muted me-2"></i>
                                    <small>TV 4K Smart</small>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-snowflake text-muted me-2"></i>
                                    <small>Aire acondicionado</small>
                                </li>
                            </ul>
                            
                            <p class="card-text text-muted small flex-grow-1">
                                <?php echo $descripcion; ?>
                            </p>
                            
                            <div class="mt-auto">
                                <div class="d-grid gap-2">
                                    <a href="reservar.php?habitacion_id=<?php echo $h->idHabitacion; ?>" 
                                       class="btn btn-primary">
                                        <i class="fas fa-calendar-check me-2"></i>Reservar Ahora
                                    </a>
                                    <button type="button" class="btn btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalHabitacion<?php echo $h->idHabitacion; ?>">
                                        <i class="fas fa-info-circle me-2"></i>Más Información
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para más información -->
                <div class="modal fade" id="modalHabitacion<?php echo $h->idHabitacion; ?>" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">Habitación <?php echo $h->tipo; ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="<?php echo $imagenHabitacion; ?>" 
                                             class="img-fluid rounded" 
                                             alt="Habitación <?php echo $h->tipo; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="text-warning fw-bold">$<?php echo number_format($h->precio, 2); ?> MXN/noche</h4>
                                        <p class="text-muted"><?php echo $descripcion; ?></p>
                                        
                                        <h6 class="fw-bold mt-4">Características:</h6>
                                        <ul class="list-unstyled">
                                            <li><i class="fas fa-check text-success me-2"></i>Vista panorámica al mar</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Desayuno buffet incluido</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Servicio de limpieza diario</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Acceso a piscina infinity</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Estacionamiento gratuito</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <a href="reservar.php?habitacion_id=<?php echo $h->idHabitacion; ?>" 
                                   class="btn btn-primary">
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
                <div class="col-12 text-center py-5">
                    <div class="alert alert-warning">
                        <i class="fas fa-bed fa-2x mb-3"></i>
                        <h4 class="alert-heading">¡Temporada Alta!</h4>
                        <p class="mb-0">Todas nuestras habitaciones están actualmente ocupadas. <br>
                        <a href="contacto.php" class="alert-link">Contáctanos</a> para disponibilidad especial y lista de espera.</p>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- Sección de Servicios Incluidos -->
    <section class="py-5 bg-dark text-white">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="fw-bold mb-3">Servicios Incluidos</h2>
                    <p class="lead opacity-75">Todos estos beneficios están incluidos en tu estancia</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-3 text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-flex mb-3">
                        <i class="fas fa-utensils fa-2x text-primary"></i>
                    </div>
                    <h5 class="fw-bold">Desayuno Gourmet</h5>
                    <p class="opacity-75">Buffet internacional todas las mañanas</p>
                </div>
                <div class="col-md-3 text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-flex mb-3">
                        <i class="fas fa-infinity fa-2x text-primary"></i>
                    </div>
                    <h5 class="fw-bold">Piscina Infinity</h5>
                    <p class="opacity-75">Acceso ilimitado con vista al mar</p>
                </div>
                <div class="col-md-3 text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-flex mb-3">
                        <i class="fas fa-wifi fa-2x text-primary"></i>
                    </div>
                    <h5 class="fw-bold">WiFi Premium</h5>
                    <p class="opacity-75">Internet de alta velocidad en todo el resort</p>
                </div>
                <div class="col-md-3 text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-flex mb-3">
                        <i class="fas fa-dumbbell fa-2x text-primary"></i>
                    </div>
                    <h5 class="fw-bold">Gimnasio</h5>
                    <p class="opacity-75">Equipo de última generación 24/7</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="fw-bold mb-3">¿Tienes dudas sobre nuestras habitaciones?</h2>
            <p class="lead mb-4 opacity-75">Nuestro equipo de reservaciones está listo para ayudarte</p>
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="reservar.php" class="btn btn-warning btn-lg fw-semibold px-4">
                    <i class="fas fa-calendar-check me-2"></i>Reservar Ahora
                </a>
                <a href="contacto.php" class="btn btn-outline-light btn-lg fw-semibold px-4">
                    <i class="fas fa-phone me-2"></i>Contactar
                </a>
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
                        reservaciones@hotelparadise.com
                    </p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h6 class="fw-bold mb-3">Enlaces Rápidos</h6>
                    <div class="row">
                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="index.php" class="text-decoration-none opacity-75">Inicio</a></li>
                                <li class="mb-2"><a href="habitaciones.php" class="text-decoration-none opacity-75">Habitaciones</a></li>
                                <li class="mb-2"><a href="servicios.php" class="text-decoration-none opacity-75">Servicios</a></li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="reservar.php" class="text-decoration-none opacity-75">Reservar</a></li>
                                <li class="mb-2"><a href="#" class="text-decoration-none opacity-75">Galería</a></li>
                                <li class="mb-2"><a href="#" class="text-decoration-none opacity-75">Contacto</a></li>
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
        // Filtrado de habitaciones
        document.addEventListener('DOMContentLoaded', function() {
            const btnFiltrar = document.getElementById('btnFiltrar');
            const filtroTipo = document.getElementById('filtroTipo');
            const filtroPrecio = document.getElementById('filtroPrecio');
            const habitaciones = document.querySelectorAll('.habitacion-item');
            
            function aplicarFiltros() {
                const tipo = filtroTipo.value;
                const precio = filtroPrecio.value;
                let visibleCount = 0;
                
                habitaciones.forEach(habitacion => {
                    const itemTipo = habitacion.dataset.tipo;
                    const itemPrecio = parseFloat(habitacion.dataset.precio);
                    let mostrar = true;
                    
                    // Filtro por tipo
                    if (tipo !== 'todos' && itemTipo !== tipo) {
                        mostrar = false;
                    }
                    
                    // Filtro por precio
                    if (precio !== 'todos') {
                        const [min, max] = precio.split('-');
                        if (max === '+') {
                            if (itemPrecio < parseFloat(min)) mostrar = false;
                        } else {
                            if (itemPrecio < parseFloat(min) || itemPrecio > parseFloat(max)) mostrar = false;
                        }
                    }
                    
                    if (mostrar) {
                        habitacion.style.display = 'block';
                        visibleCount++;
                    } else {
                        habitacion.style.display = 'none';
                    }
                });
                
                // Mostrar mensaje si no hay resultados
                const grid = document.getElementById('gridHabitaciones');
                let mensaje = grid.querySelector('.no-results');
                
                if (visibleCount === 0) {
                    if (!mensaje) {
                        mensaje = document.createElement('div');
                        mensaje.className = 'col-12 text-center py-5 no-results';
                        mensaje.innerHTML = `
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle fa-2x mb-3"></i>
                                <h5>No se encontraron habitaciones</h5>
                                <p class="mb-0">Intenta ajustar los filtros de búsqueda</p>
                            </div>
                        `;
                        grid.appendChild(mensaje);
                    }
                } else if (mensaje) {
                    mensaje.remove();
                }
            }
            
            btnFiltrar.addEventListener('click', aplicarFiltros);
            filtroTipo.addEventListener('change', aplicarFiltros);
            filtroPrecio.addEventListener('change', aplicarFiltros);
        });
    </script>
</body>
</html>