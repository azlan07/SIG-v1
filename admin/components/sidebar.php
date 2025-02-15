<?php
require_once __DIR__ . '/../config/config.php';
?>
<!-- Sidebar Start -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="./index.html" class="logo-container">
                <div class="logo-wrapper">
                    <i class="ti ti-globe globe-icon"></i>
                    <span class="logo-text">SIG</span>
                </div>
            </a>

            <style>
                .logo-container {
                    display: inline-flex;
                    align-items: center;
                    padding: 10px 20px;
                    text-decoration: none;
                    transition: all 0.3s ease;
                }

                .logo-wrapper {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                }

                .globe-icon {
                    font-size: 28px;
                    color: #5D87FF;
                    transition: all 0.5s ease;
                }

                .logo-text {
                    font-size: 24px;
                    font-weight: 700;
                    color: #2a3547;
                    letter-spacing: 1px;
                    transition: all 0.3s ease;
                }

                .logo-container:hover .globe-icon {
                    transform: rotate(360deg);
                    color: #2a3547;
                }

                .logo-container:hover .logo-text {
                    color: #5D87FF;
                    transform: scale(1.05);
                }
            </style>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?php echo BASE_URL; ?>/index.php" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?php echo BASE_URL; ?>/wisata/table_wisata.php" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Wisata</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">EXTRA</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?php echo BASE_URL; ?>/edit_profile.php" aria-expanded="false">
                        <span>
                            <i class="ti ti-aperture"></i>
                        </span>
                        <span class="hide-menu">Edit Profile</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?php echo BASE_URL; ?>/sample.php" aria-expanded="false">
                        <span>
                            <i class="ti ti-aperture"></i>
                        </span>
                        <span class="hide-menu">Sample Page</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!--  Sidebar End -->