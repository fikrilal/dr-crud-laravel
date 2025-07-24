<?php
require_once 'includes/database.php';

echo "<h2>Dr. CRUD Database Setup</h2>";

// Create database
echo "Creating database...<br>";
createDatabase();
echo "✅ Database 'db_apotek' created successfully<br><br>";

// Connect to database
$pdo = getConnection();

// Create tables
echo "Creating tables...<br>";

// Users table
$sql = "CREATE TABLE IF NOT EXISTS Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('admin', 'apoteker', 'pelanggan') NOT NULL,
    KdPelanggan VARCHAR(10) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE
)";
$pdo->exec($sql);
echo "✅ Users table created<br>";

// Supplier table
$sql = "CREATE TABLE IF NOT EXISTS Tabel_Supplier (
    KdSupplier VARCHAR(10) PRIMARY KEY,
    NmSupplier VARCHAR(100) NOT NULL,
    Alamat TEXT,
    Kota VARCHAR(50),
    Telpon VARCHAR(20)
)";
$pdo->exec($sql);
echo "✅ Supplier table created<br>";

// Customer table
$sql = "CREATE TABLE IF NOT EXISTS Tabel_Pelanggan (
    KdPelanggan VARCHAR(10) PRIMARY KEY,
    NmPelanggan VARCHAR(100) NOT NULL,
    Alamat TEXT,
    Kota VARCHAR(50),
    Telpon VARCHAR(20)
)";
$pdo->exec($sql);
echo "✅ Customer table created<br>";

// Drug table
$sql = "CREATE TABLE IF NOT EXISTS Tabel_Obat (
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
    INDEX idx_supplier (KdSupplier)
)";
$pdo->exec($sql);
echo "✅ Drug table created<br>";

// Sales table
$sql = "CREATE TABLE IF NOT EXISTS Penjualan (
    Nota VARCHAR(20) PRIMARY KEY,
    TglNota DATE NOT NULL,
    KdPelanggan VARCHAR(10),
    Diskon DECIMAL(10,2) DEFAULT 0,
    INDEX idx_customer (KdPelanggan)
)";
$pdo->exec($sql);
echo "✅ Sales table created<br>";

// Sales detail table
$sql = "CREATE TABLE IF NOT EXISTS Penjualan_Detail (
    Nota VARCHAR(20),
    KdObat VARCHAR(10),
    Jumlah INT NOT NULL,
    PRIMARY KEY (Nota, KdObat)
)";
$pdo->exec($sql);
echo "✅ Sales detail table created<br>";

// Purchase table
$sql = "CREATE TABLE IF NOT EXISTS Pembelian (
    Nota VARCHAR(20) PRIMARY KEY,
    TglNota DATE NOT NULL,
    KdSupplier VARCHAR(10),
    Diskon DECIMAL(10,2) DEFAULT 0,
    INDEX idx_supplier (KdSupplier)
)";
$pdo->exec($sql);
echo "✅ Purchase table created<br>";

// Purchase detail table
$sql = "CREATE TABLE IF NOT EXISTS Pembelian_Detail (
    Nota VARCHAR(20),
    KdObat VARCHAR(10),
    Jumlah INT NOT NULL,
    PRIMARY KEY (Nota, KdObat)
)";
$pdo->exec($sql);
echo "✅ Purchase detail table created<br>";

// Drug expiry table
$sql = "CREATE TABLE IF NOT EXISTS Drug_Expiry (
    expiry_id INT AUTO_INCREMENT PRIMARY KEY,
    KdObat VARCHAR(10),
    batch_number VARCHAR(50),
    expiry_date DATE,
    quantity INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($sql);
echo "✅ Drug expiry table created<br><br>";

echo "<h3>Inserting Sample Data</h3>";

// Insert default admin user
$hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT IGNORE INTO Users (username, password, user_type) VALUES (?, ?, ?)");
$stmt->execute(['admin', $hashedPassword, 'admin']);
echo "✅ Admin user created (username: admin, password: admin123)<br>";

// Insert sample supplier
$stmt = $pdo->prepare("INSERT IGNORE INTO Tabel_Supplier VALUES (?, ?, ?, ?, ?)");
$stmt->execute(['SUP001', 'PT. Kimia Farma', 'Jl. Veteran No. 9, Jakarta', 'Jakarta', '021-3856479']);
echo "✅ Sample supplier added<br>";

// Insert sample customer
$stmt = $pdo->prepare("INSERT IGNORE INTO Tabel_Pelanggan VALUES (?, ?, ?, ?, ?)");
$stmt->execute(['PLG001', 'John Doe', 'Jl. Sudirman No. 123', 'Jakarta', '081234567890']);
echo "✅ Sample customer added<br>";

// Insert sample drugs
$drugs = [
    ['OBT001', 'Paracetamol 500mg', 'Tablet', 'Strip', 2500, 3000, 100, 'SUP001'],
    ['OBT002', 'Amoxicillin 250mg', 'Kapsul', 'Strip', 5000, 6000, 50, 'SUP001'],
    ['OBT003', 'Vitamin C 500mg', 'Tablet', 'Botol', 15000, 18000, 30, 'SUP001']
];

$stmt = $pdo->prepare("INSERT IGNORE INTO Tabel_Obat (KdObat, NmObat, Jenis, Satuan, HargaBeli, HargaJual, Stok, KdSupplier) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($drugs as $drug) {
    $stmt->execute($drug);
}
echo "✅ Sample drugs added<br><br>";

echo "<h3>🎉 Database setup completed successfully!</h3>";
echo "<p><strong>Login credentials:</strong></p>";
echo "<ul>";
echo "<li>Username: <strong>admin</strong></li>";
echo "<li>Password: <strong>admin123</strong></li>";
echo "</ul>";
echo "<p><a href='index.php'>Go to Dashboard</a></p>";
?>