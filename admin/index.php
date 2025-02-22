<?php
require_once './config/auth_check.php';
require_once './config/connection.php';

try {
    // Query untuk menghitung total wisata
    $stmt_wisata = $koneksi->query("SELECT COUNT(*) AS total_wisata FROM wisata");
    $total_wisata = $stmt_wisata->fetchColumn();

    // Query untuk menghitung total fasilitas
    // $stmt_fasilitas = $koneksi->query("SELECT COUNT(*) AS total_fasilitas FROM fasilitas");
    // $total_fasilitas = $stmt_fasilitas->fetchColumn();

    // // Query untuk menghitung event aktif
    // $stmt_event_aktif = $koneksi->query("SELECT COUNT(*) AS total_event_aktif FROM event WHERE status = 'aktif'");
    // $total_event_aktif = $stmt_event_aktif->fetchColumn();

    // // Query untuk menghitung total event
    // $stmt_event_total = $koneksi->query("SELECT COUNT(*) AS total_event FROM event");
    // $total_event = $stmt_event_total->fetchColumn();

    // // Query untuk menghitung total berita
    // $stmt_berita = $koneksi->query("SELECT COUNT(*) AS total_berita FROM berita");
    // $total_berita = $stmt_berita->fetchColumn();

    // // Query untuk mendapatkan 5 event terbaru
    // $stmt_latest_events = $koneksi->query("SELECT nama_event, tanggal_mulai, tanggal_selesai, status 
    //                                   FROM event 
    //                                   ORDER BY tanggal_mulai DESC 
    //                                   LIMIT 5");
    // $latest_events = $stmt_latest_events->fetchAll(PDO::FETCH_ASSOC);

    // // Query untuk mendapatkan 5 berita terbaru
    // $stmt_latest_news = $koneksi->query("SELECT judul_berita, tanggal_posting 
    //                                 FROM berita 
    //                                 ORDER BY tanggal_posting DESC 
    //                                 LIMIT 5");
    // $latest_news = $stmt_latest_news->fetchAll(PDO::FETCH_ASSOC);

    // Array untuk menyimpan semua data
    $dashboard_data = [
        'total_wisata' => $total_wisata
        // 'total_fasilitas' => $total_fasilitas,
        // 'total_event_aktif' => $total_event_aktif,
        // 'total_event' => $total_event,
        // 'total_berita' => $total_berita,
        // 'latest_events' => $latest_events,
        // 'latest_news' => $latest_news
    ];
} catch (PDOException $e) {
    // Handle error
    error_log("Error: " . $e->getMessage());
    $dashboard_data = [
        'error' => 'Terjadi kesalahan dalam mengambil data'
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Font Awesome untuk icons -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> -->

    <!-- Custom Styling -->
    <link rel="shortcut icon" type="image/png" href="./assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="./assets/css/styles.min.css" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <!-- Include Sidebar -->
        <?php include 'components/sidebar.php'; ?>

        <!--  Main wrapper -->
        <div class="body-wrapper">

            <!-- Include Navbar -->
            <?php include 'components/navbar.php'; ?>

            <div class="container-fluid">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <!-- Card Total Wisata -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Wisata</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $dashboard_data['total_wisata']; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Total Fasilitas -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Fasilitas</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $dashboard_data['total_fasilitas']; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-building fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Event Aktif -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Event Aktif</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $dashboard_data['total_event_aktif']; ?> dari <?php echo $dashboard_data['total_event']; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Total Berita -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Berita</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $dashboard_data['total_berita']; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Event Terbaru -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Event Terbaru</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nama Event</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dashboard_data['latest_events'] as $event): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($event['nama_event']); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($event['tanggal_mulai'])); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($event['tanggal_selesai'])); ?></td>
                                            <td>
                                                <span class="badge <?php echo $event['status'] == 'aktif' ? 'badge text-bg-success' : ' badge text-bg-secondary'; ?>">
                                                    <?php echo ucfirst($event['status']); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tabel Berita Terbaru -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Berita Terbaru</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Judul Berita</th>
                                        <th>Tanggal Posting</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dashboard_data['latest_news'] as $news): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($news['judul_berita']); ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($news['tanggal_posting'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!--  Row 1 -->
                <div class="row">
                    <div class="col-lg-8 d-flex align-items-strech">
                        <div class="card w-100">
                            <div class="card-body">
                                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                                    <div class="mb-3 mb-sm-0">
                                        <h5 class="card-title fw-semibold">Sales Overview</h5>
                                    </div>
                                    <div>
                                        <select class="form-select">
                                            <option value="1">March 2023</option>
                                            <option value="2">April 2023</option>
                                            <option value="3">May 2023</option>
                                            <option value="4">June 2023</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="chart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Yearly Breakup -->
                                <div class="card overflow-hidden">
                                    <div class="card-body p-4">
                                        <h5 class="card-title mb-9 fw-semibold">Yearly Breakup</h5>
                                        <div class="row align-items-center">
                                            <div class="col-8">
                                                <h4 class="fw-semibold mb-3">$36,358</h4>
                                                <div class="d-flex align-items-center mb-3">
                                                    <span
                                                        class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                                                        <i class="ti ti-arrow-up-left text-success"></i>
                                                    </span>
                                                    <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                                                    <p class="fs-3 mb-0">last year</p>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-4">
                                                        <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                                                        <span class="fs-2">2023</span>
                                                    </div>
                                                    <div>
                                                        <span class="round-8 bg-light-primary rounded-circle me-2 d-inline-block"></span>
                                                        <span class="fs-2">2023</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="d-flex justify-content-center">
                                                    <div id="breakup"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <!-- Monthly Earnings -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row alig n-items-start">
                                            <div class="col-8">
                                                <h5 class="card-title mb-9 fw-semibold"> Monthly Earnings </h5>
                                                <h4 class="fw-semibold mb-3">$6,820</h4>
                                                <div class="d-flex align-items-center pb-1">
                                                    <span
                                                        class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center">
                                                        <i class="ti ti-arrow-down-right text-danger"></i>
                                                    </span>
                                                    <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                                                    <p class="fs-3 mb-0">last year</p>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="d-flex justify-content-end">
                                                    <div
                                                        class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                        <i class="ti ti-currency-dollar fs-6"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="earning"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 d-flex align-items-stretch">
                        <div class="card w-100">
                            <div class="card-body p-4">
                                <div class="mb-4">
                                    <h5 class="card-title fw-semibold">Recent Transactions</h5>
                                </div>
                                <ul class="timeline-widget mb-0 position-relative mb-n5">
                                    <li class="timeline-item d-flex position-relative overflow-hidden">
                                        <div class="timeline-time text-dark flex-shrink-0 text-end">09:30</div>
                                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                            <span class="timeline-badge border-2 border border-primary flex-shrink-0 my-8"></span>
                                            <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                        </div>
                                        <div class="timeline-desc fs-3 text-dark mt-n1">Payment received from John Doe of $385.90</div>
                                    </li>
                                    <li class="timeline-item d-flex position-relative overflow-hidden">
                                        <div class="timeline-time text-dark flex-shrink-0 text-end">10:00 am</div>
                                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                            <span class="timeline-badge border-2 border border-info flex-shrink-0 my-8"></span>
                                            <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                        </div>
                                        <div class="timeline-desc fs-3 text-dark mt-n1 fw-semibold">New sale recorded <a
                                                href="javascript:void(0)" class="text-primary d-block fw-normal">#ML-3467</a>
                                        </div>
                                    </li>
                                    <li class="timeline-item d-flex position-relative overflow-hidden">
                                        <div class="timeline-time text-dark flex-shrink-0 text-end">12:00 am</div>
                                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                            <span class="timeline-badge border-2 border border-success flex-shrink-0 my-8"></span>
                                            <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                        </div>
                                        <div class="timeline-desc fs-3 text-dark mt-n1">Payment was made of $64.95 to Michael</div>
                                    </li>
                                    <li class="timeline-item d-flex position-relative overflow-hidden">
                                        <div class="timeline-time text-dark flex-shrink-0 text-end">09:30 am</div>
                                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                            <span class="timeline-badge border-2 border border-warning flex-shrink-0 my-8"></span>
                                            <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                        </div>
                                        <div class="timeline-desc fs-3 text-dark mt-n1 fw-semibold">New sale recorded <a
                                                href="javascript:void(0)" class="text-primary d-block fw-normal">#ML-3467</a>
                                        </div>
                                    </li>
                                    <li class="timeline-item d-flex position-relative overflow-hidden">
                                        <div class="timeline-time text-dark flex-shrink-0 text-end">09:30 am</div>
                                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                            <span class="timeline-badge border-2 border border-danger flex-shrink-0 my-8"></span>
                                            <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                        </div>
                                        <div class="timeline-desc fs-3 text-dark mt-n1 fw-semibold">New arrival recorded
                                        </div>
                                    </li>
                                    <li class="timeline-item d-flex position-relative overflow-hidden">
                                        <div class="timeline-time text-dark flex-shrink-0 text-end">12:00 am</div>
                                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                            <span class="timeline-badge border-2 border border-success flex-shrink-0 my-8"></span>
                                        </div>
                                        <div class="timeline-desc fs-3 text-dark mt-n1">Payment Done</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 d-flex align-items-stretch">
                        <div class="card w-100">
                            <div class="card-body p-4">
                                <h5 class="card-title fw-semibold mb-4">Recent Transactions</h5>
                                <div class="table-responsive">
                                    <table class="table text-nowrap mb-0 align-middle">
                                        <thead class="text-dark fs-4">
                                            <tr>
                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">Id</h6>
                                                </th>
                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">Assigned</h6>
                                                </th>
                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">Name</h6>
                                                </th>
                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">Priority</h6>
                                                </th>
                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">Budget</h6>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">1</h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-1">Sunil Joshi</h6>
                                                    <span class="fw-normal">Web Designer</span>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-normal">Elite Admin</p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="badge bg-primary rounded-3 fw-semibold">Low</span>
                                                    </div>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0 fs-4">$3.9</h6>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">2</h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-1">Andrew McDownland</h6>
                                                    <span class="fw-normal">Project Manager</span>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-normal">Real Homes WP Theme</p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="badge bg-secondary rounded-3 fw-semibold">Medium</span>
                                                    </div>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0 fs-4">$24.5k</h6>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">3</h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-1">Christopher Jamil</h6>
                                                    <span class="fw-normal">Project Manager</span>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-normal">MedicalPro WP Theme</p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="badge bg-danger rounded-3 fw-semibold">High</span>
                                                    </div>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0 fs-4">$12.8k</h6>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">4</h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-1">Nirav Joshi</h6>
                                                    <span class="fw-normal">Frontend Engineer</span>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-normal">Hosting Press HTML</p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="badge bg-success rounded-3 fw-semibold">Critical</span>
                                                    </div>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0 fs-4">$2.4k</h6>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xl-3">
                        <div class="card overflow-hidden rounded-2">
                            <div class="position-relative">
                                <a href="javascript:void(0)"><img src="./assets/images/products/s4.jpg" class="card-img-top rounded-0" alt="..."></a>
                                <a href="javascript:void(0)" class="bg-primary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart"><i class="ti ti-basket fs-4"></i></a>
                            </div>
                            <div class="card-body pt-3 p-4">
                                <h6 class="fw-semibold fs-4">Boat Headphone</h6>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h6 class="fw-semibold fs-4 mb-0">$50 <span class="ms-2 fw-normal text-muted fs-3"><del>$65</del></span></h6>
                                    <ul class="list-unstyled d-flex align-items-center mb-0">
                                        <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                        <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                        <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                        <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                        <li><a class="" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card overflow-hidden rounded-2">
                            <div class="position-relative">
                                <a href="javascript:void(0)"><img src="./assets/images/products/s5.jpg" class="card-img-top rounded-0" alt="..."></a>
                                <a href="javascript:void(0)" class="bg-primary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart"><i class="ti ti-basket fs-4"></i></a>
                            </div>
                            <div class="card-body pt-3 p-4">
                                <h6 class="fw-semibold fs-4">MacBook Air Pro</h6>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h6 class="fw-semibold fs-4 mb-0">$650 <span class="ms-2 fw-normal text-muted fs-3"><del>$900</del></span></h6>
                                    <ul class="list-unstyled d-flex align-items-center mb-0">
                                        <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                        <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                        <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                        <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                        <li><a class="" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card overflow-hidden rounded-2">
                            <div class="position-relative">
                                <a href="javascript:void(0)"><img src="./assets/images/products/s7.jpg" class="card-img-top rounded-0" alt="..."></a>
                                <a href="javascript:void(0)" class="bg-primary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart"><i class="ti ti-basket fs-4"></i></a>
                            </div>
                            <div class="card-body pt-3 p-4">
                                <h6 class="fw-semibold fs-4">Red Valvet Dress</h6>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h6 class="fw-semibold fs-4 mb-0">$150 <span class="ms-2 fw-normal text-muted fs-3"><del>$200</del></span></h6>
                                    <ul class="list-unstyled d-flex align-items-center mb-0">
                                        <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                        <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                        <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                        <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                        <li><a class="" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card overflow-hidden rounded-2">
                            <div class="position-relative">
                                <a href="javascript:void(0)"><img src="./assets/images/products/s11.jpg" class="card-img-top rounded-0" alt="..."></a>
                                <a href="javascript:void(0)" class="bg-primary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart"><i class="ti ti-basket fs-4"></i></a>
                            </div>
                            <div class="card-body pt-3 p-4">
                                <h6 class="fw-semibold fs-4">Cute Soft Teddybear</h6>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h6 class="fw-semibold fs-4 mb-0">$285 <span class="ms-2 fw-normal text-muted fs-3"><del>$345</del></span></h6>
                                    <ul class="list-unstyled d-flex align-items-center mb-0">
                                        <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                        <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                        <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                        <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                        <li><a class="" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Include Footer -->
                <?php include 'components/footer.php'; ?>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const closeButton = alert.querySelector('.btn-close');
                    if (closeButton) {
                        closeButton.click();
                    }
                }, 5000);
            });
        });
    </script>

    <!-- Custom Script -->
    <script src="./assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/sidebarmenu.js"></script>
    <script src="./assets/js/app.min.js"></script>
    <script src="./assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="./assets/js/dashboard.js"></script>

    <!-- Bootstrap JS and dependencies -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- Add jQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
</body>

</html>