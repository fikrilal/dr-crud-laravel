# Product Requirements Document (PRD)
## Dr. CRUD - Sistem Aplikasi Penjualan Obat (Pharmacy Management System)

### 1. Executive Summary

This document outlines the requirements for **Dr. CRUD**, a comprehensive pharmacy management system that handles drug sales, inventory management, customer relationships, and supplier coordination. The system supports three user roles: Admin, Pharmacist (Apoteker), and Customer (Pelanggan) with role-based access control.

### 2. User Roles & Permissions

#### 2.1 Admin User
**Core Permissions:**
- User management (register/edit pharmacists)
- Master data management (drugs, suppliers, customers)
- Complete inventory control
- Sales reporting and analytics
- System administration

**Specific Capabilities:**
- Register and manage pharmacist accounts
- Add, edit, delete drug records
- Manage supplier information
- Manage customer database
- View and manage purchase orders
- Generate sales reports
- Monitor drug expiration dates
- Change drug status (active/inactive)

#### 2.2 Pharmacist (Apoteker) User
**Core Permissions:**
- Drug inventory management
- Sales transaction processing
- Basic reporting
- Customer service

**Specific Capabilities:**
- Access main dashboard with drug inventory
- Add new drugs to inventory
- Process sales transactions
- Add sales transaction details
- Search for drugs
- View sales history
- Remove expired drugs
- Update drug information

#### 2.3 Customer (Pelanggan) User
**Core Permissions:**
- Browse available drugs
- View drug details
- Account registration

**Specific Capabilities:**
- Register new customer account
- Browse drug catalog
- View drug details and pricing
- Search available medications

### 3. Database Schema & Enhancements

#### 3.1 Existing Tables (Must Follow)

**Tabel_Obat (Drug Table)**
```sql
- KdObat (Primary Key) - Drug Code
- NmObat - Drug Name
- Jenis - Type/Category
- Satuan - Unit of Measure
- HargaBeli - Purchase Price
- HargaJual - Selling Price
- Stok - Stock Quantity
- KdSupplier (Foreign Key) - Supplier Code
```

**Tabel_Supplier (Supplier Table)**
```sql
- KdSupplier (Primary Key) - Supplier Code
- NmSupplier - Supplier Name
- Alamat - Address
- Kota - City
- Telpon - Phone Number
```

**Tabel_Pelanggan (Customer Table)**
```sql
- KdPelanggan (Primary Key) - Customer Code
- NmPelanggan - Customer Name
- Alamat - Address
- Kota - City
- Telpon - Phone Number
```

**Penjualan (Sales Table)**
```sql
- Nota (Primary Key) - Sales Receipt Number
- TglNota - Transaction Date
- KdPelanggan (Foreign Key) - Customer Code
- Diskon - Discount Amount
```

**Penjualan_Detail (Sales Detail Table)**
```sql
- Nota (Foreign Key) - Sales Receipt Number
- KdObat (Foreign Key) - Drug Code
- Jumlah - Quantity Sold
```

**Pembelian (Purchase Table)**
```sql
- Nota (Primary Key) - Purchase Receipt Number
- TglNota - Transaction Date
- KdSupplier (Foreign Key) - Supplier Code
- Diskon - Discount Amount
```

**Pembelian_Detail (Purchase Detail Table)**
```sql
- Nota (Foreign Key) - Purchase Receipt Number
- KdObat (Foreign Key) - Drug Code
- Jumlah - Quantity Purchased
```

#### 3.2 **[MVP REQUIRED]** Additional Required Tables

**Users (System Users) - REQUIRED FOR MVP**
```sql
- user_id (Primary Key, Auto Increment)
- username (Unique, VARCHAR(50))
- password (Hashed, VARCHAR(255))
- user_type (ENUM: 'admin', 'apoteker', 'pelanggan')
- KdPelanggan (Foreign Key, Nullable) - Links to customer if user_type = 'pelanggan'
- is_active (Boolean, Default: 1)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

**Sessions (Security Sessions) - REQUIRED FOR MVP**
```sql
- session_id (Primary Key, VARCHAR(128))
- user_id (Foreign Key to Users)
- token (VARCHAR(255), Unique)
- expires_at (TIMESTAMP)
- created_at (TIMESTAMP)
```

#### 3.3 **[MVP REQUIRED]** Existing Table Modifications

**Tabel_Obat Additional Fields - REQUIRED FOR MVP**
```sql
- status (ENUM: 'active', 'inactive', Default: 'active') - Drug status
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

**All Existing Tables - Add Timestamps**
```sql
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

#### 3.4 **[FUTURE ENHANCEMENT]** Optional Tables for Later Phases

**Drug_Expiry (Drug Expiration Tracking)**
```sql
- expiry_id (Primary Key, Auto Increment)
- KdObat (Foreign Key)
- batch_number
- expiry_date
- quantity
- created_at
```

### 4. Functional Requirements

#### 4.1 Authentication & Authorization
- **Login System:** Secure login for all user types
- **Registration:** Customer self-registration, Admin-managed pharmacist registration
- **Session Management:** Secure session handling with appropriate timeouts
- **Role-Based Access:** Strict permission enforcement based on user roles

#### 4.2 Drug Management
- **Drug Catalog:** Complete drug information management
- **Inventory Tracking:** Real-time stock level monitoring
- **Expiry Management:** Track and alert for expiring drugs
- **Search Functionality:** Advanced drug search by name, category, supplier
- **Status Management:** Enable/disable drugs in the system

#### 4.3 Sales Management
- **Transaction Processing:** Complete sales transaction workflow
- **Receipt Generation:** Automatic receipt/invoice generation
- **Discount Application:** Flexible discount system
- **Sales History:** Comprehensive sales tracking and history
- **Reporting:** Sales reports by date, drug, customer, pharmacist

#### 4.4 Purchase Management
- **Purchase Orders:** Create and manage supplier purchase orders
- **Inventory Receiving:** Process incoming inventory from suppliers
- **Purchase History:** Track all purchase transactions
- **Supplier Performance:** Monitor supplier delivery and pricing

#### 4.5 Customer Management
- **Customer Database:** Maintain customer information
- **Purchase History:** Track customer purchase patterns
- **Customer Service:** Support customer inquiries and issues

### 5. Page Requirements

#### 5.1 Public Pages
- **Home Page:** Drug catalog display with search functionality
- **Drug Details Page:** Detailed drug information including price and availability
- **Customer Registration:** Self-service customer account creation
- **Login Page:** Universal login for all user types

#### 5.2 Admin Dashboard Pages
- **Admin Dashboard:** System overview with key metrics
- **Drug Management:** Add/edit/delete drugs, manage drug status
- **Pharmacist Management:** Register and manage pharmacist accounts
- **Supplier Management:** Maintain supplier database
- **Customer Management:** View and manage customer accounts
- **Purchase Management:** Create and track purchase orders
- **Sales Reports:** Comprehensive sales analytics and reporting
- **Expiry Alerts:** Monitor and manage expiring drugs
- **Inventory Reports:** Stock levels and reorder alerts

#### 5.3 Pharmacist Dashboard Pages
- **Pharmacist Dashboard:** Daily operations overview
- **Sales Processing:** Create new sales transactions
- **Drug Search:** Quick drug lookup and information
- **Inventory Management:** Add new stock, update quantities
- **Sales History:** View transaction history
- **Expiry Management:** Handle expired drug removal
- **Customer Service:** Support customer inquiries

#### 5.4 Customer Pages
- **Customer Dashboard:** Personal account overview
- **Drug Catalog:** Browse available medications
- **Purchase History:** View past purchases
- **Account Settings:** Update personal information

### 6. Technical Requirements

#### 6.1 Technology Stack
- **Project Name:** Dr. CRUD (Pharmacy CRUD Operations System)
- **Backend:** PHP (minimum version 7.4+)
- **Frontend:** HTML5, CSS3, JavaScript (ES6+)
- **CSS Framework:** Bootstrap (required - version 4.x or 5.x)
- **UI Template:** **MANDATORY** - Must use Bootstrap-based admin template such as:
  - SB Admin 2
  - AdminLTE
  - CoreUI
  - Material Dashboard Bootstrap
  - Volt Bootstrap Dashboard
- **Database:** MySQL/MariaDB (using db_apotek database)
- **Security:** Password hashing, SQL injection prevention, XSS protection

#### 6.3 Performance Requirements
- **Response Time:** Page load times under 3 seconds
- **Concurrent Users:** Support minimum 50 concurrent users
- **Database:** Optimized queries with proper indexing
- **Security:** HTTPS encryption, secure authentication

#### 6.4 UI/UX Requirements (MANDATORY)

#### Template Requirements
- **Bootstrap Framework:** All pages must be built using Bootstrap CSS framework
- **Pre-built Template:** Custom CSS from scratch is NOT allowed - must use existing Bootstrap admin template
- **Responsive Design:** Template must be mobile-responsive and work across devices
- **Professional Appearance:** Template should provide professional, clean admin dashboard look

#### Recommended Templates
1. **SB Admin 2** - Popular free Bootstrap admin template
2. **AdminLTE** - Feature-rich Bootstrap admin template
3. **CoreUI** - Modern Bootstrap admin template
4. **Material Dashboard Bootstrap** - Material design Bootstrap template
5. **Volt Bootstrap Dashboard** - Clean and modern Bootstrap template

#### Template Integration Requirements
- All system pages must follow the chosen template's structure
- Maintain consistency in navigation, sidebars, and layout components
- Customize template colors/branding as needed while keeping core structure
- Ensure all forms, tables, and components use template's Bootstrap classes
- Chrome (latest 2 versions)
- Firefox (latest 2 versions)
- Safari (latest 2 versions)
- Edge (latest 2 versions)

### 7. Security Requirements

- **Authentication:** Strong password policies, session management
- **Authorization:** Role-based access control with proper permission checking
- **Data Protection:** Encrypted sensitive data, secure database connections
- **Input Validation:** Comprehensive input sanitization and validation
- **Audit Trail:** **[ENHANCEMENT]** Log critical system activities

### 8. Implementation Phases

#### Phase 1: Core System
- User authentication and role management
- Basic drug catalog and inventory
- Simple sales transaction processing

#### Phase 2: Advanced Features
- Comprehensive reporting system
- Expiry date management
- Advanced search and filtering

#### Phase 3: **[ENHANCEMENT]** Additional Features
- Audit trail and activity logging
- Advanced analytics and forecasting
- Mobile-responsive design optimization

### 9. Success Metrics

- **User Adoption:** 100% of pharmacy staff actively using Dr. CRUD
- **Transaction Accuracy:** 99.9% accurate sales and inventory tracking
- **System Uptime:** 99.5% system availability
- **User Satisfaction:** Positive feedback from 90% of users
- **CRUD Operations:** Seamless Create, Read, Update, Delete functionality across all modules

### 10. **[ENHANCEMENT]** Future Considerations

- Integration with external pharmacy databases
- Mobile application development
- Advanced analytics and business intelligence
- Multi-location support for pharmacy chains
- Integration with insurance and payment systems

---

**Note:** Items marked with **[ENHANCEMENT]** are recommended additions to the original requirements that would significantly improve system functionality and user experience while maintaining compatibility with the existing database schema.