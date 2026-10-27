<?php
/**
 * Campus Highlights Module
 * MGM Model School Recreation Project
 * Comprehensive Showcase of All 21 Distinctive Features & Modern Facilities
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = 'highlights';
$pageTitle = 'Campus Highlights';
$breadcrumbTitle = 'Highlights';
$metaDescription = 'Explore the 21 unique highlights of MGM Model School Ayiroor, Varkala — from our semi-Olympic swimming pool and 20-20 teaching method to the AI Robotics Hub, Poly House, and National Cadet Corps.';

$highlights = json_decode(<<<'JSON'
[
  {
    "id": "swimming-pool",
    "order": 1,
    "title": "Swimming Pool",
    "category_key": "facilities",
    "category_name": "Student Well-being & Facilities",
    "image": "assets/images/swimming-pool-1.jpeg",
    "icon": "fa-solid fa-person-swimming",
    "url": "/swimming-pool/",
    "has_dedicated_page": true,
    "summary": "World-class semi-Olympic swimming pool facility providing students with structured aquatic training, water safety certification, and competitive sports excellence.",
    "details": "Regular swimming sessions are integrated into the sports curriculum with separate batches for junior and senior students under certified coaches. Equipped with continuous filtration, water testing, and strict safety protocols.",
    "bullets": [
      "Semi-Olympic dimensions with lane dividers",
      "Certified life guards & professional coaches",
      "Age-graded water safety and swimming curriculum",
      "Automated filtration and daily hygiene testing"
    ],
    "tags": [
      "Semi-Olympic Size",
      "Certified Coaches",
      "Aquatic Safety",
      "Sports Excellence"
    ]
  },
  {
    "id": "twenty-twenty-method",
    "order": 2,
    "title": "20-20 Method of Teaching",
    "category_key": "academic",
    "category_name": "Academic & Innovation",
    "image": "assets/images/1741692636.jpeg",
    "icon": "fa-solid fa-chalkboard-user",
    "url": "#twenty-twenty-method",
    "has_dedicated_page": false,
    "summary": "Signature pedagogical approach dividing class sessions into 20 minutes of dynamic concept foundation followed by 20 minutes of interactive problem-solving and peer discussion.",
    "details": "This method transforms passive classrooms into vibrant hubs of active inquiry. Teachers introduce core principles with multimedia smartboards, and the remaining 20 minutes are dedicated to problem-solving, group presentations, and individual mentoring.",
    "bullets": [
      "20 mins dynamic concept teaching & visual demos",
      "20 mins student practice, problem solving & peer discussion",
      "Immediate doubt clearance and conceptual mastery",
      "Boosts classroom attentiveness and student retention"
    ],
    "tags": [
      "Interactive Pedagogy",
      "Active Learning",
      "Immediate Feedback",
      "Concept Mastery"
    ]
  },
  {
    "id": "libraries-at-mgm",
    "order": 3,
    "title": "Libraries at MGM",
    "category_key": "academic",
    "category_name": "Academic & Innovation",
    "image": "assets/images/libraries-1.jpeg",
    "icon": "fa-solid fa-book-open-reader",
    "url": "#libraries-at-mgm",
    "has_dedicated_page": false,
    "summary": "Expansive library ecosystem offering thousands of literary masterpieces, scientific journals, encyclopedia collections, and quiet reading alcoves fostering lifelong inquiry.",
    "details": "Features over 10,000 carefully curated titles spanning literature, science, humanities, and competitive exam preparations. Complemented by digital e-library terminals and dedicated reading corners for junior scholars.",
    "bullets": [
      "Over 10,000+ volumes, encyclopedias & scientific journals",
      "Digital e-library terminals with online reference databases",
      "Dedicated junior storybook corner for primary students",
      "Peaceful, air-conditioned study alcoves for self-paced reading"
    ],
    "tags": [
      "10,000+ Volumes",
      "E-Library Access",
      "Quiet Study Alcoves",
      "Curated Periodicals"
    ]
  },
  {
    "id": "poly-house",
    "order": 4,
    "title": "Poly House",
    "category_key": "green",
    "category_name": "Campus & Green Initiatives",
    "image": "assets/images/poly-house-akshara-muttathe-krishithottam-3.jpeg",
    "icon": "fa-solid fa-leaf",
    "url": "#poly-house",
    "has_dedicated_page": false,
    "summary": "Modern controlled-environment greenhouse facility educating learners in microclimate management, precision agriculture, drip irrigation, and sustainable horticulture.",
    "details": "Serves as an experiential outdoor science laboratory where students observe how temperature, humidity, and ventilation impact plant development, empowering them with 21st-century agritech skills.",
    "bullets": [
      "UV-stabilized microclimate controlled greenhouse structure",
      "Precision drip irrigation and automated moisture sensing",
      "Year-round cultivation of high-value organic crops",
      "Practical botantical and agricultural science education"
    ],
    "tags": [
      "Climate Control",
      "Drip Irrigation",
      "Precision Agri-Science",
      "Sustainable Farming"
    ]
  },
  {
    "id": "krishi-thottam",
    "order": 5,
    "title": "Akshara Muttathe Krishi Thottam",
    "category_key": "green",
    "category_name": "Campus & Green Initiatives",
    "image": "assets/images/poly-house-akshara-muttathe-krishithottam-1.jpeg",
    "icon": "fa-solid fa-seedling",
    "url": "#krishi-thottam",
    "has_dedicated_page": false,
    "summary": "Acclaimed campus organic farming project where students engage in soil preparation, sowing, organic composting, and harvesting indigenous produce.",
    "details": "Honored with prestigious awards, this initiative connects urban learners with Kerala heritage farming techniques. Students nurture pesticide-free vegetables, learn organic composting, and develop enduring ecological consciousness.",
    "bullets": [
      "100% organic soil management and natural pest deterrents",
      "Hands-on student participation from seed germination to harvest",
      "District and state recognition for campus agriculture excellence",
      "Instills deep appreciation for food sovereignty and farming labor"
    ],
    "tags": [
      "Organic Farming",
      "State Recognized",
      "Heritage Seeds",
      "Eco-Conscious Learning"
    ]
  },
  {
    "id": "amma-school",
    "order": 6,
    "title": "Amma School",
    "category_key": "facilities",
    "category_name": "Student Well-being & Facilities",
    "image": "assets/images/1750242823.jpeg",
    "icon": "fa-solid fa-heart",
    "url": "#amma-school",
    "has_dedicated_page": false,
    "summary": "Unique collaborative forum bringing mothers and educators together for regular seminars on modern parenting, adolescent well-being, and values-based upbringing.",
    "details": "Recognizing the mother as the first teacher, Amma School conducts interactive workshops on managing screen time, emotional resilience, balanced adolescent diet, and nurturing positive communication at home.",
    "bullets": [
      "Regular interactive workshops led by child psychologists",
      "Supportive maternal community sharing parenting strategies",
      "Focus on emotional wellness, nutrition, and digital screen balance",
      "Strengthens the harmonious triangle of student, mother, and teacher"
    ],
    "tags": [
      "Parenting Workshops",
      "Maternal Empowerment",
      "Family Wellness",
      "Values & Ethics"
    ]
  },
  {
    "id": "vriksha-chikitsa",
    "order": 7,
    "title": "Vriksha Chikitsa",
    "category_key": "green",
    "category_name": "Campus & Green Initiatives",
    "image": "assets/images/polyhouse-garden.jpeg",
    "icon": "fa-solid fa-tree",
    "url": "#vriksha-chikitsa",
    "has_dedicated_page": false,
    "summary": "Traditional arboriculture and eco-healing initiative reviving ancient Ayurvedic plant care techniques to protect campus biodiversity and heal aged trees.",
    "details": "Students study ancient botanical treatises, inspect campus tree health, formulate herbal healing paste for wounded trunks, and cultivate medicinal herb gardens, preserving traditional ecological wisdom.",
    "bullets": [
      "Ancient Ayurvedic arboriculture applied to campus flora",
      "Herbal healing formulations to preserve century-old trees",
      "Botanical tagging and medicinal properties mapping",
      "Fosters holistic reverence for sacred campus ecosystems"
    ],
    "tags": [
      "Botanical Healing",
      "Herbal Conservation",
      "Campus Biodiversity",
      "Indigenous Science"
    ]
  },
  {
    "id": "counselling-centre",
    "order": 8,
    "title": "Counselling Centre",
    "category_key": "facilities",
    "category_name": "Student Well-being & Facilities",
    "image": "assets/images/1750242779.jpeg",
    "icon": "fa-solid fa-comments",
    "url": "#counselling-centre",
    "has_dedicated_page": false,
    "summary": "Safe, empathetic psychological guidance and emotional wellness sanctuary staffed by qualified counselors dedicated to student mental health and resilience.",
    "details": "Offers confidential individual counseling, stress management workshops, emotional intelligence sessions, and peer bonding circles ensuring that every student has guidance throughout academic and teenage growth.",
    "bullets": [
      "Confidential, non-judgmental student counseling sessions",
      "Expert guidance through exam stress, anxiety, and teenage transitions",
      "Proactive emotional wellness and mindfulness seminars",
      "Parent-counselor consultations for unified emotional support"
    ],
    "tags": [
      "Confidential Guidance",
      "Trained Psychologists",
      "Stress Management",
      "Emotional Wellness"
    ]
  },
  {
    "id": "innovation-centre",
    "order": 9,
    "title": "Innovation Centre",
    "category_key": "academic",
    "category_name": "Academic & Innovation",
    "image": "assets/images/1756461341.jpg",
    "icon": "fa-solid fa-flask-vial",
    "url": "#innovation-centre",
    "has_dedicated_page": false,
    "summary": "Inaugurated by the Hon'ble Governor of Kerala, this cutting-edge facility unites robotics, IoT electronics, 3D prototyping, and design thinking to nurture future innovators.",
    "details": "Features dedicated maker spaces, advanced electronic test benches, microcontroller development kits, and prototyping equipment where students collaborate on practical problem-solving for national competitions.",
    "bullets": [
      "Inaugurated by Hon'ble Governor of Kerala Shri Arif Mohammed Khan",
      "High-precision 3D printers and rapid prototyping stations",
      "Electronics breadboards, sensor modules, and IoT development kits",
      "Student teams mentored for national STEM & robotics Olympiads"
    ],
    "tags": [
      "Governor Inaugurated",
      "Robotics Labs",
      "3D Prototyping",
      "Design Thinking"
    ]
  },
  {
    "id": "gdc",
    "order": 10,
    "title": "GDC (Guidance & Development Cell)",
    "category_key": "facilities",
    "category_name": "Student Well-being & Facilities",
    "image": "assets/images/1750242752.jpeg",
    "icon": "fa-solid fa-compass",
    "url": "#gdc",
    "has_dedicated_page": false,
    "summary": "Guidance & Development Cell offering specialized career counseling, higher education planning, and competitive examination orientation for secondary students.",
    "details": "GDC conducts psychometric aptitude profiling, university discovery sessions, entrance coaching guidance (JEE, NEET, CUET, NDA), and interaction with industry leaders to guide each student toward their ideal career.",
    "bullets": [
      "Personalized psychometric aptitude profiling and interest mapping",
      "Structured foundation orientation for JEE, NEET, CUET, and NDA",
      "University admissions guidance for top Indian and overseas campuses",
      "Alumni mentoring networks and industry professional masterclasses"
    ],
    "tags": [
      "Career Navigation",
      "Competitive Exam Focus",
      "Aptitude Profiling",
      "Higher Ed Guidance"
    ]
  },
  {
    "id": "life-skills",
    "order": 11,
    "title": "Life Skills",
    "category_key": "skills",
    "category_name": "Skills & Cadet Corps",
    "image": "assets/images/1750233724.jpeg",
    "icon": "fa-solid fa-lightbulb",
    "url": "#life-skills",
    "has_dedicated_page": false,
    "summary": "Curriculum-integrated developmental framework focusing on critical thinking, ethical reasoning, financial literacy, communication, and emotional adaptability.",
    "details": "Through experiential role-play, teamwork simulations, crisis decision-making exercises, and public speaking, students build foundational life competencies that extend far beyond textbook examinations.",
    "bullets": [
      "CBSE-aligned emotional self-regulation and empathy training",
      "Financial literacy fundamentals: budgeting, saving, and value of money",
      "Conflict resolution, active listening, and public speaking mastery",
      "Digital etiquette, cyber safety awareness, and ethical leadership"
    ],
    "tags": [
      "Emotional Intelligence",
      "Critical Thinking",
      "Financial Basics",
      "Effective Communication"
    ]
  },
  {
    "id": "voice-of-mgm",
    "order": 12,
    "title": "Voice of MGM",
    "category_key": "skills",
    "category_name": "Skills & Cadet Corps",
    "image": "assets/images/1751285378.jpeg",
    "icon": "fa-solid fa-microphone",
    "url": "/voice-of-mgm/",
    "has_dedicated_page": true,
    "summary": "Official campus radio and broadcasting studio empowering students to host news broadcasts, audio podcasts, creative storytelling, and interviews.",
    "details": "Equipped with soundproof recording booths, professional mixing consoles, broadcast microphones, and digital editing software. Students run editorial, production, and announcing roles independently.",
    "bullets": [
      "Fully equipped digital sound studio with acoustic isolation",
      "Daily student-anchored campus news and inspirational bulletins",
      "Exclusive interviews with distinguished guests, alumni, and teachers",
      "Radio Jockey (RJ) training, podcast production, and voice modulation"
    ],
    "tags": [
      "Campus Radio",
      "Sound Recording Studio",
      "Podcasting",
      "Student RJ Training"
    ]
  },
  {
    "id": "school-canteen",
    "order": 13,
    "title": "School Canteen",
    "category_key": "facilities",
    "category_name": "Student Well-being & Facilities",
    "image": "assets/images/school-canteen.jpeg",
    "icon": "fa-solid fa-utensils",
    "url": "#school-canteen",
    "has_dedicated_page": false,
    "summary": "Spotless, hygienic dining hall serving fresh, wholesome, balanced vegetarian meals and healthy snacks in accordance with strict dietary health regulations.",
    "details": "Monitored continuously for sanitation and culinary excellence. Provides students and faculty with balanced, nutrient-dense meals, fresh seasonal juices, and pure RO drinking water in an inviting cafeteria environment.",
    "bullets": [
      "Spotless, spacious cafeteria with continuous sanitization",
      "Nutritious vegetarian meals planned by health nutritionists",
      "Zero artificial additives, preservatives, or deep-fried junk food",
      "High-capacity RO drinking water filtration stations"
    ],
    "tags": [
      "Hygienic Dining",
      "Nutritious Meals",
      "RO Purified Water",
      "Strict Sanitation"
    ]
  },
  {
    "id": "butterfly-garden",
    "order": 14,
    "title": "Butterfly Garden and Kids Zone",
    "category_key": "green",
    "category_name": "Campus & Green Initiatives",
    "image": "assets/images/butterfly-garden-1.jpeg",
    "icon": "fa-solid fa-shapes",
    "url": "#butterfly-garden",
    "has_dedicated_page": false,
    "summary": "Captivating biodiversity garden attracting colorful butterflies amidst native nectar flora, coupled with a safe adventure playground for early learners.",
    "details": "Combines outdoor botanical exploration with joyous motor-skill play. Little ones explore butterfly life stages in nature while enjoying soft-landing play structures, swings, and climbing bridges.",
    "bullets": [
      "Host and nectar plant ecosystem supporting diverse butterfly species",
      "Safe, certified soft-landing turf play equipment for little children",
      "Experiential outdoor nature walks integrated with kindergarten curriculum",
      "Sensory sandpits, toddler balancing logs, and shaded rest pergolas"
    ],
    "tags": [
      "Butterfly Sanctuary",
      "Primary Play Ground",
      "Outdoor Learning",
      "Sensory Play"
    ]
  },
  {
    "id": "3d-max-zone",
    "order": 15,
    "title": "3D Max Zone",
    "category_key": "academic",
    "category_name": "Academic & Innovation",
    "image": "assets/images/maths-zone-3d.jpeg",
    "icon": "fa-solid fa-cube",
    "url": "#3d-max-zone",
    "has_dedicated_page": false,
    "summary": "Specialised mathematics and spatial reasoning lab equipped with tangible geometric solids, coordinate frames, and 3D manipulative models.",
    "details": "Enables students to touch, assemble, and deconstruct complex geometric shapes, vectors, conic sections, and algebraic graphs, turning complex mathematics into an intuitive physical reality.",
    "bullets": [
      "Tangible physical models of polyhedra, cylinders, cones, and spheres",
      "Coordinate geometry 3D projection boards and vector apparatus",
      "Hands-on exploration turning abstract mathematical theorems into reality",
      "Sparks spatial intuition, structural reasoning, and architecture interest"
    ],
    "tags": [
      "Spatial Mathematics",
      "Tangible 3D Models",
      "Experiential Geometry",
      "Tactile Inquiry"
    ]
  },
  {
    "id": "ominis",
    "order": 16,
    "title": "Ominis",
    "category_key": "academic",
    "category_name": "Academic & Innovation",
    "image": "assets/images/omnis-robot.jpeg",
    "icon": "fa-solid fa-robot",
    "url": "#ominis",
    "has_dedicated_page": false,
    "summary": "MGM's state-of-the-art interactive humanoid robot companion that engages students in conversations, explains scientific phenomena, and showcases real-world AI.",
    "details": "Ominis interacts during exhibitions, campus events, and tech workshops. Powered by speech recognition, natural language processing, and robotic actuators, Ominis makes future AI technology touchable.",
    "bullets": [
      "Speech recognition and conversational AI dialogue capabilities",
      "Demonstrates kinematics, servo motor control, and sensory response",
      "Featured during prestigious gubernatorial and scientific campus visits",
      "Inspires students to pursue robotics, AI, and mechatronics engineering"
    ],
    "tags": [
      "Humanoid Robot",
      "Artificial Intelligence",
      "Voice Interaction",
      "Tech Ambassador"
    ]
  },
  {
    "id": "nova-ai-hub",
    "order": 17,
    "title": "NOVA AI Hub",
    "category_key": "academic",
    "category_name": "Academic & Innovation",
    "image": "assets/images/1756461341.jpg",
    "icon": "fa-solid fa-microchip",
    "url": "#nova-ai-hub",
    "has_dedicated_page": false,
    "summary": "Dedicated AI innovation and introductory robotics studio for junior and primary learners featuring modular Cubelets, MIKO AI robots, and block coding.",
    "details": "Designed to cultivate computational literacy without screen burnout. Young minds combine magnetic sensor blocks, learn logical cause-and-effect algorithms, and build intelligent robotic contraptions.",
    "bullets": [
      "Cubelets modular robotics: magnetic sense, think, and act blocks",
      "MIKO intelligent student companion robots for interactive problem solving",
      "Tangible block-based coding developing foundational algorithmic logic",
      "Screen-healthy exploratory learning tailored for primary grades"
    ],
    "tags": [
      "Cubelets Modular Kits",
      "MIKO Robot Lab",
      "Block Coding",
      "Junior AI Literacy"
    ]
  },
  {
    "id": "ncc",
    "order": 18,
    "title": "NCC",
    "category_key": "skills",
    "category_name": "Skills & Cadet Corps",
    "image": "assets/images/ncc-unit-1.jpeg",
    "icon": "fa-solid fa-person-military-pointing",
    "url": "/ncc/",
    "has_dedicated_page": true,
    "summary": "Premier Junior Division National Cadet Corps wing instilling patriotism, military discipline, leadership character, physical endurance, and selfless service.",
    "details": "Cadets undergo systematic parade drill training, firing simulations, national integration camps (NIC), and disaster relief awareness exercises, shaping responsible, patriotic citizens.",
    "bullets": [
      "Affiliated Junior Division Army Wing unit under Kerala Battalion",
      "Rigorous parade drills, weapon safety orientation, and obstacle courses",
      "Regular cadet representation in Combined Annual Training Camps (CATC)",
      "Community leadership drives: blood donation, coastal cleanups & rallies"
    ],
    "tags": [
      "Army Wing Cadets",
      "Parade Training",
      "Leadership Camps",
      "National Service"
    ]
  },
  {
    "id": "hindustan-scouts-guides",
    "order": 19,
    "title": "Hindustan Scouts and Guides",
    "category_key": "skills",
    "category_name": "Skills & Cadet Corps",
    "image": "assets/images/scouts-and-guides.jpeg",
    "icon": "fa-solid fa-award",
    "url": "/hindustan-scouts-guides/",
    "has_dedicated_page": true,
    "summary": "Prestigious troop decorated with multiple Rajya Puraskar Governor Awards, mastering wilderness outdoor survival, civic duty, first-aid, and leadership.",
    "details": "With award-winning records in 2019, 2022, 2023, and 2024, our troop is one of Kerala's most distinguished. Cadets actively participate in state rallies, knot-tying, bridge-building, and emergency rescue.",
    "bullets": [
      "Proud recipients of the Hon'ble Governor's Rajya Puraskar (2019, 2022, 2023, 2024)",
      "Pioneering outdoor survival skills: knot-tying, tracking, and tentcraft",
      "Advanced first-aid, emergency rescue, and civic relief training",
      "State jamboree leadership and national integration expeditions"
    ],
    "tags": [
      "Rajya Puraskar Laureates",
      "Outdoor Survival Skills",
      "Campfire Rallies",
      "First Aid Mastery"
    ]
  },
  {
    "id": "school-band-troop",
    "order": 20,
    "title": "School Band Troop",
    "category_key": "skills",
    "category_name": "Skills & Cadet Corps",
    "image": "assets/images/investiture-ceremony.jpeg",
    "icon": "fa-solid fa-drum",
    "url": "#school-band-troop",
    "has_dedicated_page": false,
    "summary": "Ceremonial marching brass and percussion band troop performing synchronized drills, patriotic anthems, and martial salutes with precision.",
    "details": "Features side drummers, bass drummers, buglers, and cymbal players dressed in ceremonial regalia. The troop leads all school investitures, annual sports meets, Independence Day parades, and regional contests.",
    "bullets": [
      "Synchronized marching formations, military drills, and drumline beats",
      "Trained on bass drums, side snare drums, tenor drums, bugles, and cymbals",
      "Honors state and national dignitaries during ceremonial campus parades",
      "Cultivates collective team rhythm, discipline, and performance stage confidence"
    ],
    "tags": [
      "Marching Brass & Percussion",
      "Synchronized Drills",
      "Ceremonial Honors",
      "Musical Precision"
    ]
  },
  {
    "id": "happiness-room",
    "order": 21,
    "title": "Happiness Room",
    "category_key": "facilities",
    "category_name": "Student Well-being & Facilities",
    "image": "assets/images/1750242382.jpeg",
    "icon": "fa-solid fa-face-smile",
    "url": "#happiness-room",
    "has_dedicated_page": false,
    "summary": "Serene emotional rejuvenation sanctuary designed with sensory calming corners, mindfulness meditation spaces, and creative expressive art therapy.",
    "details": "Created to alleviate academic tension and nurture positive mindset. Students visit during stress-relief intervals to practice guided breathing, engage in relaxing art therapy, and recharge mental stamina.",
    "bullets": [
      "Sound-dampened peaceful acoustic environment with warm natural light",
      "Sensory relaxation zones with comfortable beanbags and meditation mats",
      "Expressive art therapy supplies, mandalas, and calming mindfulness puzzles",
      "Nurtures emotional balance, gratitude practices, and student happiness"
    ],
    "tags": [
      "Mindfulness Sanctuary",
      "Sensory Relaxation",
      "Art Therapy",
      "Joy & Well-being"
    ]
  }
]
JSON
, true);

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/breadcrumb.php';
?>

<div class="highlights-page-wrapper" style="background: #FAF8F5; min-height: 100vh;">
  
  <!-- Hero / Introduction Area -->
  <div class="highlights-header-banner text-center text-white">
    <div class="container custom-container-larg position-relative" style="z-index: 2;">
      <span class="highlights-badge-pill mb-3">
        <i class="fa-solid fa-star"></i> Distinctive Excellence
      </span>
      <h1 class="highlights-title">Campus Highlights &amp; Facilities</h1>
      <p class="highlights-lead">
        Discover the 21 benchmark facilities, innovative pedagogies, eco-initiatives, and cadet wings that define education at MGM Model School, Ayiroor, Varkala.
      </p>
    </div>
  </div>

  <!-- Interactive Search & Filter Controls -->
  <div class="container custom-container-larg mb-5">
    <div class="highlights-controls-card">
      <div class="row align-items-center g-3">
        
        <!-- Live Search Box -->
        <div class="col-lg-5 col-md-12">
          <div class="highlights-search-box">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input type="text" id="highlightSearchInput" placeholder="Search facilities, robotics, green initiatives..." autocomplete="off">
            <button type="button" class="clear-btn" id="clearSearchBtn" aria-label="Clear Search">
              <i class="fa-solid fa-xmark"></i>
            </button>
          </div>
        </div>

        <!-- Category Filter Buttons -->
        <div class="col-lg-7 col-md-12">
          <div class="d-flex flex-wrap gap-2 justify-content-lg-end" id="highlightFilterGroup">
            <button type="button" class="highlights-filter-btn active" data-category="all">
              All Highlights <span class="badge-count">21</span>
            </button>
            <button type="button" class="highlights-filter-btn" data-category="academic">
              Academic &amp; Innovation <span class="badge-count">6</span>
            </button>
            <button type="button" class="highlights-filter-btn" data-category="green">
              Campus &amp; Green <span class="badge-count">4</span>
            </button>
            <button type="button" class="highlights-filter-btn" data-category="facilities">
              Student Facilities <span class="badge-count">6</span>
            </button>
            <button type="button" class="highlights-filter-btn" data-category="skills">
              Skills &amp; Cadets <span class="badge-count">5</span>
            </button>
          </div>
        </div>

      </div>

      <!-- Live Count Indicator -->
      <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top" style="border-color: #F1F5F9 !important;">
        <span class="small text-muted" id="highlightResultsCounter">
          Showing <strong class="text-dark">21</strong> of <strong>21</strong> campus highlights
        </span>
        <span class="small text-muted d-none d-md-inline">
          <i class="fa-solid fa-circle-info text-primary me-1"></i> Click any card to explore details or access dedicated sections
        </span>
      </div>
    </div>
  </div>

  <!-- Highlights 21 Cards Grid -->
  <div class="container custom-container-larg pb-5">
    
    <!-- No Results Placeholder -->
    <div id="noHighlightsFound" class="text-center py-5 d-none">
      <div class="mb-3 text-muted">
        <i class="fa-solid fa-magnifying-glass fa-3x" style="opacity: 0.3;"></i>
      </div>
      <h4 class="fw-bold text-dark">No Campus Highlights Found</h4>
      <p class="text-muted mb-3">No highlights match your search query. Try typing another keyword or reset filters.</p>
      <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-4" id="resetHighlightFiltersBtn">
        Reset All Filters
      </button>
    </div>

    <div class="row g-4" id="highlightsGrid">
      <?php foreach ($highlights as $h): 
        $keywords = strtolower($h['title'] . ' ' . $h['summary'] . ' ' . $h['category_name'] . ' ' . implode(' ', $h['tags']));
      ?>
        <div class="col-lg-4 col-md-6 highlight-card-col" 
             id="<?= e($h['id']) ?>-col"
             data-category="<?= e($h['category_key']) ?>" 
             data-keywords="<?= e($keywords) ?>">
          
          <div class="highlight-card" id="<?= e($h['id']) ?>">
            
            <!-- Thumbnail & Badges -->
            <div class="highlight-thumb-wrap">
              <img src="<?= asset_url(ltrim($h['image'], 'assets/')) ?>" 
                   alt="<?= e($h['title']) ?>" 
                   class="highlight-thumb-img" 
                   loading="lazy">
              
              <span class="highlight-category-tag">
                <?= e($h['category_name']) ?>
              </span>
              
              <span class="highlight-order-num">
                #<?= sprintf('%02d', $h['order']) ?>
              </span>
            </div>

            <!-- Card Body -->
            <div class="highlight-card-body">
              <h3 class="highlight-card-title">
                <i class="<?= e($h['icon']) ?>"></i>
                <span><?= e($h['title']) ?></span>
              </h3>

              <p class="highlight-card-desc">
                <?= e($h['summary']) ?>
              </p>

              <!-- Tags / Features -->
              <div class="highlight-tag-list">
                <?php foreach ($h['tags'] as $tag): ?>
                  <span class="highlight-tag-item">
                    <i class="fa-solid fa-check"></i> <?= e($tag) ?>
                  </span>
                <?php endforeach; ?>
              </div>

              <!-- Action Footer -->
              <div class="highlight-card-actions">
                <button type="button" 
                        class="highlight-btn-primary btn-open-detail" 
                        data-title="<?= e($h['title']) ?>"
                        data-category="<?= e($h['category_name']) ?>"
                        data-image="<?= asset_url(ltrim($h['image'], 'assets/')) ?>"
                        data-details="<?= e($h['details']) ?>"
                        data-bullets="<?= e(json_encode($h['bullets'])) ?>">
                  Quick Overview <i class="fa-solid fa-circle-info ms-1"></i>
                </button>

                <?php if ($h['has_dedicated_page']): ?>
                  <a href="<?= e(url($h['url'])) ?>" class="highlight-btn-action text-danger fw-bold" title="View Dedicated Page">
                    Full Page <i class="fa-solid fa-arrow-right ms-1"></i>
                  </a>
                <?php else: ?>
                  <a href="#<?= e($h['id']) ?>" class="highlight-btn-action" title="Copy Direct Link to Highlight" onclick="navigator.clipboard.writeText(window.location.origin + window.location.pathname + '#<?= e($h['id']) ?>'); alert('Link copied to clipboard!'); return false;">
                    <i class="fa-solid fa-share-nodes"></i>
                  </a>
                <?php endif; ?>
              </div>

            </div>

          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>

</div>

<!-- Interactive Detail Modal -->
<div class="modal fade" id="highlightDetailModal" tabindex="-1" aria-labelledby="highlightModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered highlight-modal-dialog">
    <div class="modal-content highlight-modal-content">
      
      <div class="modal-header highlight-modal-header align-items-center">
        <div>
          <span class="badge px-3 py-1 text-uppercase mb-1" id="highlightModalCategory" style="background: rgba(171,12,47,0.1); color: var(--tp-theme-primary, #ab0c2f); font-size: 11px; font-weight: 700;">
            Category
          </span>
          <h4 class="modal-title fw-bold text-dark mb-0" id="highlightModalTitle">Highlight Title</h4>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body highlight-modal-body">
        <div class="mb-3 rounded-3 overflow-hidden shadow-sm" style="max-height: 320px;">
          <img id="highlightModalImage" src="" alt="Highlight" class="w-100" style="object-fit: cover; height: 100%; max-height: 320px;">
        </div>

        <p class="text-secondary mb-3" id="highlightModalDescription" style="font-size: 15px; line-height: 1.7;"></p>

        <h6 class="fw-bold text-dark mb-2">Key Highlights &amp; Distinctive Benefits:</h6>
        <ul class="list-unstyled mb-4" id="highlightModalBullets">
        </ul>

        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
          <span class="small text-muted"><i class="fa-solid fa-shield-heart text-danger me-1"></i> MGM Model School Ayiroor</span>
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3" data-bs-dismiss="modal">Close</button>
            <a href="<?= url('/admission-procedure/') ?>" class="btn btn-danger btn-sm rounded-pill px-3" style="background: var(--tp-theme-primary, #ab0c2f); border: none;">
              Admissions Open <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('highlightSearchInput');
  const clearBtn = document.getElementById('clearSearchBtn');
  const filterGroup = document.getElementById('highlightFilterGroup');
  const filterBtns = filterGroup.querySelectorAll('.highlights-filter-btn');
  const cards = document.querySelectorAll('.highlight-card-col');
  const counter = document.getElementById('highlightResultsCounter');
  const noFound = document.getElementById('noHighlightsFound');
  const resetBtn = document.getElementById('resetHighlightFiltersBtn');

  let activeCategory = 'all';
  let activeSearch = '';

  function applyFilters() {
    let visibleCount = 0;
    const q = activeSearch.trim().toLowerCase();

    cards.forEach(card => {
      const cardCategory = card.getAttribute('data-category');
      const cardKeywords = card.getAttribute('data-keywords') || '';

      const matchesCategory = (activeCategory === 'all' || cardCategory === activeCategory);
      const matchesSearch = (!q || cardKeywords.includes(q));

      if (matchesCategory && matchesSearch) {
        card.classList.remove('d-none');
        visibleCount++;
      } else {
        card.classList.add('d-none');
      }
    });

    counter.innerHTML = 'Showing <strong class="text-dark">' + visibleCount + '</strong> of <strong>' + cards.length + '</strong> campus highlights';

    if (visibleCount === 0) {
      noFound.classList.remove('d-none');
    } else {
      noFound.classList.add('d-none');
    }

    if (q.length > 0) {
      clearBtn.style.display = 'block';
    } else {
      clearBtn.style.display = 'none';
    }
  }

  // Filter Buttons
  filterBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      filterBtns.forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      activeCategory = this.getAttribute('data-category');
      applyFilters();
    });
  });

  // Search Input
  searchInput.addEventListener('input', function () {
    activeSearch = this.value;
    applyFilters();
  });

  // Clear button
  clearBtn.addEventListener('click', function () {
    searchInput.value = '';
    activeSearch = '';
    applyFilters();
    searchInput.focus();
  });

  // Reset button
  if (resetBtn) {
    resetBtn.addEventListener('click', function () {
      searchInput.value = '';
      activeSearch = '';
      activeCategory = 'all';
      filterBtns.forEach(b => {
        if (b.getAttribute('data-category') === 'all') {
          b.classList.add('active');
        } else {
          b.classList.remove('active');
        }
      });
      applyFilters();
    });
  }

  // Quick Overview Modal
  const modalEl = document.getElementById('highlightDetailModal');
  const modalTitle = document.getElementById('highlightModalTitle');
  const modalCat = document.getElementById('highlightModalCategory');
  const modalImg = document.getElementById('highlightModalImage');
  const modalDesc = document.getElementById('highlightModalDescription');
  const modalBullets = document.getElementById('highlightModalBullets');

  document.querySelectorAll('.btn-open-detail').forEach(btn => {
    btn.addEventListener('click', function () {
      const title = this.getAttribute('data-title');
      const cat = this.getAttribute('data-category');
      const img = this.getAttribute('data-image');
      const details = this.getAttribute('data-details');
      let bullets = [];
      try {
        bullets = JSON.parse(this.getAttribute('data-bullets') || '[]');
      } catch (e) {
        bullets = [];
      }

      modalTitle.textContent = title;
      modalCat.textContent = cat;
      modalImg.src = img;
      modalImg.alt = title;
      modalDesc.textContent = details;

      modalBullets.innerHTML = '';
      bullets.forEach(b => {
        const li = document.createElement('li');
        li.className = 'd-flex align-items-start gap-2 mb-2 text-dark';
        li.innerHTML = '<i class="fa-solid fa-circle-check text-success mt-1"></i> <span>' + b + '</span>';
        modalBullets.appendChild(li);
      });

      if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const bsModal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        bsModal.show();
      } else if (typeof $ !== 'undefined') {
        $(modalEl).modal('show');
      }
    });
  });

  // Bullet-Proof Navigation to Specific Highlight
  function navigateToHighlight(hash, smooth = true) {
    if (!hash) return;
    const cleanId = hash.replace(/^#/, '');
    if (!cleanId) return;

    // Reset filters and search so target card is not hidden with d-none
    if (activeCategory !== 'all' || activeSearch !== '') {
      activeCategory = 'all';
      activeSearch = '';
      if (searchInput) searchInput.value = '';
      if (clearBtn) clearBtn.style.display = 'none';
      filterBtns.forEach(b => {
        if (b.getAttribute('data-category') === 'all') {
          b.classList.add('active');
        } else {
          b.classList.remove('active');
        }
      });
      applyFilters();
    }

    const targetEl = document.getElementById(cleanId);
    if (!targetEl) return;

    // Close offcanvas mobile drawer if opened
    const offcanvasWrapper = document.querySelector('.offcanvas-wrapper');
    const offcanvasOverlay = document.querySelector('.offcanvas-overlay');
    if (offcanvasWrapper && offcanvasWrapper.classList.contains('active')) {
      offcanvasWrapper.classList.remove('active');
      if (offcanvasOverlay) offcanvasOverlay.classList.remove('active');
      document.body.style.overflow = '';
    }

    // Scroll smoothly with offset for sticky header
    setTimeout(() => {
      const header = document.getElementById('header-sticky');
      const headerHeight = header ? header.offsetHeight : 80;
      const elementTop = targetEl.getBoundingClientRect().top + window.pageYOffset;
      const targetScrollY = Math.max(0, elementTop - headerHeight - 25);

      window.scrollTo({
        top: targetScrollY,
        behavior: smooth ? 'smooth' : 'auto'
      });

      // Target pulse glow animation
      targetEl.classList.remove('highlight-active-target');
      void targetEl.offsetWidth; // Force reflow
      targetEl.classList.add('highlight-active-target');

      setTimeout(() => {
        targetEl.classList.remove('highlight-active-target');
      }, 3000);
    }, 150);
  }

  // Handle hash on page load
  if (window.location.hash) {
    setTimeout(() => {
      navigateToHighlight(window.location.hash, true);
    }, 300);
  }

  // Handle hashchange event (clicking dropdown item while on /highlights/)
  window.addEventListener('hashchange', function () {
    navigateToHighlight(window.location.hash, true);
  });

  // Intercept click on any link on the page that points to a #highlight
  document.addEventListener('click', function (e) {
    const anchor = e.target.closest('a');
    if (!anchor) return;
    const href = anchor.getAttribute('href');
    if (!href) return;

    if (href.includes('#') && (href.startsWith('#') || href.includes('/highlights/#') || href.includes('highlights.html#'))) {
      const hashPart = href.substring(href.indexOf('#'));
      const targetId = hashPart.substring(1);
      const targetEl = document.getElementById(targetId);
      if (targetEl) {
        e.preventDefault();
        history.pushState(null, null, hashPart);
        navigateToHighlight(hashPart, true);
      }
    }
  });
});
</script>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
