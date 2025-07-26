# MVP Architecture & Development Strategy
## Dr. CRUD - Pharmacy Management System

### **Project Goal: 1-Week MVP Delivery**

**Timeline:** 7 days to functional pharmacy management system
**Priority:** Speed and agility over sophisticated architecture
**Target:** Basic CRUD operations with professional UI

---

## **Core Architecture: Simple MVC + Component Pattern**

### **Folder Structure**
```
📁 dr-crud-laravel/
├── 📁 config/                 # Configuration files
│   ├── database.php           # Database connection settings
│   ├── app.php               # Application constants
│   └── auth.php              # Authentication settings
│
├── 📁 core/                   # Core system classes
│   ├── Database.php          # DB connection singleton
│   ├── Router.php            # Simple routing system
│   ├── Auth.php              # Authentication handler
│   ├── View.php              # Template renderer
│   └── Validator.php         # Input validation
│
├── 📁 models/                 # Data models (1 per table)
│   ├── User.php              # Users table
│   ├── Drug.php              # Tabel_Obat
│   ├── Customer.php          # Tabel_Pelanggan  
│   ├── Supplier.php          # Tabel_Supplier
│   ├── Sale.php              # Penjualan
│   └── Purchase.php          # Pembelian
│
├── 📁 controllers/            # Business logic controllers
│   ├── AuthController.php    # Login/logout/register
│   ├── AdminController.php   # Admin dashboard & management
│   ├── PharmacistController.php # Pharmacist operations
│   ├── CustomerController.php   # Customer portal
│   ├── DrugController.php    # Drug management
│   ├── SaleController.php    # Sales transactions
│   └── ReportController.php  # Reports & analytics
│
├── 📁 views/                  # PHP templates using Sneat
│   ├── 📁 layouts/           # Common layouts
│   │   ├── header.php        # Common header
│   │   ├── sidebar.php       # Navigation sidebar
│   │   └── footer.php        # Common footer
│   ├── 📁 auth/              # Authentication pages
│   │   ├── login.php         # Login form
│   │   └── register.php      # Registration form
│   ├── 📁 admin/             # Admin dashboard pages
│   ├── 📁 pharmacist/        # Pharmacist pages
│   ├── 📁 customer/          # Customer pages
│   └── 📁 components/        # Reusable components
│       ├── drug-card.php     # Drug display card
│       ├── data-table.php    # Data table component
│       └── modal-form.php    # Modal form component
│
├── 📁 api/                    # AJAX endpoints
│   ├── drugs.php             # Drug search/filter
│   ├── sales.php             # Sales operations
│   └── validation.php        # Form validation
│
├── 📁 public/                 # Web assets + entry point
│   ├── index.php             # Application entry point
│   ├── 📁 assets/            # Sneat template assets
│   └── 📁 libs/              # JavaScript libraries
│
└── 📁 database/              # Database files
    ├── schema.sql            # Database structure
    ├── seed.sql              # Sample data
    └── migrations/           # Database changes
```

---

## **Development Strategy: Speed-Focused Approach**

### **1. No Framework Overhead**
- **Pure PHP**: Minimal abstractions, maximum control
- **Direct SQL**: No ORM complexity, direct database queries
- **Simple Templates**: PHP includes with Sneat Bootstrap templates
- **Minimal Dependencies**: Only essential libraries

### **2. Feature-Based Development Pattern**
```
Each Feature = Controller + Model + Views + API endpoint
```

**Development Workflow:**
1. Copy relevant Sneat template
2. Add PHP logic and database integration
3. Implement AJAX for dynamic features
4. Test and integrate

### **3. Component Reusability**
- **Header/Sidebar/Footer**: Shared across all pages
- **Data Tables**: Reusable table component for listings
- **Forms**: Standardized form components
- **Modals**: Popup forms for quick actions

### **4. Database Strategy**
- **Simple Models**: Direct SQL queries, no complex relationships
- **Prepared Statements**: Security without ORM overhead  
- **Connection Pooling**: Single database connection class
- **Minimal Migrations**: Direct SQL files for schema changes

---

## **7-Day Development Sprint**

### **Day 1-2: Foundation & Authentication**
- ✅ Database setup with MVP tables
- ✅ Core classes (Database, Auth, Router, View)  
- ✅ Login/logout system
- ✅ User registration and role management
- ✅ Session handling

### **Day 3-4: Drug Management**
- ✅ Drug CRUD operations (Create, Read, Update, Delete)
- ✅ Drug search and filtering
- ✅ Inventory management interface
- ✅ Supplier management
- ✅ Drug status management (active/inactive)

### **Day 5-6: Sales & Transactions**
- ✅ Sales transaction processing
- ✅ Customer management
- ✅ Sales history and reporting
- ✅ Purchase order management
- ✅ Basic reporting dashboard

### **Day 7: Testing & Polish**
- ✅ End-to-end testing for all user roles
- ✅ UI/UX improvements
- ✅ Security validation
- ✅ Performance optimization
- ✅ Deployment preparation

---

## **Technical Decisions for Speed**

### **Frontend Strategy**
- **Bootstrap + Sneat**: Professional UI without custom CSS
- **jQuery**: Fast DOM manipulation and AJAX
- **Minimal JavaScript**: Focus on essential interactions
- **Server-Side Rendering**: PHP templates for faster development

### **Backend Strategy**
- **Procedural + OOP Hybrid**: Simple where possible, objects where beneficial
- **Direct SQL**: No query builder complexity
- **File-based Sessions**: Avoid database session overhead
- **Simple Routing**: URL mapping without complex patterns

### **Security Approach**
- **Prepared Statements**: SQL injection prevention
- **Password Hashing**: bcrypt for user passwords
- **Session Validation**: Secure session management
- **Input Sanitization**: XSS prevention
- **Role-based Access**: Simple permission checking

---

## **Key Benefits of This Architecture**

### **Speed Advantages**
- ✅ **Minimal Learning Curve**: Standard PHP patterns
- ✅ **Fast Template Integration**: Direct Sneat template usage
- ✅ **Direct Database Control**: No abstraction layers
- ✅ **Easy Debugging**: Clear, traceable code flow
- ✅ **Rapid Prototyping**: Copy-paste and customize approach

### **MVP Suitability**
- ✅ **Quick Iterations**: Easy to modify and extend
- ✅ **Clear Structure**: Easy for team collaboration
- ✅ **Bootstrap Ready**: Professional UI out of the box
- ✅ **Scalable Foundation**: Can evolve into more complex architecture
- ✅ **Maintainable**: Simple enough for ongoing development

---

## **Success Metrics**

**Technical Goals:**
- All CRUD operations functional
- Role-based access working
- Professional UI across all pages
- Basic reporting available
- Security measures implemented

**Timeline Goals:**
- Day 1-2: 30% completion (Auth + Foundation)
- Day 3-4: 60% completion (+ Drug Management)  
- Day 5-6: 90% completion (+ Sales & Transactions)
- Day 7: 100% completion (Testing & Polish)

---

**Note:** This architecture prioritizes delivery speed and MVP functionality over sophisticated design patterns. It provides a solid foundation that can be refactored and enhanced in future iterations while meeting the 1-week deadline requirement.