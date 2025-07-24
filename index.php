<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit();
}

// Include database and get statistics
include 'includes/database.php';

try {
    $pdo = getConnection();
    
    // Get statistics
    $totalDrugs = $pdo->query("SELECT COUNT(*) FROM Tabel_Obat WHERE status = 'active'")->fetchColumn();
    $todaySales = $pdo->query("SELECT COUNT(*) FROM Penjualan WHERE TglNota = CURDATE()")->fetchColumn();
    $lowStock = $pdo->query("SELECT COUNT(*) FROM Tabel_Obat WHERE Stok <= min_stock_level AND status = 'active'")->fetchColumn();
    $totalCustomers = $pdo->query("SELECT COUNT(*) FROM Tabel_Pelanggan")->fetchColumn();
    
} catch (PDOException $e) {
    $totalDrugs = $todaySales = $lowStock = $totalCustomers = 0;
}

// Include header
include 'includes/header.php';
include 'includes/sidebar.php';
?>

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Welcome to Dr. CRUD! 🎉</h5>
                                <p class="mb-4">
                                    Pharmacy Management System Dashboard. Manage drugs, sales, and inventory efficiently.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-capsule bx-sm text-info"></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Total Drugs</span>
                        <h3 class="card-title mb-2"><?= $totalDrugs ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-receipt bx-sm text-success"></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Today's Sales</span>
                        <h3 class="card-title mb-2"><?= $todaySales ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-store bx-sm text-warning"></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Low Stock Items</span>
                        <h3 class="card-title mb-2"><?= $lowStock ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-user bx-sm text-primary"></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Total Customers</span>
                        <h3 class="card-title mb-2"><?= $totalCustomers ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

<?php include 'includes/footer.php'; ?>