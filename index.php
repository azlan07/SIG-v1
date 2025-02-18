<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GIS - Sistem Informasi Geografis</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <div class="brand-logo d-flex align-items-center justify-content-between">
                <a href="index.php" class="logo-container">
                    <div class="logo-wrapper">
                        <i class="ti ti-globe globe-icon"></i>
                        <span class="logo-text">SIG</span>
                    </div>
                </a>
                <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                    <i class="ti ti-x fs-8"></i>
                </div>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mx-4">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#map">Peta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Kontak</a>
                    </li>
                </ul>
                <a class="btn btn-primary fw-semibold" href="login.php">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            <div class="row h-100 align-items-center">
                <div class="col-md-6">
                    <img src="images/digital-art-with-planet-earth.png" alt="GIS Illustration" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h1 class="display-3 text-light">SIG - Wisata</h1>
                    <p class="lead text-light">Sistem Informasi Geografis - Wisata <br>Temukan dan eksplorasi tempat wisata dengan data geografis yang mudah digunakan.</p>
                    <!-- <a href="#map" class="btn btn-primary btn-lg">Mulai Eksplorasi</a> -->
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-2 feature" style="height: 550px;">
        <div class="container">
            <h2 class="text-center mb-5">Fitur Utama</h2>
            <div class="row g-4" style="position: relative; z-index: 1;">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="fas fa-map-marked-alt feature-icon"></i>
                            <h5 class="card-title">Pemetaan Interaktif</h5>
                            <p class="card-text">Visualisasi data geografis dengan peta interaktif yang mudah digunakan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="fas fa-layer-group feature-icon"></i>
                            <h5 class="card-title">Analisis Spasial</h5>
                            <p class="card-text">Lakukan analisis spasial untuk mengambil keputusan yang lebih baik.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="fas fa-chart-bar feature-icon"></i>
                            <h5 class="card-title">Visualisasi Data</h5>
                            <p class="card-text">Tampilkan data dalam berbagai format visualisasi yang informatif.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section id="map" class="py-5 bg-light">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card bg-white">
                        <h2 class="text-center mt-4">Peta Lokasi Wisata</h2>
                        <div class="card-body">
                            <div id="mapContainer" style="height: 500px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card bg-white p-3" style="position: relative; z-index: 1;">
                        <!-- Daftar Wisata -->
                        <h2 class="text-center mb-4">Wisata</h2>
                        <div class="row" id="wisataList">
                            <!-- Data wisata akan dimuat secara dinamis -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2>Tentang Platform SIG Kami</h2>
                    <p>Platform SIG kami menyediakan informasi lengkap untuk kebutuhan eksplorasi tempat wisata. Dengan antarmuka yang user-friendly dan fitur-fitur canggih, kami membantu Anda mengoptimalkan pencarian lokasi dan informasi yang diperlukan.</p>
                </div>
                <div class="col-md-6">
                    <img src="images/digital-art-with-planet-earth.png" width="50%" alt="About GIS" class="img-fluid rounded-4">
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5 contact">
        <div class="container">
            <h2 class="text-center text-light mb-4" style="margin-top: 200px;">Hubungi Kami</h2>
            <div class="row justify-content-center" style="position: relative; z-index: 1;">
                <div class="col-md-8">
                    <form id="contactForm">
                        <div class="mb-3">
                            <label for="name" class="form-label text-light">Nama</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label text-light">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label text-light">Pesan</label>
                            <textarea class="form-control" id="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>SIG - Wisata</h5>
                    <p>Platform Sistem Informasi Geografis untuk kebutuhan eksplorasi tempat wisata.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5>Kontak</h5>
                    <p>Email: info@utie.com<br>
                        Telp: +62 123 456 789</p>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p>&copy; 2025 UTie - Solution. <br> All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // Animation on scroll
        const animateOnScroll = () => {
            const elements = document.querySelectorAll('.animate-fade-in');
            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementBottom = element.getBoundingClientRect().bottom;

                if (elementTop < window.innerHeight && elementBottom > 0) {
                    element.classList.add('visible');
                }
            });
        };

        window.addEventListener('scroll', animateOnScroll);
        window.addEventListener('load', animateOnScroll);

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize map
            const map = L.map('mapContainer').setView([-0.789275, 113.921327], 5); // Indonesia center

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Jika masih bermasalah, gunakan default icon sementara
            const customIcon = L.icon({
                iconUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            // Fetch wisata data from database
            fetch('get_wisata.php')
                .then(response => response.json())
                .then(data => {
                    // Create markers for each location
                    data.forEach(wisata => {
                        const marker = L.marker([
                            parseFloat(wisata.latitude),
                            parseFloat(wisata.longitude)
                        ], ).addTo(map);

                        // Create popup content
                        const popupContent = `
                    <div class="popup-content">
                        <h5>${wisata.nama_wisata}</h5>
                        <img src="assets/images/wisata/${wisata.foto_wisata}" alt="${wisata.nama_wisata}" style="width:200px;height:150px;object-fit:cover;margin:10px 0;">
                        <p><strong>Alamat:</strong> ${wisata.alamat}</p>
                        <p><strong>Harga Tiket:</strong> ${wisata.harga_tiket}</p>
                        <p>${wisata.deskripsi.substring(0, 100)}...</p>
                        <button class="btn btn-primary btn-sm w-100" onclick="showWisataDetail(${wisata.id_wisata})">Lihat Detail</button>
                    </div>
                `;

                        marker.bindPopup(popupContent);

                        // Add to wisata list
                        const wisataCard = `
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="assets/images/wisata/${wisata.foto_wisata}" class="card-img-top" alt="${wisata.nama_wisata}" style="height:200px;object-fit:cover;">
                            <div class="card-body">
                                <h5 class="card-title">${wisata.nama_wisata}</h5>
                                <p class="card-text">${wisata.deskripsi.substring(0, 100)}...</p>
                                <button class="btn btn-primary btn-sm w-100" onclick="showWisataDetail(${wisata.id_wisata})">Lihat Detail</button>
                            </div>
                        </div>
                    </div>
                `;
                        document.getElementById('wisataList').innerHTML += wisataCard;
                    });

                    // Fit bounds to show all markers
                    if (data.length > 0) {
                        const bounds = L.latLngBounds(data.map(wisata => [
                            parseFloat(wisata.latitude),
                            parseFloat(wisata.longitude)
                        ]));
                        map.fitBounds(bounds);

                        map.fitBounds(bounds, {
                            padding: [50, 50], // Menambahkan padding 50 pixel di setiap sisi
                            maxZoom: map.getZoom() - 1 // Mengurangi level zoom sebanyak 1 tingkat
                        });
                    }
                })
                .catch(error => console.error('Error:', error));

            // Add zoom controls
            map.zoomControl.setPosition('bottomright');

            // Add scale control
            L.control.scale().addTo(map);
        });
    </script>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="js/main.js"></script>
</body>

</html>