# MVP Features by User Role
## Dr. CRUD - Pharmacy Management System

### **MVP Scope: 1-Week Development Timeline**

**Development Priority:** Core CRUD operations with essential business logic
**Target:** Functional pharmacy system with role-based access control

---

## **🔐 Authentication System (Universal)**

### **Login & Session Management**
- ✅ **Login Form** - Universal login for all user types
- ✅ **Session Management** - Secure session handling with timeout
- ✅ **Role Detection** - Automatic redirect based on user_type  
- ✅ **Logout** - Secure session termination
- ✅ **Password Security** - Hashed password storage

**Pages:** `login.php`, `logout.php`
**Controllers:** `AuthController.php`
**Models:** `User.php`

---

## **👤 Admin Role Features**

### **🏠 Admin Dashboard**
- ✅ **System Overview** - Key metrics and statistics
- ✅ **Quick Actions** - Fast access to common tasks
- ✅ **Recent Activity** - Latest system activities
- ✅ **Alerts** - Low stock, expiring drugs, system notifications

### **👥 User Management**  
- ✅ **Pharmacist Registration** - Create new pharmacist accounts
- ✅ **User List** - View all system users (admin, pharmacist)
- ✅ **User Status** - Enable/disable user accounts
- ✅ **Password Reset** - Reset user passwords

### **💊 Drug Management (Full Control)**
- ✅ **Add New Drug** - Complete drug information entry
- ✅ **Edit Drug** - Update drug details, pricing, stock
- ✅ **Delete Drug** - Remove drugs from system
- ✅ **Drug Status** - Set active/inactive status
- ✅ **Drug List** - Searchable table with all drugs
- ✅ **Stock Management** - Update stock levels

### **🏢 Supplier Management**
- ✅ **Add Supplier** - Register new suppliers
- ✅ **Edit Supplier** - Update supplier information
- ✅ **Supplier List** - View all suppliers
- ✅ **Supplier Status** - Manage supplier relationships

### **👥 Customer Management**
- ✅ **Customer List** - View all registered customers
- ✅ **Customer Details** - View customer information and history
- ✅ **Customer Search** - Find customers by name/phone

### **📊 Sales Reports**
- ✅ **Daily Sales** - Sales summary by date
- ✅ **Sales by Drug** - Top selling medications
- ✅ **Sales by Pharmacist** - Performance tracking
- ✅ **Revenue Reports** - Income analysis

### **📦 Purchase Management**
- ✅ **Create Purchase Order** - Order from suppliers
- ✅ **Purchase History** - View all purchase transactions
- ✅ **Supplier Performance** - Track delivery and pricing

**Pages:**
- `admin/dashboard.php`
- `admin/users.php`, `admin/user-form.php`
- `admin/drugs.php`, `admin/drug-form.php`
- `admin/suppliers.php`, `admin/supplier-form.php`
- `admin/customers.php`
- `admin/reports.php`
- `admin/purchases.php`

**Controllers:** `AdminController.php`, `DrugController.php`, `ReportController.php`

---

## **⚕️ Pharmacist Role Features**

### **🏠 Pharmacist Dashboard**
- ✅ **Daily Overview** - Today's sales, stock alerts
- ✅ **Quick Drug Search** - Fast drug lookup
- ✅ **Recent Transactions** - Latest sales activity
- ✅ **Stock Alerts** - Low stock notifications

### **💰 Sales Processing**
- ✅ **New Sale Transaction** - Process customer purchases
- ✅ **Drug Search** - Real-time drug search during sales
- ✅ **Calculate Total** - Automatic pricing with discounts
- ✅ **Receipt Generation** - Print/display sales receipt
- ✅ **Customer Selection** - Link sale to customer account

### **📋 Sales History**
- ✅ **Transaction List** - View all processed sales
- ✅ **Transaction Details** - Detailed view of each sale
- ✅ **Search/Filter** - Find transactions by date, customer, drug
- ✅ **Sales Summary** - Daily/weekly performance

### **💊 Drug Operations**
- ✅ **Drug Search** - Quick drug lookup with details
- ✅ **Add Stock** - Increase drug inventory
- ✅ **Update Drug Info** - Basic drug information updates
- ✅ **Stock Check** - Current inventory levels

### **👥 Customer Service**
- ✅ **Customer Registration** - Register new customers during sales
- ✅ **Customer Lookup** - Find existing customers
- ✅ **Purchase History** - View customer buying patterns

**Pages:**
- `pharmacist/dashboard.php`
- `pharmacist/sales.php`, `pharmacist/new-sale.php`
- `pharmacist/sales-history.php`
- `pharmacist/drugs.php`
- `pharmacist/customers.php`

**Controllers:** `PharmacistController.php`, `SaleController.php`

---

## **🛍️ Customer Role Features**

### **🏠 Customer Dashboard**
- ✅ **Personal Overview** - Account information summary
- ✅ **Recent Purchases** - Latest buying activity
- ✅ **Account Status** - Profile completion, activity

### **💊 Drug Catalog**
- ✅ **Browse Drugs** - View available medications
- ✅ **Drug Search** - Search by name, category, type
- ✅ **Drug Details** - Detailed drug information and pricing
- ✅ **Availability Check** - Stock status display

### **📋 Purchase History**
- ✅ **Transaction History** - All past purchases
- ✅ **Transaction Details** - Detailed view of each purchase
- ✅ **Search History** - Find past transactions

### **⚙️ Account Management**
- ✅ **Profile Settings** - Update personal information
- ✅ **Contact Information** - Update address, phone

**Pages:**
- `customer/dashboard.php`
- `customer/catalog.php`, `customer/drug-details.php`
- `customer/history.php`
- `customer/profile.php`

**Controllers:** `CustomerController.php`

---

## **🌐 Public Pages (No Authentication)**

### **Home & Information**
- ✅ **Home Page** - Drug catalog display for visitors
- ✅ **Drug Search** - Public drug search functionality
- ✅ **Drug Information** - View drug details and availability

### **Registration**
- ✅ **Customer Registration** - Self-service account creation
- ✅ **Registration Validation** - Input validation and verification

**Pages:**
- `index.php` (home)
- `register.php`
- `drug-catalog.php`

---

## **📊 Core Database Operations (All Roles)**

### **Essential CRUD Operations**

**Drugs (Tabel_Obat):**
- ✅ Create: Add new drugs
- ✅ Read: View drug details, search, list
- ✅ Update: Edit drug information, stock, pricing
- ✅ Delete: Remove drugs (Admin only)

**Sales (Penjualan + Penjualan_Detail):**
- ✅ Create: Process new sales transactions
- ✅ Read: View sales history, reports
- ✅ Update: Edit transaction details (limited)
- ✅ Delete: Cancel transactions (Admin only)

**Customers (Tabel_Pelanggan):**
- ✅ Create: Register new customers
- ✅ Read: View customer information, history
- ✅ Update: Edit customer details
- ✅ Delete: Remove customers (Admin only)

**Suppliers (Tabel_Supplier):**
- ✅ Create: Add new suppliers (Admin/Pharmacist)
- ✅ Read: View supplier information
- ✅ Update: Edit supplier details
- ✅ Delete: Remove suppliers (Admin only)

---

## **🔧 Technical Features (System-wide)**

### **Security & Validation**
- ✅ **Input Sanitization** - XSS prevention
- ✅ **SQL Injection Prevention** - Prepared statements
- ✅ **Role-based Access Control** - Page-level permissions
- ✅ **Session Security** - Secure session management

### **User Experience**
- ✅ **Responsive Design** - Mobile-friendly interface
- ✅ **Ajax Search** - Real-time search functionality
- ✅ **Form Validation** - Client & server-side validation
- ✅ **Success/Error Messages** - User feedback system

### **Performance**
- ✅ **Database Optimization** - Indexed queries
- ✅ **Caching** - Session and query caching
- ✅ **Lazy Loading** - Efficient data loading

---

## **📅 Development Schedule (7 Days)**

### **Day 1-2: Foundation (30%)**
- ✅ Database setup with all MVP tables
- ✅ Authentication system (login/logout/sessions)
- ✅ User management (Admin can create pharmacists)
- ✅ Basic dashboard templates for each role

### **Day 3-4: Core Features (60%)**
- ✅ Drug management (full CRUD for Admin/Pharmacist)
- ✅ Customer management (registration, editing)
- ✅ Supplier management (basic CRUD)
- ✅ Drug search and catalog display

### **Day 5-6: Business Logic (90%)**
- ✅ Sales transaction processing
- ✅ Sales history and reporting
- ✅ Purchase order management
- ✅ Customer portal (catalog browsing, history)

### **Day 7: Polish & Testing (100%)**
- ✅ UI/UX improvements
- ✅ Security testing and validation
- ✅ Performance optimization
- ✅ End-to-end testing for all roles

---

## **⚡ Out of Scope for MVP**

**Features to Skip (for speed):**
- ❌ Advanced reporting with charts/graphs
- ❌ Email notifications
- ❌ Drug expiry tracking (manual process)
- ❌ Automated reorder alerts
- ❌ Multi-location support
- ❌ Print receipt functionality (basic HTML receipt only)
- ❌ Advanced user permissions (role-based is sufficient)
- ❌ Audit trail logging
- ❌ Data export/import features

**Technical Debt Acceptable:**
- ❌ Code optimization (focus on functionality)
- ❌ Advanced error handling (basic is sufficient)
- ❌ Unit testing (manual testing only)
- ❌ Performance tuning (basic optimization only)

---

## **✅ Success Criteria**

**Functional Requirements:**
- All 3 user roles can login and access appropriate features
- Admin can manage drugs, users, suppliers, and view reports
- Pharmacist can process sales and manage inventory
- Customer can browse catalog and view purchase history
- All CRUD operations work correctly
- Role-based access control enforced

**Technical Requirements:**
- Professional UI using Sneat Bootstrap template
- Responsive design works on desktop and mobile
- Basic security measures implemented
- Database operations are secure and efficient
- System handles concurrent users appropriately

**Business Requirements:**
- Complete pharmacy workflow supported
- Sales transactions are accurate and traceable
- Inventory management is functional
- Customer information is properly managed
- Basic reporting provides business insights

---

**Note:** This feature set is designed for rapid MVP delivery while maintaining professional quality. Each feature has been scoped to essential functionality that can be implemented efficiently within the 1-week timeline.