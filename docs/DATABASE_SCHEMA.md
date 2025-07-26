# Database Schema - MVP Implementation
## Dr. CRUD - Pharmacy Management System

### **Database Name: `db_apotek`**

**Schema Version:** MVP 1.0  
**Target:** MySQL/MariaDB  
**Character Set:** utf8mb4  
**Collation:** utf8mb4_unicode_ci  

---

## **📊 Table Overview**

**Core Tables (8 tables total):**
- ✅ **6 Original Tables** (maintained from PRD)
- ✅ **2 New MVP Tables** (Users, Sessions)
- ✅ **Enhanced Fields** (status, timestamps)

---

## **🔐 Authentication & User Management**

### **1. Users (System Authentication)**
```sql
CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL COMMENT 'bcrypt hashed',
    user_type ENUM('admin', 'apoteker', 'pelanggan') NOT NULL,
    KdPelanggan VARCHAR(10) NULL COMMENT 'Links to customer if user_type = pelanggan',
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_username (username),
    INDEX idx_user_type (user_type),
    INDEX idx_active (is_active),
    FOREIGN KEY (KdPelanggan) REFERENCES Tabel_Pelanggan(KdPelanggan) ON DELETE SET NULL
);
```

**Purpose:** Central authentication for all user roles
**Features:** Role-based access, customer linking, account status management

### **2. Sessions (Security Management)**
```sql
CREATE TABLE Sessions (
    session_id VARCHAR(128) PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(255) UNIQUE NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_user_id (user_id),
    INDEX idx_token (token),
    INDEX idx_expires (expires_at),
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);
```

**Purpose:** Secure session management with token-based authentication
**Features:** Auto-expiry, token validation, session cleanup

---

## **💊 Drug & Inventory Management**

### **3. Tabel_Obat (Drug Catalog) - ENHANCED**
```sql
CREATE TABLE Tabel_Obat (
    KdObat VARCHAR(10) PRIMARY KEY COMMENT 'Drug Code',
    NmObat VARCHAR(100) NOT NULL COMMENT 'Drug Name',
    Jenis VARCHAR(50) NOT NULL COMMENT 'Type/Category',
    Satuan VARCHAR(20) NOT NULL COMMENT 'Unit of Measure',
    HargaBeli DECIMAL(10,2) NOT NULL COMMENT 'Purchase Price',
    HargaJual DECIMAL(10,2) NOT NULL COMMENT 'Selling Price',
    Stok INT NOT NULL DEFAULT 0 COMMENT 'Stock Quantity',
    KdSupplier VARCHAR(10) NOT NULL COMMENT 'Supplier Code',
    status ENUM('active', 'inactive') DEFAULT 'active' COMMENT 'Drug Status',
    min_stock_level INT DEFAULT 10 COMMENT 'Minimum stock alert level',
    description TEXT NULL COMMENT 'Drug description for customers',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_nama_obat (NmObat),
    INDEX idx_jenis (Jenis),
    INDEX idx_status (status),
    INDEX idx_supplier (KdSupplier),
    INDEX idx_stock_level (Stok),
    FOREIGN KEY (KdSupplier) REFERENCES Tabel_Supplier(KdSupplier) ON DELETE RESTRICT
);
```

**New Fields Added:**
- `status` - Enable/disable drugs in system
- `min_stock_level` - Stock alert threshold
- `description` - Detailed information for customers
- `created_at/updated_at` - Audit timestamps

---

## **🏢 Supplier Management**

### **4. Tabel_Supplier (Supplier Database) - ENHANCED**
```sql
CREATE TABLE Tabel_Supplier (
    KdSupplier VARCHAR(10) PRIMARY KEY COMMENT 'Supplier Code',
    NmSupplier VARCHAR(100) NOT NULL COMMENT 'Supplier Name',
    Alamat TEXT NOT NULL COMMENT 'Address',
    Kota VARCHAR(50) NOT NULL COMMENT 'City',
    Telpon VARCHAR(20) NULL COMMENT 'Phone Number',
    email VARCHAR(100) NULL COMMENT 'Email Address',
    contact_person VARCHAR(100) NULL COMMENT 'Contact Person Name',
    status ENUM('active', 'inactive') DEFAULT 'active' COMMENT 'Supplier Status',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_nama_supplier (NmSupplier),
    INDEX idx_kota (Kota),
    INDEX idx_status (status),
    INDEX idx_email (email)
);
```

**New Fields Added:**
- `email` - Digital communication
- `contact_person` - Primary contact name
- `status` - Enable/disable suppliers
- `created_at/updated_at` - Audit timestamps

---

## **👥 Customer Management**

### **5. Tabel_Pelanggan (Customer Database) - ENHANCED**
```sql
CREATE TABLE Tabel_Pelanggan (
    KdPelanggan VARCHAR(10) PRIMARY KEY COMMENT 'Customer Code',
    NmPelanggan VARCHAR(100) NOT NULL COMMENT 'Customer Name',
    Alamat TEXT NOT NULL COMMENT 'Address',
    Kota VARCHAR(50) NOT NULL COMMENT 'City',
    Telpon VARCHAR(20) NULL COMMENT 'Phone Number',
    email VARCHAR(100) NULL COMMENT 'Email Address',
    tanggal_lahir DATE NULL COMMENT 'Date of Birth',
    jenis_kelamin ENUM('L', 'P') NULL COMMENT 'Gender: L=Male, P=Female',
    status ENUM('active', 'inactive') DEFAULT 'active' COMMENT 'Customer Status',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_nama_pelanggan (NmPelanggan),
    INDEX idx_kota (Kota),
    INDEX idx_email (email),
    INDEX idx_telpon (Telpon),
    INDEX idx_status (status)
);
```

**New Fields Added:**
- `email` - Digital communication
- `tanggal_lahir` - Customer demographics
- `jenis_kelamin` - Gender information
- `status` - Enable/disable customers
- `created_at/updated_at` - Audit timestamps

---

## **💰 Sales Transaction Management**

### **6. Penjualan (Sales Header) - ENHANCED**
```sql
CREATE TABLE Penjualan (
    Nota VARCHAR(20) PRIMARY KEY COMMENT 'Sales Receipt Number',
    TglNota DATE NOT NULL COMMENT 'Transaction Date',
    KdPelanggan VARCHAR(10) NULL COMMENT 'Customer Code (nullable for walk-in)',
    user_id INT NOT NULL COMMENT 'Pharmacist who processed the sale',
    Diskon DECIMAL(10,2) DEFAULT 0 COMMENT 'Discount Amount',
    total_before_discount DECIMAL(10,2) NOT NULL COMMENT 'Subtotal before discount',
    total_after_discount DECIMAL(10,2) NOT NULL COMMENT 'Final total after discount',
    payment_method ENUM('cash', 'card', 'transfer') DEFAULT 'cash' COMMENT 'Payment Method',
    notes TEXT NULL COMMENT 'Transaction notes',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_tanggal (TglNota),
    INDEX idx_pelanggan (KdPelanggan),
    INDEX idx_user (user_id),
    INDEX idx_total (total_after_discount),
    FOREIGN KEY (KdPelanggan) REFERENCES Tabel_Pelanggan(KdPelanggan) ON DELETE SET NULL,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE RESTRICT
);
```

**New Fields Added:**
- `user_id` - Track which pharmacist processed sale
- `total_before_discount` - Subtotal calculation
- `total_after_discount` - Final amount
- `payment_method` - Payment tracking
- `notes` - Additional transaction information
- `created_at/updated_at` - Audit timestamps

### **7. Penjualan_Detail (Sales Line Items) - ENHANCED**
```sql
CREATE TABLE Penjualan_Detail (
    detail_id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Detail record ID',
    Nota VARCHAR(20) NOT NULL COMMENT 'Sales Receipt Number',
    KdObat VARCHAR(10) NOT NULL COMMENT 'Drug Code',
    Jumlah INT NOT NULL COMMENT 'Quantity Sold',
    harga_satuan DECIMAL(10,2) NOT NULL COMMENT 'Unit price at time of sale',
    subtotal DECIMAL(10,2) NOT NULL COMMENT 'Line total (quantity * unit_price)',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_nota (Nota),
    INDEX idx_obat (KdObat),
    INDEX idx_combined (Nota, KdObat),
    FOREIGN KEY (Nota) REFERENCES Penjualan(Nota) ON DELETE CASCADE,
    FOREIGN KEY (KdObat) REFERENCES Tabel_Obat(KdObat) ON DELETE RESTRICT
);
```

**New Fields Added:**
- `detail_id` - Primary key for referencing
- `harga_satuan` - Price at time of sale (price history)
- `subtotal` - Line item total
- `created_at` - Record timestamp

---

## **📦 Purchase Order Management**

### **8. Pembelian (Purchase Header) - ENHANCED**
```sql
CREATE TABLE Pembelian (
    Nota VARCHAR(20) PRIMARY KEY COMMENT 'Purchase Receipt Number',
    TglNota DATE NOT NULL COMMENT 'Transaction Date',
    KdSupplier VARCHAR(10) NOT NULL COMMENT 'Supplier Code',
    user_id INT NOT NULL COMMENT 'User who created the purchase order',
    Diskon DECIMAL(10,2) DEFAULT 0 COMMENT 'Discount Amount',
    total_before_discount DECIMAL(10,2) NOT NULL COMMENT 'Subtotal before discount',
    total_after_discount DECIMAL(10,2) NOT NULL COMMENT 'Final total after discount',
    status ENUM('pending', 'received', 'cancelled') DEFAULT 'pending' COMMENT 'Purchase Status',
    notes TEXT NULL COMMENT 'Purchase notes',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_tanggal (TglNota),
    INDEX idx_supplier (KdSupplier),
    INDEX idx_user (user_id),
    INDEX idx_status (status),
    FOREIGN KEY (KdSupplier) REFERENCES Tabel_Supplier(KdSupplier) ON DELETE RESTRICT,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE RESTRICT
);
```

**New Fields Added:**
- `user_id` - Track who created purchase order
- `total_before_discount` - Subtotal calculation
- `total_after_discount` - Final amount
- `status` - Purchase order status tracking
- `notes` - Additional purchase information
- `created_at/updated_at` - Audit timestamps

### **9. Pembelian_Detail (Purchase Line Items) - ENHANCED**
```sql
CREATE TABLE Pembelian_Detail (
    detail_id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Detail record ID',
    Nota VARCHAR(20) NOT NULL COMMENT 'Purchase Receipt Number',
    KdObat VARCHAR(10) NOT NULL COMMENT 'Drug Code',
    Jumlah INT NOT NULL COMMENT 'Quantity Purchased',
    harga_satuan DECIMAL(10,2) NOT NULL COMMENT 'Unit purchase price',
    subtotal DECIMAL(10,2) NOT NULL COMMENT 'Line total (quantity * unit_price)',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_nota (Nota),
    INDEX idx_obat (KdObat),
    INDEX idx_combined (Nota, KdObat),
    FOREIGN KEY (Nota) REFERENCES Pembelian(Nota) ON DELETE CASCADE,
    FOREIGN KEY (KdObat) REFERENCES Tabel_Obat(KdObat) ON DELETE RESTRICT
);
```

**New Fields Added:**
- `detail_id` - Primary key for referencing
- `harga_satuan` - Purchase price per unit
- `subtotal` - Line item total
- `created_at` - Record timestamp

---

## **🔗 Database Relationships**

### **Foreign Key Constraints:**
```
Users.KdPelanggan → Tabel_Pelanggan.KdPelanggan
Sessions.user_id → Users.user_id
Tabel_Obat.KdSupplier → Tabel_Supplier.KdSupplier
Penjualan.KdPelanggan → Tabel_Pelanggan.KdPelanggan
Penjualan.user_id → Users.user_id
Penjualan_Detail.Nota → Penjualan.Nota
Penjualan_Detail.KdObat → Tabel_Obat.KdObat
Pembelian.KdSupplier → Tabel_Supplier.KdSupplier
Pembelian.user_id → Users.user_id
Pembelian_Detail.Nota → Pembelian.Nota
Pembelian_Detail.KdObat → Tabel_Obat.KdObat
```

### **Cascade Rules:**
- **CASCADE:** Sessions, Detail tables (when parent deleted, children deleted)
- **SET NULL:** Optional references (KdPelanggan in sales)
- **RESTRICT:** Critical references (prevent deletion if referenced)

---

## **📈 Performance Optimization**

### **Indexes for Fast Queries:**

**Search Performance:**
- Drug names, categories, suppliers
- Customer names, phone, email
- Transaction dates and amounts

**Reporting Performance:**
- Date ranges for sales/purchase reports  
- User activity tracking
- Stock level monitoring

**Security Performance:**
- Username lookups for authentication
- Session token validation
- Role-based access checks

---

## **🛡️ Security Features**

### **Data Protection:**
- **Password Hashing:** bcrypt with salt
- **SQL Injection Prevention:** Prepared statements required
- **Sensitive Data:** No plain text passwords, secure session tokens

### **Access Control:**
- **Role-based Permissions:** Enforced at application level
- **Session Security:** Token-based with expiration
- **Audit Trail:** created_at/updated_at on all tables

---

## **📊 Sample Data Requirements**

### **Initial Setup Data:**

**Default Admin User:**
```sql
INSERT INTO Users (username, password, user_type) 
VALUES ('admin', '$2y$10$hash...', 'admin');
```

**Sample Drug Categories:**
- Antibiotik, Analgesik, Vitamin, Suplemen, Obat Batuk, dll.

**Sample Suppliers:**
- PT Kimia Farma, PT Kalbe Farma, PT Sanbe Farma

---

## **🚀 Deployment Considerations**

### **Database Settings:**
```sql
-- Recommended MySQL settings for pharmacy system
innodb_buffer_pool_size = 256M
max_connections = 100
query_cache_size = 64M
innodb_log_file_size = 64M
```

### **Backup Strategy:**
- **Daily:** Full database backup
- **Hourly:** Transaction log backup
- **Real-time:** Binary log for point-in-time recovery

---

## **📋 Migration Scripts**

### **Creation Order:**
1. Tabel_Supplier (no dependencies)
2. Tabel_Pelanggan (no dependencies)  
3. Users (references Tabel_Pelanggan)
4. Sessions (references Users)
5. Tabel_Obat (references Tabel_Supplier)
6. Penjualan (references Users, Tabel_Pelanggan)
7. Penjualan_Detail (references Penjualan, Tabel_Obat)
8. Pembelian (references Users, Tabel_Supplier)
9. Pembelian_Detail (references Pembelian, Tabel_Obat)

### **Data Integrity:**
- All tables have proper constraints
- Foreign keys enforce referential integrity
- Enum values limit invalid data entry
- Default values ensure data consistency

---

## **✅ MVP Validation Checklist**

**Core Requirements:**
- ✅ All original PRD tables maintained
- ✅ User authentication system complete
- ✅ Role-based access control supported
- ✅ Complete CRUD operations possible
- ✅ Transaction integrity maintained
- ✅ Performance optimized with indexes
- ✅ Security measures implemented
- ✅ Audit trail available

**Business Logic Support:**
- ✅ Drug inventory management
- ✅ Sales transaction processing  
- ✅ Purchase order management
- ✅ Customer relationship tracking
- ✅ Supplier management
- ✅ User role management
- ✅ Reporting data structure

---

**Note:** This schema balances MVP speed requirements with production-ready design principles. All enhancements maintain backward compatibility with the original PRD specification while adding essential functionality for the pharmacy management system.