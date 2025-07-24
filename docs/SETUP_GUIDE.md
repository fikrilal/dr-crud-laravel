# Dr. CRUD - Pharmacy Management System Setup Guide

## Overview
This guide will help you set up the Dr. CRUD pharmacy management system from scratch using the Sneat Bootstrap admin template and PHP.

## Prerequisites
- Web server (Apache/Nginx) with PHP 7.4+
- MySQL/MariaDB database
- Basic knowledge of PHP and HTML
- Command line access (optional but recommended)

## Step 1: Download Sneat Admin Template

### Option A: Using Command Line (Recommended)
```bash
# Navigate to your project directory
cd your-project-directory

# Download Sneat template from GitHub
curl -L -o sneat-template.zip "https://github.com/themeselection/sneat-html-admin-template-free/archive/refs/heads/master.zip"

# Extract the template
unzip -q sneat-template.zip
```

### Option B: Manual Download
1. Visit: https://github.com/themeselection/sneat-html-admin-template-free
2. Click "Code" → "Download ZIP"
3. Extract the downloaded file to your project directory

## Step 2: Set Up Project Directory Structure

Create the following directories in your project root:

```
dr-crud-laravel/
├── public/
│   ├── assets/
│   └── libs/
├── includes/
├── auth/
├── pages/
├── config/
├── templates/
└── docs/
```

### Using Command Line:
```bash
mkdir -p public/assets includes auth pages config templates docs
```

## Step 3: Copy Sneat Template Files

Copy the necessary files from the extracted Sneat template:

```bash
# Copy assets (CSS, JS, images)
cp -r sneat-bootstrap-html-admin-template-free-main/assets/* public/assets/

# Copy JavaScript libraries
cp -r sneat-bootstrap-html-admin-template-free-main/libs public/

# Copy additional JS files
cp -r sneat-bootstrap-html-admin-template-free-main/js public/assets/

# Copy SCSS files (for customization)
cp -r sneat-bootstrap-html-admin-template-free-main/scss public/assets/

# Copy HTML templates for reference
cp sneat-bootstrap-html-admin-template-free-main/html/* templates/
```

### Manual Copy (if not using command line):
1. Copy `assets/` folder to `public/assets/`
2. Copy `libs/` folder to `public/libs/`
3. Copy `js/` folder to `public/assets/js/`
4. Copy `scss/` folder to `public/assets/scss/`
5. Copy all files from `html/` to `templates/`

## Step 4: Create Core PHP Files

### 4.1 Create Database Configuration
Create `config/database.php`:

```php
<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'db_apotek');

// Create connection
function getConnection() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>
```

### 4.2 Create Header Include
Create `includes/header.php`:

```php
<!doctype html>
<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    
    <title>Dr. CRUD - Pharmacy Management System</title>
    <meta name="description" content="Pharmacy Management System" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="public/assets/img/favicon/favicon.ico" />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    
    <!-- Icons & CSS -->
    <link rel="stylesheet" href="public/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="public/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="public/assets/css/demo.css" />
    
    <!-- JavaScript -->
    <script src="public/assets/js/helpers.js"></script>
    <script src="public/assets/js/config.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
```

### 4.3 Create Sidebar Include
Create `includes/sidebar.php`:

```php
<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.php" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bolder ms-2">Dr. CRUD</span>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item active">
            <a href="index.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Drugs Management -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Inventory</span>
        </li>
        <li class="menu-item">
            <a href="pages/drugs.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-capsule"></i>
                <div data-i18n="Basic">Drugs</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="pages/suppliers.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-store"></i>
                <div data-i18n="Basic">Suppliers</div>
            </a>
        </li>

        <!-- Sales Management -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Sales</span>
        </li>
        <li class="menu-item">
            <a href="pages/sales.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-receipt"></i>
                <div data-i18n="Basic">Sales</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="pages/customers.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Basic">Customers</div>
            </a>
        </li>

        <!-- Reports -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Reports</span>
        </li>
        <li class="menu-item">
            <a href="pages/reports.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-chart"></i>
                <div data-i18n="Basic">Reports</div>
            </a>
        </li>
    </ul>
</aside>
<!-- / Menu -->
```

### 4.4 Create Footer Include
Create `includes/footer.php`:

```php
        </div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <script src="public/libs/jquery/jquery.js"></script>
    <script src="public/libs/popper/popper.js"></script>
    <script src="public/assets/js/bootstrap.js"></script>
    <script src="public/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="public/assets/js/menu.js"></script>
    <script src="public/assets/js/main.js"></script>
</body>
</html>
```

### 4.5 Create Main Dashboard
Create `index.php`:

```php
<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit();
}

// Include header and sidebar
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
                        <h3 class="card-title mb-2">0</h3>
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
                        <h3 class="card-title mb-2">0</h3>
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
                        <h3 class="card-title mb-2">0</h3>
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
                        <h3 class="card-title mb-2">0</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

<?php include 'includes/footer.php'; ?>
```

## Step 5: Create Database

### 5.1 Create Database
```sql
CREATE DATABASE db_apotek;
USE db_apotek;
```

### 5.2 Create Tables (Based on PRD Requirements)

```sql
-- Users table for authentication
CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('admin', 'apoteker', 'pelanggan') NOT NULL,
    KdPelanggan VARCHAR(10) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE
);

-- Supplier table
CREATE TABLE Tabel_Supplier (
    KdSupplier VARCHAR(10) PRIMARY KEY,
    NmSupplier VARCHAR(100) NOT NULL,
    Alamat TEXT,
    Kota VARCHAR(50),
    Telpon VARCHAR(20)
);

-- Customer table
CREATE TABLE Tabel_Pelanggan (
    KdPelanggan VARCHAR(10) PRIMARY KEY,
    NmPelanggan VARCHAR(100) NOT NULL,
    Alamat TEXT,
    Kota VARCHAR(50),
    Telpon VARCHAR(20)
);

-- Drug table
CREATE TABLE Tabel_Obat (
    KdObat VARCHAR(10) PRIMARY KEY,
    NmObat VARCHAR(100) NOT NULL,
    Jenis VARCHAR(50),
    Satuan VARCHAR(20),
    HargaBeli DECIMAL(10,2),
    HargaJual DECIMAL(10,2),
    Stok INT DEFAULT 0,
    KdSupplier VARCHAR(10),
    status ENUM('active', 'inactive', 'discontinued') DEFAULT 'active',
    min_stock_level INT DEFAULT 10,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (KdSupplier) REFERENCES Tabel_Supplier(KdSupplier)
);

-- Sales table
CREATE TABLE Penjualan (
    Nota VARCHAR(20) PRIMARY KEY,
    TglNota DATE NOT NULL,
    KdPelanggan VARCHAR(10),
    Diskon DECIMAL(10,2) DEFAULT 0,
    FOREIGN KEY (KdPelanggan) REFERENCES Tabel_Pelanggan(KdPelanggan)
);

-- Sales detail table
CREATE TABLE Penjualan_Detail (
    Nota VARCHAR(20),
    KdObat VARCHAR(10),
    Jumlah INT NOT NULL,
    PRIMARY KEY (Nota, KdObat),
    FOREIGN KEY (Nota) REFERENCES Penjualan(Nota),
    FOREIGN KEY (KdObat) REFERENCES Tabel_Obat(KdObat)
);

-- Purchase table
CREATE TABLE Pembelian (
    Nota VARCHAR(20) PRIMARY KEY,
    TglNota DATE NOT NULL,
    KdSupplier VARCHAR(10),
    Diskon DECIMAL(10,2) DEFAULT 0,
    FOREIGN KEY (KdSupplier) REFERENCES Tabel_Supplier(KdSupplier)
);

-- Purchase detail table
CREATE TABLE Pembelian_Detail (
    Nota VARCHAR(20),
    KdObat VARCHAR(10),
    Jumlah INT NOT NULL,
    PRIMARY KEY (Nota, KdObat),
    FOREIGN KEY (Nota) REFERENCES Pembelian(Nota),
    FOREIGN KEY (KdObat) REFERENCES Tabel_Obat(KdObat)
);

-- Drug expiry tracking table
CREATE TABLE Drug_Expiry (
    expiry_id INT AUTO_INCREMENT PRIMARY KEY,
    KdObat VARCHAR(10),
    batch_number VARCHAR(50),
    expiry_date DATE,
    quantity INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (KdObat) REFERENCES Tabel_Obat(KdObat)
);
```

## Step 6: Create Authentication System

### 6.1 Create Login Page
Create `auth/login.php`:

```php
<?php
session_start();
include '../config/database.php';

if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE username = ? AND is_active = 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_type'] = $user['user_type'];
        
        header('Location: ../index.php');
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!doctype html>
<html lang="en" class="layout-menu-fixed layout-compact">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Dr. CRUD</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../public/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../public/assets/css/demo.css" />
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-2">Welcome to Dr. CRUD! 👋</h4>
                        <p class="mb-4">Please sign-in to your account</p>

                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" required autofocus />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" class="form-control" name="password" required />
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
```

## Step 7: Testing the Setup

1. **Start your web server** (Apache/Nginx)
2. **Create the database** using the SQL commands above
3. **Insert a test user**:
   ```sql
   INSERT INTO Users (username, password, user_type) 
   VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
   -- Password is 'password'
   ```
4. **Access your application** via web browser
5. **Login** with username: `admin`, password: `password`

## Step 8: Customization

### Template Customization
- Edit colors in `public/assets/scss/_variables.scss`
- Modify layout in include files
- Add custom CSS in `public/assets/css/custom.css`

### Adding New Pages
1. Create PHP file in `pages/` directory
2. Include header and sidebar
3. Add content using Bootstrap classes from Sneat
4. Include footer

## Next Steps

After completing this setup, you can:
1. Build CRUD operations for drugs, suppliers, customers
2. Implement sales and purchase modules  
3. Add reporting functionality
4. Enhance security features
5. Add data validation and error handling

## Troubleshooting

### Common Issues:
1. **CSS/JS not loading**: Check file paths in header.php
2. **Database connection failed**: Verify database credentials
3. **Permission denied**: Check file permissions
4. **Session issues**: Ensure session_start() is called

### File Permissions:
```bash
chmod 755 /path/to/project/
chmod 644 /path/to/project/*.php
```

## Resources

- **Sneat Documentation**: https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/
- **Bootstrap 5 Documentation**: https://getbootstrap.com/docs/5.0/
- **PHP Documentation**: https://www.php.net/docs.php
- **MySQL Documentation**: https://dev.mysql.com/doc/

---

**Note**: This setup guide creates a basic foundation for the Dr. CRUD pharmacy management system. Additional security measures, input validation, and error handling should be implemented for production use.