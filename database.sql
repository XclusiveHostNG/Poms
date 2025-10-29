-- Political Organisation Management System Database Schema
-- Generated schema for initial project setup

CREATE DATABASE IF NOT EXISTS poms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE poms;

-- Table to store site level configuration
CREATE TABLE IF NOT EXISTS site_settings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    site_name VARCHAR(150) NOT NULL DEFAULT 'Political Organisation Management System',
    site_tagline VARCHAR(255) DEFAULT NULL,
    logo_path VARCHAR(255) DEFAULT NULL,
    favicon_path VARCHAR(255) DEFAULT NULL,
    support_email VARCHAR(150) DEFAULT NULL,
    support_phone VARCHAR(50) DEFAULT NULL,
    whatsapp_default_link VARCHAR(255) DEFAULT NULL,
    allow_international_registration TINYINT(1) NOT NULL DEFAULT 1,
    maintenance_mode TINYINT(1) NOT NULL DEFAULT 0,
    address TEXT,
    facebook_url VARCHAR(255) DEFAULT NULL,
    twitter_url VARCHAR(255) DEFAULT NULL,
    instagram_url VARCHAR(255) DEFAULT NULL,
    youtube_url VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- States metadata for Nigerian regions (simplified)
CREATE TABLE IF NOT EXISTS states (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(10) NOT NULL,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS local_governments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    state_id INT UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (state_id) REFERENCES states(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS wards (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lga_id INT UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (lga_id) REFERENCES local_governments(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS polling_units (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ward_id INT UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ward_id) REFERENCES wards(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Generic roles and permissions tables for RBAC
CREATE TABLE IF NOT EXISTS roles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS permissions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL UNIQUE,
    description VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS role_permissions (
    role_id INT UNSIGNED NOT NULL,
    permission_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Admins table
CREATE TABLE IF NOT EXISTS admins (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    other_name VARCHAR(100) DEFAULT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mobile_number VARCHAR(20) DEFAULT NULL,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role_id INT UNSIGNED DEFAULT NULL,
    status ENUM('active','inactive','suspended') DEFAULT 'active',
    last_login_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Shared demographic fields definition
-- Users table (general members)
CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    other_name VARCHAR(100) DEFAULT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mobile_number VARCHAR(20) DEFAULT NULL,
    address TEXT,
    city VARCHAR(120) DEFAULT NULL,
    state VARCHAR(100) DEFAULT NULL,
    local_government_area VARCHAR(150) DEFAULT NULL,
    ward VARCHAR(150) DEFAULT NULL,
    polling_unit VARCHAR(150) DEFAULT NULL,
    senatorial_district VARCHAR(150) DEFAULT NULL,
    house_of_representative VARCHAR(150) DEFAULT NULL,
    country VARCHAR(100) DEFAULT 'Nigeria',
    occupation VARCHAR(150) DEFAULT NULL,
    education_level VARCHAR(100) DEFAULT NULL,
    annual_monthly_income DECIMAL(12,2) DEFAULT NULL,
    date_of_birth DATE DEFAULT NULL,
    bvn VARCHAR(20) DEFAULT NULL,
    nin VARCHAR(20) DEFAULT NULL,
    security_pin CHAR(6) NOT NULL,
    drivers_license_number VARCHAR(50) DEFAULT NULL,
    voters_card_number VARCHAR(50) DEFAULT NULL,
    ready_for_whatsapp ENUM('yes','no') DEFAULT 'no',
    apc_member ENUM('yes','no') DEFAULT 'no',
    unique_identification_number VARCHAR(30) NOT NULL UNIQUE,
    accept_terms TINYINT(1) NOT NULL DEFAULT 0,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    profile_photo VARCHAR(255) DEFAULT NULL,
    kyc_status ENUM('pending','approved','rejected') DEFAULT 'pending',
    onboarding_completed TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Aspirants table
CREATE TABLE IF NOT EXISTS aspirants (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    other_name VARCHAR(100) DEFAULT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mobile_number VARCHAR(20) DEFAULT NULL,
    address TEXT,
    city VARCHAR(120) DEFAULT NULL,
    state VARCHAR(100) DEFAULT NULL,
    local_government_area VARCHAR(150) DEFAULT NULL,
    ward VARCHAR(150) DEFAULT NULL,
    polling_unit VARCHAR(150) DEFAULT NULL,
    senatorial_district VARCHAR(150) DEFAULT NULL,
    house_of_representative VARCHAR(150) DEFAULT NULL,
    country VARCHAR(100) DEFAULT 'Nigeria',
    occupation VARCHAR(150) DEFAULT NULL,
    education_level VARCHAR(100) DEFAULT NULL,
    annual_monthly_income DECIMAL(12,2) DEFAULT NULL,
    date_of_birth DATE DEFAULT NULL,
    bvn VARCHAR(20) DEFAULT NULL,
    nin VARCHAR(20) DEFAULT NULL,
    security_pin CHAR(6) NOT NULL,
    drivers_license_number VARCHAR(50) DEFAULT NULL,
    voters_card_number VARCHAR(50) DEFAULT NULL,
    ready_for_whatsapp ENUM('yes','no') DEFAULT 'no',
    apc_member ENUM('yes','no') DEFAULT 'no',
    unique_identification_number VARCHAR(30) NOT NULL UNIQUE,
    accept_terms TINYINT(1) NOT NULL DEFAULT 0,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    profile_photo VARCHAR(255) DEFAULT NULL,
    manifesto TEXT,
    kyc_status ENUM('pending','approved','rejected') DEFAULT 'pending',
    onboarding_completed TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- KYC submissions
CREATE TABLE IF NOT EXISTS kyc_documents (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    owner_type ENUM('user','aspirant') NOT NULL,
    owner_id INT UNSIGNED NOT NULL,
    document_type VARCHAR(100) NOT NULL,
    document_path VARCHAR(255) NOT NULL,
    status ENUM('pending','approved','rejected') DEFAULT 'pending',
    reviewed_by INT UNSIGNED DEFAULT NULL,
    reviewed_at DATETIME DEFAULT NULL,
    remarks TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reviewed_by) REFERENCES admins(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Whatsapp groups per region
CREATE TABLE IF NOT EXISTS whatsapp_groups (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    state VARCHAR(100) NOT NULL,
    region VARCHAR(150) DEFAULT NULL,
    link VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Events table
CREATE TABLE IF NOT EXISTS events (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    venue VARCHAR(255) DEFAULT NULL,
    state VARCHAR(100) DEFAULT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME DEFAULT NULL,
    created_by_type ENUM('admin','aspirant') NOT NULL,
    created_by_id INT UNSIGNED NOT NULL,
    cover_image VARCHAR(255) DEFAULT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Campaigns table
CREATE TABLE IF NOT EXISTS campaigns (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    aspirant_id INT UNSIGNED NOT NULL,
    title VARCHAR(200) NOT NULL,
    summary TEXT,
    target_amount DECIMAL(14,2) DEFAULT NULL,
    amount_raised DECIMAL(14,2) NOT NULL DEFAULT 0,
    status ENUM('draft','active','completed','cancelled') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (aspirant_id) REFERENCES aspirants(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Donations
CREATE TABLE IF NOT EXISTS donations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    campaign_id INT UNSIGNED NOT NULL,
    donor_type ENUM('user','aspirant','anonymous') NOT NULL,
    donor_id INT UNSIGNED DEFAULT NULL,
    amount DECIMAL(14,2) NOT NULL,
    payment_reference VARCHAR(150) NOT NULL,
    status ENUM('pending','successful','failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (campaign_id) REFERENCES campaigns(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Blog posts
CREATE TABLE IF NOT EXISTS blog_posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL UNIQUE,
    excerpt TEXT,
    body LONGTEXT,
    featured_image VARCHAR(255) DEFAULT NULL,
    author_type ENUM('admin','aspirant') NOT NULL DEFAULT 'admin',
    author_id INT UNSIGNED DEFAULT NULL,
    published_at DATETIME DEFAULT NULL,
    status ENUM('draft','published','archived') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- FAQs
CREATE TABLE IF NOT EXISTS faqs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(255) NOT NULL,
    answer TEXT NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Manifestoes
CREATE TABLE IF NOT EXISTS manifestoes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    body LONGTEXT NOT NULL,
    created_by_type ENUM('admin','aspirant') NOT NULL,
    created_by_id INT UNSIGNED NOT NULL,
    published_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Contact messages
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    subject VARCHAR(200) DEFAULT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('new','in_progress','resolved') DEFAULT 'new'
) ENGINE=InnoDB;

-- ID card applications
CREATE TABLE IF NOT EXISTS id_card_applications (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    applicant_type ENUM('user','aspirant') NOT NULL,
    applicant_id INT UNSIGNED NOT NULL,
    application_status ENUM('pending','approved','rejected') DEFAULT 'pending',
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    processed_by INT UNSIGNED DEFAULT NULL,
    processed_at DATETIME DEFAULT NULL,
    remarks TEXT,
    FOREIGN KEY (processed_by) REFERENCES admins(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Event registrations
CREATE TABLE IF NOT EXISTS event_registrations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id INT UNSIGNED NOT NULL,
    attendee_type ENUM('user','aspirant') NOT NULL,
    attendee_id INT UNSIGNED NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Audit logs
CREATE TABLE IF NOT EXISTS audit_logs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    actor_type ENUM('admin','user','aspirant') NOT NULL,
    actor_id INT UNSIGNED NOT NULL,
    action VARCHAR(200) NOT NULL,
    description TEXT,
    ip_address VARCHAR(45) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Seed minimal data
INSERT INTO site_settings (site_name, site_tagline, support_email, support_phone, allow_international_registration)
VALUES ('Political Organisation Management System', 'Empowering democratic participation through innovative political organization management.', 'support@poms.org', '+234-000-0000', 1)
ON DUPLICATE KEY UPDATE updated_at = CURRENT_TIMESTAMP;

INSERT INTO roles (name, description) VALUES ('Super Admin', 'Full platform access')
ON DUPLICATE KEY UPDATE description = VALUES(description);

