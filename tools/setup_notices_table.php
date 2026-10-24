<?php
require_once __DIR__ . '/../config/config.php';

$db = getDB();

// 1. Create table
$db->exec("
CREATE TABLE IF NOT EXISTS notices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    category VARCHAR(50) DEFAULT 'General',
    badge_color VARCHAR(50) DEFAULT 'primary',
    publish_date DATE NOT NULL,
    display_date VARCHAR(50) NOT NULL,
    summary TEXT NOT NULL,
    content TEXT NULL,
    image_url VARCHAR(255) NULL,
    pdf_url VARCHAR(255) NULL,
    is_active TINYINT(1) DEFAULT 1,
    is_ticker TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

echo "Notices table created or verified.\n";

// Clear previous test records if any
$db->exec("DELETE FROM notices");

// 2. Seed realistic notices for MGM Model School
$notices = [
    [
        'title' => 'Admissions Open for Academic Year 2025–2026: Pre-KG to Grade XI',
        'slug' => 'admissions-open-2025-2026',
        'category' => 'Admission',
        'badge_color' => 'danger',
        'publish_date' => '2026-10-15',
        'display_date' => 'October 15, 2026',
        'summary' => 'Admissions are officially open for Pre-Primary (Pre-KG, LKG, UKG), Primary, Middle, Secondary, and Senior Secondary (Science, Commerce & Humanities) streams for the 2025–2026 academic year. Download prospectus or visit campus desk.',
        'content' => 'MGM Model School Ayiroor, Varkala announces the commencement of admission registrations for the upcoming academic session 2025–2026. Offering CBSE affiliated comprehensive curriculum with smart classrooms, state-of-the-art AI Innovation Centre, STEM robotics, semi-olympic swimming pool, and dedicated school bus transportation across Varkala and surrounding areas. Parents can collect registration kits from the administrative office between 8:30 AM and 3:30 PM on weekdays.',
        'image_url' => 'assets/images/Untitled-design-4.png',
        'pdf_url' => null,
        'is_active' => 1,
        'is_ticker' => 1,
        'sort_order' => 1
    ],
    [
        'title' => 'CBSE Board Examination Merit Honors: Outstanding 100% Pass Results',
        'slug' => 'cbse-board-merit-honors',
        'category' => 'Academic',
        'badge_color' => 'success',
        'publish_date' => '2026-09-28',
        'display_date' => 'September 28, 2026',
        'summary' => 'Hearty congratulations to our Grade X & XII CBSE Board exam achievers who secured distinctions and top percentiles, continuing MGM Model School\'s tradition of 100% pass excellence.',
        'content' => 'MGM Model School rejoices in the remarkable academic accomplishment of its students in the recent CBSE Class X and Class XII Board Examinations. With a stellar 100% pass rate, our toppers achieved A1 grades across all core subjects. The Management, Principal, and Faculty extend heartfelt congratulations to the students and their proud parents for this prestigious milestone.',
        'image_url' => 'assets/images/Untitled-design-15.jpg',
        'pdf_url' => null,
        'is_active' => 1,
        'is_ticker' => 1,
        'sort_order' => 2
    ],
    [
        'title' => 'Prestigious Rajyapuraskar (Governor\'s Award) Bestowed on Scouts & Guides Cadets',
        'slug' => 'rajyapuraskar-governors-award-felicitation',
        'category' => 'Achievement',
        'badge_color' => 'primary',
        'publish_date' => '2026-09-10',
        'display_date' => 'September 10, 2026',
        'summary' => 'MGM Model School Hindustan Scouts and Guides cadets have been conferred the prestigious Rajyapuraskar (Governor\'s Award) by the Hon\'ble Governor of Kerala for leadership and public service.',
        'content' => 'In a proud moment of glory, cadets of MGM Model School\'s Hindustan Scouts & Guides troop have been awarded the prestigious Rajyapuraskar Certificate by the Hon\'ble Governor of Kerala. This highest state-level recognition commends their exemplary dedication, community service projects, survival camps, and leadership drills.',
        'image_url' => 'assets/images/rajyapuraskar-2024.png',
        'pdf_url' => null,
        'is_active' => 1,
        'is_ticker' => 1,
        'sort_order' => 3
    ],
    [
        'title' => 'State-of-the-Art Innovation Centre & AI Robotics Hub Inaugurated',
        'slug' => 'innovation-centre-ai-robotics-inauguration',
        'category' => 'Event',
        'badge_color' => 'info',
        'publish_date' => '2026-08-20',
        'display_date' => 'August 20, 2026',
        'summary' => 'Inauguration of OMNIS Educational Humanoid Robot, NOVA KG AI Hub, and 3D Rapid Prototyping Laboratory by Hon\'ble Governor of Kerala, Shri Arif Mohammed Khan.',
        'content' => 'Marking a transformative era in school education, the Hon\'ble Governor of Kerala Shri Arif Mohammed Khan formally dedicated MGM\'s Innovation Centre to the student community. The hub features humanoid robot OMNIS, Cubelets programmable blocks, VR astronomical learning simulations, and 3D printing equipment.',
        'image_url' => 'assets/images/Untitled-design-16.jpg',
        'pdf_url' => null,
        'is_active' => 1,
        'is_ticker' => 1,
        'sort_order' => 4
    ],
    [
        'title' => 'Annual Inter-House Sports Championship & Aquatic Meet 2025–26',
        'slug' => 'annual-sports-championship-aquatic-meet',
        'category' => 'Sports',
        'badge_color' => 'warning',
        'publish_date' => '2026-08-05',
        'display_date' => 'August 05, 2026',
        'summary' => 'The Annual Athletics and Aquatic Sports meet schedule has been declared. Competitions in swimming, track events, and team games across all four houses.',
        'content' => 'The Sports Department of MGM Model School has announced the itinerary for the Annual Inter-House Sports Championship and Swimming Competition. Events will take place at the campus athletic grounds and semi-olympic swimming facility. Parents and guardians are cordially invited to cheer the young champions.',
        'image_url' => 'assets/images/swimming-pool-facility-1.jpeg',
        'pdf_url' => null,
        'is_active' => 1,
        'is_ticker' => 1,
        'sort_order' => 5
    ],
    [
        'title' => 'Official Circular: School Working Hours, Transit Corridors & Visitor Policy',
        'slug' => 'school-hours-transit-visitor-protocol',
        'category' => 'Circular',
        'badge_color' => 'secondary',
        'publish_date' => '2026-07-25',
        'display_date' => 'July 25, 2026',
        'summary' => 'Important guidelines regarding campus gate timings, bus transport route schedules, student uniform standards, and prior appointment protocol for administrative desk meetings.',
        'content' => 'All parents and guardians are requested to take note of the campus operating guidelines. Classes operate Monday through Friday from 8:30 AM to 3:30 PM. Administrative counters function from 8:30 AM to 4:00 PM. Visitors must sign in at the security gateway and schedule appointments with faculty desks in advance.',
        'image_url' => 'assets/images/Untitled-design-4.png',
        'pdf_url' => null,
        'is_active' => 1,
        'is_ticker' => 1,
        'sort_order' => 6
    ],
    [
        'title' => 'Voice of MGM Cultural Fest & Inter-School Performing Arts Showcase',
        'slug' => 'voice-of-mgm-cultural-fest',
        'category' => 'Celebration',
        'badge_color' => 'primary',
        'publish_date' => '2026-07-10',
        'display_date' => 'July 10, 2026',
        'summary' => 'Celebrating creative arts, classical dance, music, elocution, and theatrical talents at the annual Voice of MGM youth festival.',
        'content' => 'The Voice of MGM Cultural Festival brings together students across grades to showcase their artistic flair in Indian classical dance, Western choir, mono-act, debate, painting, and mime. Certificates and trophies will be awarded during the valedictory session.',
        'image_url' => 'assets/images/scouts-and-guides.jpeg',
        'pdf_url' => null,
        'is_active' => 1,
        'is_ticker' => 1,
        'sort_order' => 7
    ]
];

$stmt = $db->prepare("
INSERT INTO notices (title, slug, category, badge_color, publish_date, display_date, summary, content, image_url, pdf_url, is_active, is_ticker, sort_order)
VALUES (:title, :slug, :category, :badge_color, :publish_date, :display_date, :summary, :content, :image_url, :pdf_url, :is_active, :is_ticker, :sort_order)
");

foreach ($notices as $n) {
    $stmt->execute([
        ':title' => $n['title'],
        ':slug' => $n['slug'],
        ':category' => $n['category'],
        ':badge_color' => $n['badge_color'],
        ':publish_date' => $n['publish_date'],
        ':display_date' => $n['display_date'],
        ':summary' => $n['summary'],
        ':content' => $n['content'],
        ':image_url' => $n['image_url'],
        ':pdf_url' => $n['pdf_url'],
        ':is_active' => $n['is_active'],
        ':is_ticker' => $n['is_ticker'],
        ':sort_order' => $n['sort_order']
    ]);
}

echo "Successfully seeded " . count($notices) . " notices.\n";
