-- Political Organisation Management System Database Schema

CREATE DATABASE IF NOT EXISTS poms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE poms;

-- Site settings table
CREATE TABLE IF NOT EXISTS site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(100) NOT NULL UNIQUE,
    `value` TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO site_settings (`key`, `value`) VALUES
    ('site_title', 'Political Organisation Management System'),
    ('site_tagline', 'Empowering democratic participation through innovative political organisation management'),
    ('support_email', 'support@poms.org'),
    ('support_phone', '+2348000000000'),
    ('office_address', '12 Unity Avenue, Abuja, Nigeria'),
    ('allow_international_registration', '1')
ON DUPLICATE KEY UPDATE `value` = VALUES(`value`);

-- User authentication accounts
CREATE TABLE IF NOT EXISTS users_auth (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('member', 'aspirant', 'admin') NOT NULL DEFAULT 'member',
    last_login_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Members table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    auth_id INT NOT NULL,
    first_name VARCHAR(120) NOT NULL,
    last_name VARCHAR(120) NOT NULL,
    other_name VARCHAR(120) NULL,
    email VARCHAR(150) NOT NULL,
    mobile_number VARCHAR(50) NOT NULL,
    address VARCHAR(255) NULL,
    city VARCHAR(120) NULL,
    state VARCHAR(120) NULL,
    local_government_area VARCHAR(150) NULL,
    ward VARCHAR(120) NULL,
    polling_unit VARCHAR(150) NULL,
    senatorial_district VARCHAR(150) NULL,
    house_of_representative VARCHAR(150) NULL,
    country VARCHAR(120) NOT NULL DEFAULT 'Nigeria',
    occupation VARCHAR(120) NULL,
    level_of_education VARCHAR(60) NULL,
    annual_income VARCHAR(120) NULL,
    date_of_birth DATE NULL,
    bvn VARCHAR(20) NULL,
    nin VARCHAR(20) NULL,
    six_digit_pin VARCHAR(6) NULL,
    driver_license_number VARCHAR(60) NULL,
    voters_card_number VARCHAR(60) NULL,
    whatsapp_group_opt_in ENUM('yes', 'no') NOT NULL DEFAULT 'no',
    apc_member ENUM('yes', 'no') NOT NULL DEFAULT 'no',
    unique_identification_number VARCHAR(30) NOT NULL UNIQUE,
    accepted_terms TINYINT(1) NOT NULL DEFAULT 0,
    onboarding_status ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
    kyc_status ENUM('pending', 'verified', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_users_auth FOREIGN KEY (auth_id) REFERENCES users_auth(id) ON DELETE CASCADE
);

-- Aspirants table
CREATE TABLE IF NOT EXISTS aspirants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    auth_id INT NOT NULL,
    first_name VARCHAR(120) NOT NULL,
    last_name VARCHAR(120) NOT NULL,
    other_name VARCHAR(120) NULL,
    email VARCHAR(150) NOT NULL,
    mobile_number VARCHAR(50) NOT NULL,
    address VARCHAR(255) NULL,
    city VARCHAR(120) NULL,
    state VARCHAR(120) NULL,
    local_government_area VARCHAR(150) NULL,
    ward VARCHAR(120) NULL,
    polling_unit VARCHAR(150) NULL,
    senatorial_district VARCHAR(150) NULL,
    house_of_representative VARCHAR(150) NULL,
    country VARCHAR(120) NOT NULL,
    occupation VARCHAR(120) NULL,
    level_of_education VARCHAR(60) NULL,
    annual_income VARCHAR(120) NULL,
    date_of_birth DATE NULL,
    bvn VARCHAR(20) NULL,
    nin VARCHAR(20) NULL,
    six_digit_pin VARCHAR(6) NULL,
    driver_license_number VARCHAR(60) NULL,
    voters_card_number VARCHAR(60) NULL,
    whatsapp_group_opt_in ENUM('yes', 'no') NOT NULL DEFAULT 'no',
    apc_member ENUM('yes', 'no') NOT NULL DEFAULT 'no',
    unique_identification_number VARCHAR(30) NOT NULL UNIQUE,
    accepted_terms TINYINT(1) NOT NULL DEFAULT 0,
    kyc_status ENUM('pending', 'verified', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_aspirants_auth FOREIGN KEY (auth_id) REFERENCES users_auth(id) ON DELETE CASCADE
);

-- Administrators table
CREATE TABLE IF NOT EXISTS administrators (
    id INT AUTO_INCREMENT PRIMARY KEY,
    auth_id INT NOT NULL,
    first_name VARCHAR(120) NOT NULL,
    last_name VARCHAR(120) NOT NULL,
    email VARCHAR(150) NOT NULL,
    mobile_number VARCHAR(50) NULL,
    role_title VARCHAR(120) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_administrators_auth FOREIGN KEY (auth_id) REFERENCES users_auth(id) ON DELETE CASCADE
);

-- Roles & permissions
CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL UNIQUE,
    description VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL UNIQUE,
    description VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS role_permissions (
    role_id INT NOT NULL,
    permission_id INT NOT NULL,
    PRIMARY KEY (role_id, permission_id),
    CONSTRAINT fk_role_permissions_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    CONSTRAINT fk_role_permissions_permission FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS admin_roles (
    admin_id INT NOT NULL,
    role_id INT NOT NULL,
    PRIMARY KEY (admin_id, role_id),
    CONSTRAINT fk_admin_roles_admin FOREIGN KEY (admin_id) REFERENCES administrators(id) ON DELETE CASCADE,
    CONSTRAINT fk_admin_roles_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

-- Events
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_by INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    description TEXT NULL,
    event_date DATETIME NOT NULL,
    venue VARCHAR(200) NULL,
    state VARCHAR(120) NULL,
    lga VARCHAR(120) NULL,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_events_creator FOREIGN KEY (created_by) REFERENCES users_auth(id) ON DELETE SET NULL
);

-- Campaigns
CREATE TABLE IF NOT EXISTS campaigns (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aspirant_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    objective TEXT NULL,
    budget DECIMAL(15,2) NULL,
    status ENUM('draft', 'active', 'completed', 'archived') DEFAULT 'draft',
    start_date DATE NULL,
    end_date DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_campaigns_aspirant FOREIGN KEY (aspirant_id) REFERENCES aspirants(id) ON DELETE CASCADE
);

-- Donations
CREATE TABLE IF NOT EXISTS donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    campaign_id INT NOT NULL,
    donor_name VARCHAR(150) NULL,
    amount DECIMAL(15,2) NOT NULL,
    donated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_donations_campaign FOREIGN KEY (campaign_id) REFERENCES campaigns(id) ON DELETE CASCADE
);

-- KYC submissions
CREATE TABLE IF NOT EXISTS kyc_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    auth_id INT NOT NULL,
    document_type VARCHAR(100) NOT NULL,
    document_path VARCHAR(255) NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    remarks TEXT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    reviewed_at TIMESTAMP NULL,
    CONSTRAINT fk_kyc_auth FOREIGN KEY (auth_id) REFERENCES users_auth(id) ON DELETE CASCADE
);

-- WhatsApp group links
CREATE TABLE IF NOT EXISTS whatsapp_groups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    state VARCHAR(120) NOT NULL,
    region VARCHAR(120) NULL,
    group_link VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Blog posts
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL UNIQUE,
    excerpt TEXT NULL,
    content LONGTEXT NULL,
    featured_image VARCHAR(255) NULL,
    status ENUM('draft', 'published') DEFAULT 'draft',
    author_id INT NULL,
    published_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_posts_author FOREIGN KEY (author_id) REFERENCES administrators(id) ON DELETE SET NULL
);

-- Manifestoes
CREATE TABLE IF NOT EXISTS manifestoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    summary TEXT NULL,
    content LONGTEXT NULL,
    published_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- FAQs
CREATE TABLE IF NOT EXISTS faqs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(255) NOT NULL,
    answer TEXT NOT NULL,
    status ENUM('draft', 'published') DEFAULT 'published',
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Password resets
CREATE TABLE IF NOT EXISTS password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NULL
);

-- Galleries
CREATE TABLE IF NOT EXISTS galleries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed example data for manifestoes, posts, and faqs
INSERT INTO manifestoes (title, summary, content, published_at) VALUES
    ('Inclusive Governance', 'A blueprint for inclusive political participation at all levels.', 'Full manifesto content goes here.', NOW()),
    ('Economic Empowerment', 'Strategies to grow jobs and support small businesses.', 'Full manifesto content goes here.', NOW())
ON DUPLICATE KEY UPDATE summary = VALUES(summary);

INSERT INTO faqs (question, answer, status, display_order) VALUES
    ('How do I become a member?', 'Complete the registration form and verify your contact details.', 'published', 1),
    ('What documents are required for KYC?', 'You will need a valid government-issued ID and proof of address.', 'published', 2)
ON DUPLICATE KEY UPDATE answer = VALUES(answer);
