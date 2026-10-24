const fs = require('fs');

const ADMIN_HASH = '$2y$10$UPbmy4f.5XRzoOuYdzuE8ueYVmbtHyUhr4v9ypKygnBkjl1qAg30K'; // Admin@MGM2026

function escapeSql(str) {
  if (str === null || str === undefined) return 'NULL';
  return "'" + String(str).replace(/\\/g, '\\\\').replace(/'/g, "\\'") + "'";
}

const wpIdMap = {
  'mandatory-disclosure': 16051,
  'yoga': 16043,
  'voice-of-mgm': 16036,
  'hindustan-scouts-guides': 16026,
  'swimming-pool': 16019,
  'ncc': 16013,
  'attendance': 16004,
  'admission-procedure': 15998,
  'alumni': 15992,
  'merit-day': 15985,
  'pta': 15979,
  'courses-offered': 15930,
  'our-founder': 15913,
  'gallery': 15937,
  'our-mission': 15908,
  'about-us': 10042
};

const admTableHtml = fs.readFileSync('audit/admission_table_rendered.html', 'utf8');
const crsTableHtml = fs.readFileSync('audit/courses_table_rendered.html', 'utf8');
const pages = JSON.parse(fs.readFileSync('audit/all_pages_clean.json', 'utf8'));

let sql = `-- ========================================================
-- MGM Model School Database Schema & Initial Data
-- Recreated PHP/MySQL Web Application
-- Compatible with MySQL 5.7+, MariaDB 10.3+, phpMyAdmin
-- ========================================================

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS audit_logs;
DROP TABLE IF EXISTS newsletter_subscribers;
DROP TABLE IF EXISTS enquiries;
DROP TABLE IF EXISTS admission_requirements;
DROP TABLE IF EXISTS courses;
DROP TABLE IF EXISTS gallery;
DROP TABLE IF EXISTS mandatory_disclosures;
DROP TABLE IF EXISTS navigation;
DROP TABLE IF EXISTS pages;
DROP TABLE IF EXISTS site_settings;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------------
-- 1. Users Table
-- --------------------------------------------------------
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin', 'editor') NOT NULL DEFAULT 'admin',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (username, email, password_hash, role) VALUES
('admin', 'admin@mgmschool.edu', ${escapeSql(ADMIN_HASH)}, 'admin');

-- --------------------------------------------------------
-- 2. Site Settings Table
-- --------------------------------------------------------
CREATE TABLE site_settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  setting_key VARCHAR(100) NOT NULL UNIQUE,
  setting_value TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO site_settings (setting_key, setting_value) VALUES
('site_title', 'MGM Model School - Ayiroor, Varkala'),
('school_name', 'MGM Model School'),
('school_tagline', 'A CAMPUS DESIGNED FOR LEARNING, GROWTH, AND CREATIVITY'),
('founder_name', 'Dr. P. K. Sukumaran'),
('trust_name', 'Aykia Pradayini Trust'),
('founded_year', '1983'),
('affiliation_no', 'CBSE Affiliation No. 930066'),
('school_address', 'MGM Model School, Ayiroor, Varkala 695310, Kerala, India'),
('phone_primary', '04702602193'),
('phone_secondary', '8891509590'),
('email_primary', 'mgmmodelschools@gmail.com'),
('email_secondary', 'mgmmodelschool@rediffmail.com'),
('logo_path', 'assets/images/cropped-1733381285-removebg-preview.png'),
('breadcrumb_bg', 'assets/images/breadcrumb-bg.jpg'),
('copyright_text', '© 2026 All rights reserved. MGM Model School Design & Developed By DigitalEdenzIndia.'),
('facebook_url', 'https://facebook.com/'),
('youtube_url', 'https://youtube.com/'),
('whatsapp_url', 'https://wa.me/918891509590');

-- --------------------------------------------------------
-- 3. Navigation Table (Menus with Parents & Children)
-- --------------------------------------------------------
CREATE TABLE navigation (
  id INT AUTO_INCREMENT PRIMARY KEY,
  label VARCHAR(100) NOT NULL,
  url VARCHAR(255) NOT NULL,
  parent_id INT DEFAULT NULL,
  sort_order INT DEFAULT 0,
  target VARCHAR(20) DEFAULT '_self',
  FOREIGN KEY (parent_id) REFERENCES navigation(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO navigation (id, label, url, parent_id, sort_order) VALUES
(1, 'Home', '/', NULL, 1),
(2, 'About Us', '#', NULL, 2),
(3, 'Academics', '#', NULL, 3),
(4, 'Activities', '#', NULL, 4),
(5, 'Mandatory Disclosure', '/mandatory-disclosure/', NULL, 5),
(6, 'Contact', '/about-us/', NULL, 6);

-- About Us Submenu
INSERT INTO navigation (label, url, parent_id, sort_order) VALUES
('Our Founder', '/our-founder/', 2, 1),
('Our Mission', '/our-mission/', 2, 2),
('About Us', '/about-us/', 2, 3);

-- Academics Submenu
INSERT INTO navigation (label, url, parent_id, sort_order) VALUES
('Courses Offered', '/courses-offered/', 3, 1),
('Admission Procedure', '/admission-procedure/', 3, 2),
('Attendance', '/attendance/', 3, 3);

-- Activities Submenu
INSERT INTO navigation (label, url, parent_id, sort_order) VALUES
('NCC', '/ncc/', 4, 1),
('Swimming Pool', '/swimming-pool/', 4, 2),
('Hindustan Scouts & Guides', '/hindustan-scouts-guides/', 4, 3),
('Voice Of MGM', '/voice-of-mgm/', 4, 4),
('Yoga', '/yoga/', 4, 5),
('Merit Day', '/merit-day/', 4, 6),
('PTA', '/pta/', 4, 7),
('Alumni', '/alumni/', 4, 8),
('Gallery', '/gallery/', 4, 9);

-- --------------------------------------------------------
-- 4. Mandatory Disclosures Table
-- --------------------------------------------------------
CREATE TABLE mandatory_disclosures (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  file_name VARCHAR(255) NOT NULL,
  file_url VARCHAR(255) NOT NULL,
  file_size VARCHAR(50) DEFAULT NULL,
  sort_order INT DEFAULT 0,
  is_active TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO mandatory_disclosures (title, file_name, file_url, file_size, sort_order) VALUES
('Saras 5.0', '1737025323273-SARAS-5.0.pdf', 'assets/docs/1737025323273-SARAS-5.0.pdf', '150 KB', 1),
('AFFILIATION', '1733382575212-AFFILIATION.pdf', 'assets/docs/1733382575212-AFFILIATION.pdf', '163 KB', 2),
('FEE STRUCTURE', '1750226400981-SCHOOL-FEE-2025-26.pdf', 'assets/docs/1750226400981-SCHOOL-FEE-2025-26.pdf', '31 KB', 3),
('CBSE Results (From 2019)', '1750226704411-cbse-results-from-2019.pdf', 'assets/docs/1750226704411-cbse-results-from-2019.pdf', '42 KB', 4),
('BUILDING SAFETY CERTIFICATE', '1733383672169-BUILDING-SAFETY-CERTIFICATE.pdf', 'assets/docs/1733383672169-BUILDING-SAFETY-CERTIFICATE.pdf', '62 KB', 5),
('FIRE SAFETY CERTIFICATE', '1733383617275-FIRE-SAFETY-CERTIFICATE.pdf', 'assets/docs/1733383617275-FIRE-SAFETY-CERTIFICATE.pdf', '51 KB', 6),
('SMC LIST', '1751885656740-smc-new.pdf', 'assets/docs/1751885656740-smc-new.pdf', '153 KB', 7),
('RECOGNITION LETTER', '1733383474258-RECOGNITION-LETTER.pdf', 'assets/docs/1733383474258-RECOGNITION-LETTER.pdf', '458 KB', 8),
('Trust Certificate', '1733383394165-Trust-Certificate.pdf', 'assets/docs/1733383394165-Trust-Certificate.pdf', '432 KB', 9),
('Vehicle Fitness Certificate', '1733383289468-Vehicle-Fitness-Certificate.pdf', 'assets/docs/1733383289468-Vehicle-Fitness-Certificate.pdf', '67 KB', 10),
('DEO Certificate', '1733383227929-DEO-Certificate.pdf', 'assets/docs/1733383227929-DEO-Certificate.pdf', '485 KB', 11),
('ACADEMIC CALENDAR', '1767005946446-Academic-Caledandar.pdf', 'assets/docs/1767005946446-Academic-Caledandar.pdf', '1.9 MB', 12);

-- --------------------------------------------------------
-- 5. Gallery Images Table
-- --------------------------------------------------------
CREATE TABLE gallery (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  caption TEXT DEFAULT NULL,
  image_path VARCHAR(255) NOT NULL,
  category VARCHAR(100) DEFAULT 'School Events',
  sort_order INT DEFAULT 0,
  is_active TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO gallery (title, caption, image_path, category, sort_order) VALUES
('Annual Day Celebrations', 'Students performing traditional art on stage', 'assets/images/1752478940.jpeg', 'Events', 1),
('Science & Robotics Exhibition', 'STEM innovation and practical experiments', 'assets/images/1756461341.jpg', 'Academics', 2),
('Sports Meet & Athletic Track', 'Inter-house athletic competitions', 'assets/images/1776764248.jpg', 'Sports', 3),
('Cultural Dance Performance', 'Classical dance presentation during youth festival', 'assets/images/1733377596.jpg', 'Culture', 4),
('Independence Day Parade', 'School band and scout troop ceremonial march', 'assets/images/1733387135.jpg', 'Celebrations', 5),
('Campus Architecture & Gardens', 'Serene and lush green school campus at Ayiroor', 'assets/images/1733374738.jpg', 'Campus', 6),
('Smart Classrooms', 'Digital teaching technology in interactive learning', 'assets/images/1741692636.jpeg', 'Infrastructure', 7),
('Library & Reading Room', 'Extensive collection of books and quiet study zone', 'assets/images/1741692913.jpg', 'Academics', 8),
('Yoga & Wellness Assembly', 'Morning mindfulness and wellness session', 'assets/images/1741693092.jpg', 'Wellness', 9),
('Swimming Pool Training', 'Professional aquatic coaching for students', 'assets/images/1741693179.jpg', 'Sports', 10),
('Art & Painting Workshop', 'Fostering aesthetic expression and creativity', 'assets/images/1751285591.jpeg', 'Arts', 11),
('Merit Day & Graduation', 'Recognizing top academic achievers and scholars', 'assets/images/1751285627.jpeg', 'Achievements', 12);

-- --------------------------------------------------------
-- 6. Courses Table
-- --------------------------------------------------------
CREATE TABLE courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  class_level VARCHAR(100) NOT NULL,
  stream_name VARCHAR(100) DEFAULT NULL,
  subjects TEXT NOT NULL,
  sort_order INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO courses (class_level, stream_name, subjects, sort_order) VALUES
('I - V', 'Primary', 'English, Hindi, Malayalam, Maths, E.V.S, IT, Music, Dance, Drawing, Chess, Karate, Painting, Culinary, Swimming, Robotics(from grade 3 onwards), Health & Physical Education, Yoga and Abacus.', 1),
('VI - VIII', 'Middle School', 'English, Hindi, Malayalam, Maths, Science, Social Science, AI, Health & Physical Education, Art Education and Life Skills, Karate, Chess, Yoga', 2),
('IX - X', 'Secondary', 'English, Hindi, Malayalam, Maths, Science & Technology, Social Science, AI, Health & Physical Education, Work Experience and Life Skills', 3),
('XI – XII', 'Group I - Science (Bio-Maths)', 'English, Physics, Chemistry, Biology, Mathematics', 4),
('XI – XII', 'Group II - Science (CS-Maths)', 'English, Physics, Chemistry, Mathematics, Computer Science', 5),
('XI – XII', 'Group III - Science (Bio-IP)', 'English, Physics, Chemistry, Biology, Informatics Practices', 6),
('XI – XII', 'Group IV - Science (Bio-Malayalam)', 'English, Physics, Chemistry, Biology, Malayalam', 7),
('XI – XII', 'Group V - Science (Bio-Psychology)', 'English, Physics, Chemistry, Biology, Psychology', 8),
('XI – XII', 'Group VI - Commerce (IP)', 'English, Accountancy, Business Studies, Economics, Informatics Practices', 9),
('XI – XII', 'Group VII - Commerce (Maths)', 'English, Accountancy, Business Studies, Economics, Mathematics', 10),
('XI – XII', 'Group VIII - Commerce (Malayalam)', 'English, Accountancy, Business Studies, Economics, Malayalam', 11),
('XI – XII', 'Group IX - Humanities (IP)', 'English, History, Geography, Economics, Informatics Practices', 12),
('XI – XII', 'Group X - Humanities (Maths)', 'English, History, Geography, Economics, Mathematics', 13),
('XI – XII', 'Group XI - Humanities (Malayalam)', 'English, History, Geography, Economics, Malayalam', 14),
('XI – XII', 'Group XII - Humanities (Psychology)', 'English, History, Geography, Economics, Psychology', 15);

-- --------------------------------------------------------
-- 7. Admission Requirements Table
-- --------------------------------------------------------
CREATE TABLE admission_requirements (
  id INT AUTO_INCREMENT PRIMARY KEY,
  class_level VARCHAR(100) NOT NULL,
  documents_required TEXT NOT NULL,
  sort_order INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO admission_requirements (class_level, documents_required, sort_order) VALUES
('Kids School', 'Birth Certificate, Aadhar card, 2 Photos', 1),
('LKG & UKG', 'Birth Certificate, Aadhar card, 2 Photos', 2),
('Class I', 'Birth Certificate, Aadhar card, 2 Photos', 3),
('Class II to IX', 'Promoted TC from previous School, Birth Certificate, Aadhar, Photo', 4),
('Class X & XII', 'Attested Copy of Report Card, Attested copy of TC, Reason for change of school, Documentary evidence in support of the reason for changing the school, Conduct Certificate from the previous school', 5),
('Class XI', 'Attested copy of mark list of class X exam, TC from the previous Institution, Conduct Certificate from the previous institution, 2 photos', 6);

-- --------------------------------------------------------
-- 8. Enquiries Table (Admission / Contact / Alumni Forms)
-- --------------------------------------------------------
CREATE TABLE enquiries (
  id INT AUTO_INCREMENT PRIMARY KEY,
  type ENUM('admission', 'contact', 'alumni') DEFAULT 'admission',
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) DEFAULT NULL,
  phone VARCHAR(50) NOT NULL,
  grade_applied VARCHAR(50) DEFAULT NULL,
  passing_year VARCHAR(10) DEFAULT NULL,
  profession VARCHAR(100) DEFAULT NULL,
  message TEXT DEFAULT NULL,
  status ENUM('new', 'contacted', 'closed') DEFAULT 'new',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO enquiries (type, name, email, phone, grade_applied, message, status) VALUES
('admission', 'Rahul Nair', 'rahul.parent@gmail.com', '9847123456', 'Class I', 'Inquiring regarding admission schedule and fee details for 2026-27.', 'new'),
('alumni', 'Deepak S', 'deepak.alumni@yahoo.com', '9895012345', NULL, 'Passed out in 2015 batch. Would love to join upcoming alumni meet.', 'new');

-- --------------------------------------------------------
-- 9. Newsletter Subscribers Table
-- --------------------------------------------------------
CREATE TABLE newsletter_subscribers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(100) NOT NULL UNIQUE,
  subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO newsletter_subscribers (email) VALUES
('parent.mgm@example.com');

-- --------------------------------------------------------
-- 10. Audit Logs Table
-- --------------------------------------------------------
CREATE TABLE audit_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT DEFAULT NULL,
  action VARCHAR(100) NOT NULL,
  details TEXT DEFAULT NULL,
  ip_address VARCHAR(50) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO audit_logs (user_id, action, details, ip_address) VALUES
(1, 'System Initialized', 'Database tables created and seed data populated successfully.', '127.0.0.1');

-- --------------------------------------------------------
-- 11. Pages Table (All 16 Required Pages)
-- --------------------------------------------------------
CREATE TABLE pages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  wp_id INT DEFAULT NULL,
  slug VARCHAR(100) NOT NULL UNIQUE,
  title VARCHAR(255) NOT NULL,
  hero_title VARCHAR(255) DEFAULT NULL,
  breadcrumb_title VARCHAR(255) DEFAULT NULL,
  content_html LONGTEXT,
  meta_description TEXT,
  is_published TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
`;

function cleanHtml(html) {
  let h = html;
  h = h.replace(/https?:\/\/mgm-school\.nbtksa.in\/wp-content\/uploads\/[0-9]{4}\/[0-9]{2}\/([^\s"'<>]+\.pdf)/gi, 'assets/docs/$1');
  h = h.replace(/https?:\/\/mgm-school\.nbtksa.in\/wp-content\/uploads\/[0-9]{4}\/[0-9]{2}\/([^\s"'<>]+\.(?:jpg|jpeg|png|webp|gif|svg))/gi, 'assets/images/$1');
  h = h.replace(/https?:\/\/mgm-school\.nbtksa.in\/wp-content\/plugins\/[^\s"'<>]+\/([^\s"'<>]+\.(?:jpg|jpeg|png|webp|gif|svg))/gi, 'assets/images/$1');
  h = h.replace(/https?:\/\/mgm-school\.nbtksa.in/g, '');
  return h;
}

for (const [slug, page] of Object.entries(pages)) {
  const wpId = wpIdMap[slug] || null;
  const title = page.title;
  const heroTitle = title;
  const breadcrumbTitle = title;
  
  let html = cleanHtml(page.rawHtml);

  if (slug === 'admission-procedure') {
    html = html.replace(/<table[\s\S]*?<\/table>/i, admTableHtml);
  } else if (slug === 'courses-offered') {
    html = html.replace(/<table[\s\S]*?<\/table>/i, crsTableHtml);
  } else if (slug === 'gallery') {
    html = html.replace(/<div class="e-gallery-image elementor-gallery-item__image" data-thumbnail="([^"]+)"[^>]*><\/div>/gi, (m, src) => {
      return `<img class="e-gallery-image" src="${src}" alt="Gallery Photo" loading="lazy">`;
    });
  }

  const metaDesc = `Official MGM Model School, Ayiroor, Varkala - ${title} page.`;

  sql += `
INSERT INTO pages (wp_id, slug, title, hero_title, breadcrumb_title, content_html, meta_description, is_published)
VALUES (${wpId}, ${escapeSql(slug)}, ${escapeSql(title)}, ${escapeSql(heroTitle)}, ${escapeSql(breadcrumbTitle)}, ${escapeSql(html)}, ${escapeSql(metaDesc)}, 1);
`;
}

fs.writeFileSync('database.sql', sql);
fs.writeFileSync('database/database.sql', sql);
console.log('Regenerated database.sql and database/database.sql successfully!');
