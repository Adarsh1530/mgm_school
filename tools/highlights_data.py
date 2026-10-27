import os
import json
import sqlite3

# Define all 21 highlights
HIGHLIGHTS_DATA = [
    {
        'slug': 'swimming-pool',
        'title': 'Swimming Pool',
        'full_title': 'Swimming Pool Facility',
        'category_key': 'facilities',
        'category_name': 'Student Well-being & Facilities',
        'badge': 'Aquatic Excellence & Water Safety',
        'icon': 'fa-solid fa-person-swimming',
        'image': 'assets/images/swimming-pool-1.jpeg',
        'gallery': ['assets/images/swimming-pool-1.jpeg', 'assets/images/swimming-pool-facility-1.jpeg'],
        'video': 'assets/videos/swimming-pool.mp4',
        'video_poster': 'assets/images/swimming-pool-facility-1.jpeg',
        'lead': 'World-class semi-Olympic swimming pool facility providing students with structured aquatic training, water safety certification, and competitive sports excellence.',
        'overview': 'At MGM Model School, swimming is an integral pillar of physical development and life-saving skill mastery. Our semi-Olympic dual-pool facility offers clean, temperature-moderated waters maintained under rigorous hygiene protocols. Students from primary through senior secondary grades receive expert coaching under certified aquatic trainers and vigilant lifeguards.',
        'pillars': [
            {
                'icon': 'fa-solid fa-water',
                'title': 'Semi-Olympic Dimensions',
                'desc': 'Engineered to official specifications with dedicated racing lanes, starting blocks, and calibrated depths for junior and senior swimmers.'
            },
            {
                'icon': 'fa-solid fa-life-ring',
                'title': 'Certified Aquatic Safety',
                'desc': 'Stationed certified lifeguards, life buoys, safety nets, and first-aid response systems ensure 100% student safety during all sessions.'
            },
            {
                'icon': 'fa-solid fa-medal',
                'title': 'Competitive Sports Coaching',
                'desc': 'Specialized coaching batches preparing promising swimmers for CBSE South Zone, district, and state aquatic championships.'
            },
            {
                'icon': 'fa-solid fa-pump-soap',
                'title': 'Automated Continuous Filtration',
                'desc': 'Automated filtration and daily chemical balancing maintain pristine, crystal-clear water with strict pH and sanitization checks.'
            }
        ],
        'factsheet': [
            {'label': 'Facility Type', 'value': 'Semi-Olympic Dual Pool Complex'},
            {'label': 'Supervision', 'value': 'Certified Lifeguards & Aquatic Coaches'},
            {'label': 'Training Batches', 'value': 'Separate Sessions for Boys & Girls'},
            {'label': 'Hygiene Protocol', 'value': 'Continuous Automated Filtration & Daily Testing'}
        ]
    },
    {
        'slug': 'twenty-twenty-method',
        'title': '20-20 Method of Teaching',
        'full_title': '20-20 Method of Teaching',
        'category_key': 'academic',
        'category_name': 'Academic & Innovation',
        'badge': 'Signature Pedagogical Framework',
        'icon': 'fa-solid fa-chalkboard-user',
        'image': 'assets/images/1741692636.jpeg',
        'gallery': ['assets/images/1741692636.jpeg'],
        'video': None,
        'video_poster': None,
        'lead': 'MGM Model School\'s signature pedagogical model dividing class periods into 20 minutes of dynamic concept foundation followed by 20 minutes of interactive problem solving and peer discussion.',
        'overview': 'Traditional passive lectures often lead to student inattention and superficial understanding. The signature "20-20 Method of Teaching" pioneered at MGM Model School transforms standard periods into engaging learning cycles. The first 20 minutes are dedicated to teacher-led multimedia concept exploration. The subsequent 20 minutes engage students in active problem-solving, collaborative peer discussions, and instant doubt clarification.',
        'pillars': [
            {
                'icon': 'fa-solid fa-brain',
                'title': '20 Mins Dynamic Foundation',
                'desc': 'Instructors deliver high-impact conceptual explanations using smart interactive panels, animations, and real-world analogies.'
            },
            {
                'icon': 'fa-solid fa-users-gear',
                'title': '20 Mins Active Application',
                'desc': 'Learners solve exercise worksheets, analyze case problems, and engage in peer discussions to anchor the theoretical concepts.'
            },
            {
                'icon': 'fa-solid fa-circle-question',
                'title': 'Immediate Doubt Clearance',
                'desc': 'No carrying doubts home. Teachers circulate among desks to provide personalized attention and address misunderstandings on the spot.'
            },
            {
                'icon': 'fa-solid fa-chart-line',
                'title': 'Enhanced Long-Term Retention',
                'desc': 'Cognitive science demonstrates that active retrieval immediately following instruction boosts recall and examination performance significantly.'
            }
        ],
        'factsheet': [
            {'label': 'Target Grades', 'value': 'Grades 1 through 12'},
            {'label': 'Subjects Covered', 'value': 'Science, Mathematics, Social Studies & Languages'},
            {'label': 'Classroom Tech', 'value': 'Interactive Flat Panels & Digital Content'},
            {'label': 'Pedagogy Impact', 'value': '100% Classroom Engagement & Zero Doubt Backlog'}
        ]
    },
    {
        'slug': 'libraries-at-mgm',
        'title': 'Libraries at MGM',
        'full_title': 'Libraries at MGM Model School',
        'category_key': 'academic',
        'category_name': 'Academic & Innovation',
        'badge': 'Knowledge & Literary Sanctuary',
        'icon': 'fa-solid fa-book-open-reader',
        'image': 'assets/images/libraries-1.jpeg',
        'gallery': ['assets/images/libraries-1.jpeg', 'assets/images/libraries-2.jpeg', 'assets/images/libraries-3.jpeg'],
        'video': None,
        'video_poster': None,
        'lead': 'Expansive library ecosystem offering over 10,000 literary masterpieces, scientific journals, encyclopedia collections, and quiet reading alcoves fostering lifelong inquiry.',
        'overview': 'The libraries at MGM Model School are vibrant knowledge sanctuaries designed to kindle a love for reading and independent scholarship. Spanning literature, science, history, competitive examination guides, and world periodicals, our library catalog satisfies readers of every grade. Air-conditioned reading alcoves and digital research terminals ensure an inspiring environment for study.',
        'pillars': [
            {
                'icon': 'fa-solid fa-book-bookmark',
                'title': '10,000+ Curated Volumes',
                'desc': 'Extensive collection spanning classic literature, contemporary bestsellers, scientific encyclopedias, and regional vernacular publications.'
            },
            {
                'icon': 'fa-solid fa-laptop',
                'title': 'Digital E-Library Terminals',
                'desc': 'Equipped with networked computers giving students access to verified educational repositories, scholarly journals, and digital archives.'
            },
            {
                'icon': 'fa-solid fa-child-reaching',
                'title': 'Junior Storybook Alcove',
                'desc': 'Dedicated primary section filled with colorful picture books, pop-up volumes, and phonics readers that turn little learners into enthusiastic readers.'
            },
            {
                'icon': 'fa-solid fa-graduation-cap',
                'title': 'Competitive Exam Repository',
                'desc': 'Comprehensive foundation and preparation resources for JEE, NEET, CUET, NDA, Olympiads, and national talent searches.'
            }
        ],
        'factsheet': [
            {'label': 'Book Inventory', 'value': '10,000+ Titles Across All Disciplines'},
            {'label': 'Periodicals & Journals', 'value': '40+ National & Regional Publications'},
            {'label': 'Seating Capacity', 'value': '120+ Scholars in Quiet Study Zones'},
            {'label': 'Digital Access', 'value': 'E-Library Terminals with High-Speed Internet'}
        ]
    },
    {
        'slug': 'poly-house',
        'title': 'Poly House',
        'full_title': 'Poly House Facility',
        'category_key': 'green',
        'category_name': 'Campus & Green Initiatives',
        'badge': 'Smart Agritech & Botany Laboratory',
        'icon': 'fa-solid fa-leaf',
        'image': 'assets/images/poly-house-akshara-muttathe-krishithottam-3.jpeg',
        'gallery': ['assets/images/poly-house-akshara-muttathe-krishithottam-3.jpeg', 'assets/images/polyhouse-garden.jpeg'],
        'video': None,
        'video_poster': None,
        'lead': 'A modern controlled-environment greenhouse structure educating students in microclimate management, precision agriculture, drip irrigation, and sustainable horticulture.',
        'overview': 'MGM Model School bridges environmental responsibility with 21st-century technology through its campus Poly House. Built with UV-stabilized cladding and automated irrigation, the facility allows students to study plant biology under regulated climate conditions. Students witness firsthand how scientific manipulation of temperature, humidity, and nutrients maximizes crop yield sustainably.',
        'pillars': [
            {
                'icon': 'fa-solid fa-temperature-half',
                'title': 'Climate Controlled Environment',
                'desc': 'UV-treated thermal film shields plants from seasonal extremes while controlling internal temperature and relative humidity.'
            },
            {
                'icon': 'fa-solid fa-faucet-drip',
                'title': 'Precision Drip Irrigation',
                'desc': 'Conserves water through calibrated drip lines that deliver moisture directly to plant roots without runoff or evaporation waste.'
            },
            {
                'icon': 'fa-solid fa-seedling',
                'title': 'Hands-on Agritech Botany',
                'desc': 'Students participate in soil nutrient preparation, seedling grafting, trellising, and organic pest mitigation.'
            },
            {
                'icon': 'fa-solid fa-sun-plant-wilt',
                'title': 'Sustainable Food Production',
                'desc': 'Instills deep appreciation for food systems and sustainable ecological practices that combat environmental degradation.'
            }
        ],
        'factsheet': [
            {'label': 'Structure Type', 'value': 'UV-Stabilized Galvanized Steel Polyhouse'},
            {'label': 'Irrigation System', 'value': 'Automated Timer Micro-Drip Irrigation'},
            {'label': 'Crops Cultivated', 'value': 'High-Value Vegetables, Salad Greens & Herbs'},
            {'label': 'Student Programs', 'value': 'Eco-Club & Practical Biology Curriculum'}
        ]
    },
    {
        'slug': 'krishi-thottam',
        'title': 'Akshara Muttathe Krishi Thottam',
        'full_title': 'Akshara Muttathe Krishi Thottam (Organic Farm)',
        'category_key': 'green',
        'category_name': 'Campus & Green Initiatives',
        'badge': 'Award-Winning Campus Organic Farm',
        'icon': 'fa-solid fa-seedling',
        'image': 'assets/images/poly-house-akshara-muttathe-krishithottam-1.jpeg',
        'gallery': ['assets/images/poly-house-akshara-muttathe-krishithottam-1.jpeg', 'assets/images/poly-house-akshara-muttathe-krishithottam-2.jpeg'],
        'video': None,
        'video_poster': None,
        'lead': 'State and district-recognized campus organic farming project where students engage in soil preparation, sowing, organic composting, and harvesting indigenous produce.',
        'overview': 'Akshara Muttathe Krishi Thottam is an acclaimed initiative connecting our learners with the agrarian roots of Kerala. Honored with prestigious state and district honors, the school garden is maintained collaboratively by students, teachers, and agricultural mentors. Students prepare vermicompost, nurture indigenous heirloom seeds, and harvest pesticide-free vegetables for community distribution.',
        'pillars': [
            {
                'icon': 'fa-solid fa-award',
                'title': 'State & District Recognition',
                'desc': 'Decorated with official agriculture department awards for best school farm in the district and community impact.'
            },
            {
                'icon': 'fa-solid fa-recycle',
                'title': '100% Organic Soil Practices',
                'desc': 'No synthetic fertilizers or toxic pesticides. Students generate campus compost, bio-slurry, and natural botanical pest deterrents.'
            },
            {
                'icon': 'fa-solid fa-hands-holding-circle',
                'title': 'Experiential Farming Lifecycle',
                'desc': 'Students experience the satisfaction of tending crops from seed planting through vegetative growth to joyous harvest celebrations.'
            },
            {
                'icon': 'fa-solid fa-carrot',
                'title': 'Heirloom Kerala Produce',
                'desc': 'Cultivating indigenous varieties of spinach, bitter gourd, ash gourd, ladyfingers, tapioca, and bananas.'
            }
        ],
        'factsheet': [
            {'label': 'Accolades', 'value': 'State & District Agricultural Excellence Awards'},
            {'label': 'Farming Philosophy', 'value': '100% Pesticide-Free Natural Farming'},
            {'label': 'Produce Harvested', 'value': 'Indigenous Vegetables, Tubers & Fruits'},
            {'label': 'Student Involvement', 'value': 'Weekly Practical Agriculture Sessions'}
        ]
    },
    {
        'slug': 'amma-school',
        'title': 'Amma School',
        'full_title': 'Amma School &ndash; Parental Partnership Forum',
        'category_key': 'facilities',
        'category_name': 'Student Well-being & Facilities',
        'badge': 'Maternal & Parental Empowerment Forum',
        'icon': 'fa-solid fa-heart',
        'image': 'assets/images/1750242823.jpeg',
        'gallery': ['assets/images/1750242823.jpeg'],
        'video': None,
        'video_poster': None,
        'lead': 'A unique collaborative forum bringing mothers and educators together for regular seminars on modern parenting, adolescent emotional wellness, balanced nutrition, and values-based upbringing.',
        'overview': 'Recognizing that the mother is a child\'s foundational mentor, MGM Model School established "Amma School". This special forum hosts interactive symposiums, workshops, and open counseling discussions led by child psychologists, healthcare practitioners, and senior educators. The forum addresses digital age parenting challenges, screen addiction, nutritional balance, and supportive home communication.',
        'pillars': [
            {
                'icon': 'fa-solid fa-handshake-angle',
                'title': 'Parent-Teacher Synergy',
                'desc': 'Strengthening trust and collaboration between educators and mothers to form a unified supportive cocoon around the child.'
            },
            {
                'icon': 'fa-solid fa-mobile-screen-button',
                'title': 'Digital Age Parenting',
                'desc': 'Practical frameworks for managing screen addiction, gaming influence, and nurturing healthy online habits at home.'
            },
            {
                'icon': 'fa-solid fa-apple-whole',
                'title': 'Adolescent Nutrition & Health',
                'desc': 'Expert pediatrician guidance on balanced diets, immunity, teenage growth milestones, and emotional reassurance.'
            },
            {
                'icon': 'fa-solid fa-comments',
                'title': 'Empathetic Family Dialogue',
                'desc': 'Fostering non-critical, open communication channels between parents and teenagers to prevent anxiety and withdrawal.'
            }
        ],
        'factsheet': [
            {'label': 'Program Format', 'value': 'Monthly Interactive Workshops & Expert Talks'},
            {'label': 'Resource Persons', 'value': 'Child Psychologists, Pediatricians & Educators'},
            {'label': 'Target Audience', 'value': 'Mothers of MGM Model School Students'},
            {'label': 'Core Mission', 'value': 'Harmonious Child Development at Home & School'}
        ]
    },
    {
        'slug': 'vriksha-chikitsa',
        'title': 'Vriksha Chikitsa',
        'full_title': 'Vriksha Chikitsa (Ayurvedic Tree Care)',
        'category_key': 'green',
        'category_name': 'Campus & Green Initiatives',
        'badge': 'Ayurvedic Arboriculture & Tree Healing',
        'icon': 'fa-solid fa-tree',
        'image': 'assets/images/polyhouse-garden.jpeg',
        'gallery': ['assets/images/polyhouse-garden.jpeg'],
        'video': 'assets/videos/vriksha-chikitsa.mp4',
        'video_poster': 'assets/images/polyhouse-garden.jpeg',
        'lead': 'Traditional arboriculture and eco-healing initiative reviving ancient Ayurvedic plant care techniques to protect campus biodiversity and heal aged trees.',
        'overview': 'Vriksha Chikitsa at MGM Model School is an extraordinary ecological program rooted in ancient Surapala Vrikshayurveda treatises. Rather than cutting down ailing or wounded trees, students learn natural surgery and healing techniques. By preparing organic herbal pastes, neem infusions, and cow-dung bio-dressings, students cure arboreal infections and preserve historic campus flora.',
        'pillars': [
            {
                'icon': 'fa-solid fa-mortar-pestle',
                'title': 'Ancient Ayurvedic Formulations',
                'desc': 'Preparation of organic tree healing pastes using turmeric, neem, triphala, and clay to seal bark wounds and fungal lesions.'
            },
            {
                'icon': 'fa-solid fa-shield-virus',
                'title': 'Pest Mitigation Without Chemicals',
                'desc': 'Protecting root structures and trunk cavities from termite infestations using safe botanical decoctions.'
            },
            {
                'icon': 'fa-solid fa-tag',
                'title': 'Botanical Tagging & Mapping',
                'desc': 'Students catalog all campus trees with scientific classifications, medicinal properties, and botanical heritage information.'
            },
            {
                'icon': 'fa-solid fa-hand-holding-heart',
                'title': 'Reverence for Living Nature',
                'desc': 'Fosters profound empathy toward living ecosystems, teaching students that every tree is a sacred sanctuary of life.'
            }
        ],
        'factsheet': [
            {'label': 'Traditional Base', 'value': 'Vrikshayurveda Classical Botanical Science'},
            {'label': 'Healing Mediums', 'value': '100% Herbal Pastes, Neem Oil & Natural Clays'},
            {'label': 'Campus Coverage', 'value': 'All Historic & Native Campus Trees'},
            {'label': 'Student Role', 'value': 'Tree Health Diagnostics & Herb Garden Cultivation'}
        ]
    },
    {
        'slug': 'counselling-centre',
        'title': 'Counselling Centre',
        'full_title': 'Student Counselling Centre',
        'category_key': 'facilities',
        'category_name': 'Student Well-being & Facilities',
        'badge': 'Student Mental Health & Emotional Wellness',
        'icon': 'fa-solid fa-comments',
        'image': 'assets/images/1750242779.jpeg',
        'gallery': ['assets/images/1750242779.jpeg'],
        'video': None,
        'video_poster': None,
        'lead': 'Safe, empathetic psychological guidance and emotional wellness sanctuary staffed by qualified counselors dedicated to student mental health and resilience.',
        'overview': 'Academic success and personal fulfillment flourish when students feel heard, valued, and emotionally secure. The Counselling Centre at MGM Model School offers a warm, strictly confidential space where children can share emotional concerns, academic stress, or family worries. Our licensed child psychologists work collaboratively with learners, teachers, and parents to cultivate resilience and joy.',
        'pillars': [
            {
                'icon': 'fa-solid fa-user-shield',
                'title': 'Strictly Confidential Space',
                'desc': 'Students can discuss feelings, friendship conflicts, and stress in a supportive environment free of judgment.'
            },
            {
                'icon': 'fa-solid fa-feather-pointed',
                'title': 'Exam Stress Reduction',
                'desc': 'Targeted cognitive workshops teaching relaxation techniques, positive self-talk, and smart study time management.'
            },
            {
                'icon': 'fa-solid fa-heart-circle-bolt',
                'title': 'Emotional Resilience Building',
                'desc': 'Equipping children with constructive coping mechanisms to navigate peer pressure, bullying, and emotional setbacks.'
            },
            {
                'icon': 'fa-solid fa-people-arrows',
                'title': 'Parent-Child Mediation',
                'desc': 'Facilitating empathetic dialogue between parents and adolescents to bridge generational perspectives.'
            }
        ],
        'factsheet': [
            {'label': 'Counselor Credentials', 'value': 'Certified Child & Adolescent Psychologists'},
            {'label': 'Facility Standards', 'value': 'Private, Sound-Dampened Consultation Rooms'},
            {'label': 'Availability', 'value': 'All Working School Days & Scheduled Appointments'},
            {'label': 'Services', 'value': 'Individual Counseling, Group Circles & Parental Advisory'}
        ]
    },
    {
        'slug': 'innovation-centre',
        'title': 'Innovation Centre',
        'full_title': 'Governor-Inaugurated Innovation Centre',
        'category_key': 'academic',
        'category_name': 'Academic & Innovation',
        'badge': 'Governor-Inaugurated Maker Space',
        'icon': 'fa-solid fa-flask-vial',
        'image': 'assets/images/1756461341.jpg',
        'gallery': ['assets/images/1756461341.jpg'],
        'video': 'assets/videos/innovation-centre.mp4',
        'video_poster': 'assets/images/1756461341.jpg',
        'lead': 'Inaugurated by the Hon\'ble Governor of Kerala Shri Arif Mohammed Khan, this cutting-edge facility unites robotics, IoT electronics, 3D prototyping, and design thinking.',
        'overview': 'The MGM Innovation Centre represents our commitment to hands-on invention and technology creation. Dignified by the inaugural visit of the Hon\'ble Governor of Kerala Shri Arif Mohammed Khan, the center is equipped with high-precision 3D printers, microcontroller kits, sensory apparatus, and electronic fabrication benches. Students transform imaginative concepts into working prototypes.',
        'pillars': [
            {
                'icon': 'fa-solid fa-cube',
                'title': '3D Printing & Rapid Prototyping',
                'desc': 'Students design CAD models and watch them materialize into tangible plastic prototypes using industrial 3D printers.'
            },
            {
                'icon': 'fa-solid fa-microchip',
                'title': 'IoT & Embedded Robotics',
                'desc': 'Hands-on development with Arduino, Raspberry Pi, ultrasonic sensors, motors, and smart home automation breadboards.'
            },
            {
                'icon': 'fa-solid fa-lightbulb',
                'title': 'Design Thinking Framework',
                'desc': 'Mentored stages of empathy, problem definition, ideation, prototyping, and testing applied to real social challenges.'
            },
            {
                'icon': 'fa-solid fa-trophy',
                'title': 'National Competition Mentorship',
                'desc': 'Dedicated coaching for student delegations competing in CBSE Science Exhibitions, Atal Tinkering Marathons, and Robotics Expos.'
            }
        ],
        'factsheet': [
            {'label': 'Inaugural Dignitary', 'value': 'Shri Arif Mohammed Khan (Hon\'ble Governor of Kerala)'},
            {'label': 'Key Equipment', 'value': 'Industrial 3D Printers, Soldering Benches & IoT Kits'},
            {'label': 'Student Programs', 'value': 'Robotics Club, STEM Olympiads & Invention Labs'},
            {'label': 'Target Grades', 'value': 'Middle & Senior Secondary (Grades 6 to 12)'}
        ]
    },
    {
        'slug': 'gdc',
        'title': 'GDC',
        'full_title': 'Guidance & Development Cell (GDC)',
        'category_key': 'facilities',
        'category_name': 'Student Well-being & Facilities',
        'badge': 'Higher Education & Career Navigation',
        'icon': 'fa-solid fa-compass',
        'image': 'assets/images/1750242752.jpeg',
        'gallery': ['assets/images/1750242752.jpeg'],
        'video': None,
        'video_poster': None,
        'lead': 'Guidance & Development Cell offering specialized career counseling, higher education planning, psychometric aptitude mapping, and competitive examination orientation.',
        'overview': 'The transition from school to higher education requires clear foresight, self-awareness, and strategic preparation. The Guidance & Development Cell (GDC) at MGM Model School guides secondary scholars toward fulfilling collegiate and professional futures. Through psychometric assessments, university application counseling, and competitive examination orientation, students chart their educational paths with confidence.',
        'pillars': [
            {
                'icon': 'fa-solid fa-chart-pie',
                'title': 'Psychometric Aptitude Profiling',
                'desc': 'Scientific evaluation of cognitive strengths, personality traits, and career inclinations to pinpoint optimal career paths.'
            },
            {
                'icon': 'fa-solid fa-book-open',
                'title': 'Competitive Exam Foundation',
                'desc': 'Expert orientation for national examinations including JEE Main/Advanced, NEET, CUET, NDA, CLAT, and NATA.'
            },
            {
                'icon': 'fa-solid fa-globe',
                'title': 'Global University Roadmaps',
                'desc': 'Detailed guidance on university selection, portfolio building, scholarships, and admission procedures for premier Indian and overseas campuses.'
            },
            {
                'icon': 'fa-solid fa-user-tie',
                'title': 'Alumni & Industry Masterclasses',
                'desc': 'Interactive seminars featuring successful alumni, doctors, civil servants, software engineers, and entrepreneurs.'
            }
        ],
        'factsheet': [
            {'label': 'Target Groups', 'value': 'Secondary & Senior Secondary (Grades 9 to 12)'},
            {'label': 'Assessment Tools', 'value': 'Standardized Psychometric & Multiple Intelligence Tests'},
            {'label': 'Entrance Focus', 'value': 'JEE, NEET, CUET, NDA, CLAT & Foundation Programs'},
            {'label': 'Counseling Format', 'value': 'One-on-One Career Mapping & Parent Consultations'}
        ]
    },
    {
        'slug': 'life-skills',
        'title': 'Life Skills',
        'full_title': 'Life Skills Education',
        'category_key': 'skills',
        'category_name': 'Skills & Cadet Corps',
        'badge': '21st Century Competency Framework',
        'icon': 'fa-solid fa-lightbulb',
        'image': 'assets/images/1750233724.jpeg',
        'gallery': ['assets/images/1750233724.jpeg'],
        'video': None,
        'video_poster': None,
        'lead': 'Curriculum-integrated developmental framework focusing on critical thinking, ethical reasoning, financial literacy, communication, and emotional adaptability.',
        'overview': 'Education at MGM Model School extends far beyond memorizing textbooks. Our Life Skills program equips young individuals with practical, emotional, and social competencies essential for real-world independence. Aligned with CBSE and World Health Organization (WHO) benchmarks, our interactive curriculum empowers students to resolve conflicts, manage finances, practice empathy, and lead ethically.',
        'pillars': [
            {
                'icon': 'fa-solid fa-coins',
                'title': 'Practical Financial Literacy',
                'desc': 'Foundational understanding of budgeting, banking operations, the value of savings, and making responsible economic decisions.'
            },
            {
                'icon': 'fa-solid fa-scale-balanced',
                'title': 'Critical & Ethical Thinking',
                'desc': 'Analyzing moral dilemmas, identifying media biases, and forming balanced, reasoned perspectives grounded in human values.'
            },
            {
                'icon': 'fa-solid fa-shield-halved',
                'title': 'Cyber Safety & Digital Etiquette',
                'desc': 'Teaching students how to protect digital identity, recognize phishing/cyberbullying, and maintain a respectful digital footprint.'
            },
            {
                'icon': 'fa-solid fa-person-chalkboard',
                'title': 'Effective Interpersonal Relations',
                'desc': 'Role-plays and teamwork simulations that cultivate active listening, assertiveness, and constructive conflict resolution.'
            }
        ],
        'factsheet': [
            {'label': 'Curriculum Standard', 'value': 'Aligned with WHO Life Skills & CBSE Guidelines'},
            {'label': 'Class Structure', 'value': 'Weekly Experiential Workshops & Group Debriefs'},
            {'label': 'Key Competencies', 'value': 'Critical Thinking, Empathy, Communication & Money Smarts'},
            {'label': 'Target Grades', 'value': 'Primary, Middle & Secondary Scholars'}
        ]
    },
    {
        'slug': 'voice-of-mgm',
        'title': 'Voice of MGM',
        'full_title': 'Voice of MGM &ndash; School Radio Club',
        'category_key': 'skills',
        'category_name': 'Skills & Cadet Corps',
        'badge': 'Campus Radio & Broadcasting Studio',
        'icon': 'fa-solid fa-microphone',
        'image': 'assets/images/1751285378.jpeg',
        'gallery': ['assets/images/1751285378.jpeg', 'assets/images/1750233709.jpeg'],
        'video': None,
        'video_poster': None,
        'lead': 'Official campus radio and broadcasting studio empowering students to host news broadcasts, audio podcasts, creative storytelling, and interviews.',
        'overview': 'The "Voice of MGM" Radio Club provides an authentic broadcasting platform for students to cultivate self-assurance, develop polished public speaking skills, and broadcast creative stories across our campus community. Officially inaugurated by Smt. Rashmi Roja Thushara Nair IAS, Bureau Director of the Press Information Bureau (PIB), the club features soundproof recording booths, digital audio mixers, and student-run production desks.',
        'pillars': [
            {
                'icon': 'fa-solid fa-microphone-lines',
                'title': 'Confidence Building',
                'desc': 'Speaking into an acoustic studio microphone allows children to express themselves naturally and overcome public stage apprehension.'
            },
            {
                'icon': 'fa-solid fa-bullhorn',
                'title': 'Public Speaking & Diction',
                'desc': 'Mastering voice modulation, pronunciation, cadence, and storytelling eloquence to communicate compelling narratives.'
            },
            {
                'icon': 'fa-solid fa-pen-nib',
                'title': 'Journalistic Scripting',
                'desc': 'Drafting daily campus news updates, science trivia bulletins, cultural features, and interview question cues.'
            },
            {
                'icon': 'fa-solid fa-headphones',
                'title': 'Sound Engineering & Production',
                'desc': 'Students operate digital mixing consoles, sound effects software, and podcast recording workflows independently.'
            }
        ],
        'factsheet': [
            {'label': 'Inaugural Dignitary', 'value': 'Smt. Rashmi Roja Thushara Nair IAS (Director PIB)'},
            {'label': 'Broadcast Format', 'value': 'Daily Campus Morning News, Announcements & Audio Podcasts'},
            {'label': 'Studio Gear', 'value': 'Acoustic Soundproofing, Broadcast Mics & Digital Mixers'},
            {'label': 'Student Roles', 'value': 'Radio Jockeys, News Anchors, Scriptwriters & Sound Techs'}
        ]
    },
    {
        'slug': 'school-canteen',
        'title': 'School Canteen',
        'full_title': 'School Canteen Facility',
        'category_key': 'facilities',
        'category_name': 'Student Well-being & Facilities',
        'badge': 'Hygienic & Nutritious Dining',
        'icon': 'fa-solid fa-utensils',
        'image': 'assets/images/school-canteen.jpeg',
        'gallery': ['assets/images/school-canteen.jpeg', 'assets/images/canteen.jpeg'],
        'video': None,
        'video_poster': None,
        'lead': 'Spotless, hygienic dining hall serving fresh, wholesome, balanced vegetarian meals and healthy snacks in accordance with strict dietary health regulations.',
        'overview': 'Nutritional vitality directly fuels academic performance and physical stamina. The MGM Model School Canteen operates in an expansive, immaculate dining hall where fresh, nutritious vegetarian meals are prepared daily under rigorous food safety standards. With dedicated seating, separate hand-wash stations, and multi-stage RO purified drinking water, the canteen fosters a joyful, healthy communal dining culture.',
        'pillars': [
            {
                'icon': 'fa-solid fa-bowl-food',
                'title': '100% Wholesome Vegetarian Menu',
                'desc': 'Balanced meal plans designed to provide essential proteins, vitamins, and minerals without excess oil or refined sugars.'
            },
            {
                'icon': 'fa-solid fa-ban',
                'title': 'Zero Junk Food Guarantee',
                'desc': 'Strict school policy prohibiting carbonated soft drinks, artificial food colors, deep-fried junk food, or chemical preservatives.'
            },
            {
                'icon': 'fa-solid fa-bottle-water',
                'title': 'Multi-Stage RO Drinking Water',
                'desc': 'High-capacity Reverse Osmosis filtration stations offering pure, safe, and regularly lab-tested drinking water throughout campus.'
            },
            {
                'icon': 'fa-solid fa-sparkles',
                'title': 'Spotless Hygiene & Sanitization',
                'desc': 'Continuous cleaning cycles, stainless steel cookware, steam-sanitized dining tables, and hygienic culinary staff.'
            }
        ],
        'factsheet': [
            {'label': 'Dietary Standard', 'value': '100% Wholesome Vegetarian & Freshly Prepared Daily'},
            {'label': 'Drinking Water', 'value': 'Multi-Stage Commercial RO Purified Water Stations'},
            {'label': 'Seating Capacity', 'value': '250+ Students in Spacious Dining Hall'},
            {'label': 'Hygiene Compliance', 'value': 'Regular Sanitization & Strict Quality Inspections'}
        ]
    },
    {
        'slug': 'butterfly-garden',
        'title': 'Butterfly Garden and Kids Zone',
        'full_title': 'Butterfly Garden & Kids Adventure Zone',
        'category_key': 'green',
        'category_name': 'Campus & Green Initiatives',
        'badge': 'Biodiversity & Early Learning Sanctuary',
        'icon': 'fa-solid fa-shapes',
        'image': 'assets/images/butterfly-garden-1.jpeg',
        'gallery': ['assets/images/butterfly-garden-1.jpeg', 'assets/images/butterfly-garden-2.jpeg'],
        'video': None,
        'video_poster': None,
        'lead': 'Captivating biodiversity garden attracting colorful butterflies amidst native nectar flora, coupled with a safe adventure playground for early learners.',
        'overview': 'Combining environmental wonder with joyful outdoor play, the Butterfly Garden and Kids Zone at MGM Model School is a magical sanctuary for our youngest scholars. Planted with specialized nectar-rich shrubs and larval host plants, the garden attracts dozens of indigenous butterfly species. Adjoining the greenery is a safe, shock-absorbing playground equipped with modern motor-skill play apparatus.',
        'pillars': [
            {
                'icon': 'fa-solid fa-seedling',
                'title': 'Pollinator Habitat Ecosystem',
                'desc': 'Cultivated with native host plants like milkweed, marigold, and ixora supporting butterfly lifecycles from caterpillar to chrysalis.'
            },
            {
                'icon': 'fa-solid fa-child',
                'title': 'Safe Shock-Absorbing Play Turf',
                'desc': 'Equipped with certified soft-landing turf, ergonomic toddler swings, see-saws, and balance play structures.'
            },
            {
                'icon': 'fa-solid fa-magnifying-glass',
                'title': 'Experiential Outdoor Nature Walks',
                'desc': 'Kindergarten and primary teachers conduct guided nature walks where children observe metamorphism and insect pollination firsthand.'
            },
            {
                'icon': 'fa-solid fa-shield-cat',
                'title': 'Secure Enclosed Perimeter',
                'desc': 'Dedicated child-safe fencing and continuous staff supervision ensuring little learners explore and play with complete safety.'
            }
        ],
        'factsheet': [
            {'label': 'Target Groups', 'value': 'Kindergarten, Pre-Primary & Lower Primary Students'},
            {'label': 'Flora Diversity', 'value': '30+ Species of Native Butterfly Host & Nectar Plants'},
            {'label': 'Play Equipment', 'value': 'Ergonomic Swings, Slides, Climbing Arcs & Soft Turf'},
            {'label': 'Pedagogy Integration', 'value': 'Early Childhood Science & Outdoor Sensory Play'}
        ]
    },
    {
        'slug': '3d-max-zone',
        'title': '3D Max Zone',
        'full_title': '3D Max Zone (Mathematics Laboratory)',
        'category_key': 'academic',
        'category_name': 'Academic & Innovation',
        'badge': 'Experiential Spatial Mathematics Lab',
        'icon': 'fa-solid fa-cube',
        'image': 'assets/images/maths-zone-3d.jpeg',
        'gallery': ['assets/images/maths-zone-3d.jpeg', 'assets/images/maths-zone.jpeg'],
        'video': None,
        'video_poster': None,
        'lead': 'Specialised mathematics and spatial reasoning lab equipped with tangible geometric solids, coordinate frames, and 3D manipulative models.',
        'overview': 'Abstract mathematical theorems can intimidate students when restricted to two-dimensional blackboards. The 3D Max Zone at MGM Model School demystifies mathematics through tangible, tactile inquiry. Featuring three-dimensional polyhedral structures, coordinate plane projectors, geometric dissection puzzles, and algebraic kits, the lab turns complex formulas into intuitive physical realities.',
        'pillars': [
            {
                'icon': 'fa-solid fa-shapes',
                'title': 'Tangible 3D Geometric Solids',
                'desc': 'Platonic solids, prisms, pyramids, and truncated polyhedra that students assemble, measure, and dissect physically.'
            },
            {
                'icon': 'fa-solid fa-chart-column',
                'title': '3D Coordinate & Vector Frames',
                'desc': 'Hands-on apparatus demonstrating three-dimensional Cartesian axes, spatial vectors, and conic sections intuitively.'
            },
            {
                'icon': 'fa-solid fa-puzzle-piece',
                'title': 'Algebraic & Trigonometric Manipulatives',
                'desc': 'Tactile models proving Pythagorean theorems, algebraic identities, and trigonometric ratios through physical assembly.'
            },
            {
                'icon': 'fa-solid fa-lightbulb',
                'title': 'Fostering Spatial Intuition',
                'desc': 'Cultivates the geometric insight, architectural thinking, and analytical problem-solving required for engineering careers.'
            }
        ],
        'factsheet': [
            {'label': 'Curriculum Alignment', 'value': 'CBSE Mathematics Laboratory Practical Framework'},
            {'label': 'Inventory', 'value': '50+ Tactile Spatial Manipulatives & Proof Kits'},
            {'label': 'Target Grades', 'value': 'Grades 4 through 12'},
            {'label': 'Learning Outcome', 'value': 'Transforms Abstract Formulas into Tangible Understanding'}
        ]
    },
    {
        'slug': 'ominis',
        'title': 'Ominis',
        'full_title': 'Ominis &ndash; MGM\'s Interactive Humanoid AI Robot',
        'category_key': 'academic',
        'category_name': 'Academic & Innovation',
        'badge': 'Interactive Humanoid AI Robot',
        'icon': 'fa-solid fa-robot',
        'image': 'assets/images/omnis-robot.jpeg',
        'gallery': ['assets/images/omnis-robot.jpeg'],
        'video': None,
        'video_poster': None,
        'lead': 'MGM\'s state-of-the-art interactive humanoid robot companion that engages students in conversations, explains scientific phenomena, and showcases real-world AI.',
        'overview': 'Embodying MGM Model School\'s forward-looking spirit, "Ominis" is our flagship humanoid robotics ambassador. Powered by artificial intelligence, conversational speech synthesis, and multi-axis servo motor kinematics, Ominis greets campus guests, interacts with students during science expos, and answers questions on physics, space exploration, and mathematics.',
        'pillars': [
            {
                'icon': 'fa-solid fa-comments',
                'title': 'Conversational AI Dialogue',
                'desc': 'Equipped with natural language processing and speech recognition to converse intelligibly with students and distinguished visitors.'
            },
            {
                'icon': 'fa-solid fa-gears',
                'title': 'Precision Robotic Kinematics',
                'desc': 'Multi-axis articulators enable lifelike head turning, expressive eye graphics, and coordinated arm gestures.'
            },
            {
                'icon': 'fa-solid fa-handshake',
                'title': 'Campus Ambassador & Host',
                'desc': 'Featured during major institutional inaugurations, science exhibitions, and high-profile gubernatorial visits.'
            },
            {
                'icon': 'fa-solid fa-code',
                'title': 'Inspiring Engineering Aspirations',
                'desc': 'Exposes learners to the fusion of mechanical engineering, computer science, sensor integration, and artificial intelligence.'
            }
        ],
        'factsheet': [
            {'label': 'Platform Type', 'value': 'Autonomous Interactive Humanoid AI Robot'},
            {'label': 'Key Capabilities', 'value': 'Speech Recognition, Conversational AI & Kinematic Gestures'},
            {'label': 'Role', 'value': 'Campus Technology Ambassador & STEM Demonstrator'},
            {'label': 'Public Appearances', 'value': 'Gubernatorial Inaugurations, Science Fairs & Tech Workshops'}
        ]
    },
    {
        'slug': 'nova-ai-hub',
        'title': 'NOVA AI Hub',
        'full_title': 'NOVA AI Hub &ndash; Artificial Intelligence & Robotics Studio',
        'category_key': 'academic',
        'category_name': 'Academic & Innovation',
        'badge': 'Premier CBSE AI & Robotics Studio',
        'icon': 'fa-solid fa-microchip',
        'image': 'assets/images/1756461341.jpg',
        'gallery': ['assets/images/1756461341.jpg'],
        'video': 'assets/videos/nova-ai-hub.mp4',
        'video_poster': 'assets/images/1756461341.jpg',
        'lead': 'Dedicated AI innovation and introductory robotics studio for junior and primary learners featuring modular Cubelets, MIKO AI robots, and block coding.',
        'overview': 'The NOVA AI Hub at MGM Model School is an immersive studio engineered to cultivate computational literacy, algorithmic thinking, and robotic engineering from the earliest foundational years. Guided by certified STEM instructors, students build autonomous machines using Cubelets magnetic blocks, converse with MIKO AI companions, and master block-based coding algorithms without screen fatigue.',
        'pillars': [
            {
                'icon': 'fa-solid fa-cubes',
                'title': 'Cubelets Modular Robotics',
                'desc': 'Magnetic sensor, thinker, and actuator blocks that snap together to build autonomous robots demonstrating sense-think-act loops.'
            },
            {
                'icon': 'fa-solid fa-robot',
                'title': 'MIKO 3 AI Companion Lab',
                'desc': 'Intelligent conversational robots that engage learners in interactive quizzes, emotional learning games, and coding challenges.'
            },
            {
                'icon': 'fa-solid fa-code-compare',
                'title': 'Block-Based Algorithm Coding',
                'desc': 'Intuitive visual drag-and-drop programming environments that build strong algorithmic foundations preparing students for Python.'
            },
            {
                'icon': 'fa-solid fa-lightbulb',
                'title': 'Screen-Healthy Exploratory Learning',
                'desc': 'Balanced sensory tinkering that nurtures problem-solving, spatial reasoning, and teamwork while avoiding passive screen burnout.'
            }
        ],
        'factsheet': [
            {'label': 'Studio Focus', 'value': 'Foundational AI, Modular Robotics & Computational Logic'},
            {'label': 'Primary Hardware', 'value': 'Cubelets Robot Blocks, MIKO 3 Smart AI Robots & Sensor Kits'},
            {'label': 'Curriculum Alignment', 'value': 'CBSE Artificial Intelligence & Coding Skill Subject'},
            {'label': 'Target Scholars', 'value': 'Primary, Middle & Secondary Students (Grades 1 to 12)'}
        ]
    },
    {
        'slug': 'ncc',
        'title': 'NCC',
        'full_title': 'National Cadet Corps (NCC &ndash; Army Wing)',
        'category_key': 'skills',
        'category_name': 'Skills & Cadet Corps',
        'badge': 'Patriotism, Character & Military Discipline',
        'icon': 'fa-solid fa-person-military-pointing',
        'image': 'assets/images/ncc-unit-1.jpeg',
        'gallery': ['assets/images/ncc-unit-1.jpeg', 'assets/images/ncc-unit-2.jpeg', 'assets/images/ncc-1.jpeg', 'assets/images/ncc-2.jpeg'],
        'video': None,
        'video_poster': None,
        'lead': 'Premier Junior Division National Cadet Corps wing instilling patriotism, military discipline, leadership character, physical endurance, and selfless service.',
        'overview': 'The National Cadet Corps (NCC) Army Wing at MGM Model School operates under 1 Kerala Battalion, nurturing patriotic, courageous, and disciplined leaders of tomorrow. Under the guidance of our Associate NCC Officer Retd. Subedar Major Rajesh S, cadets undergo systematic rifle drills, physical obstacle courses, map reading, and national integration camps, building indomitable character and teamwork.',
        'pillars': [
            {
                'icon': 'fa-solid fa-person-military-rifle',
                'title': '1 Kerala Battalion Army Wing',
                'desc': 'Officially affiliated Junior Division unit adhering strictly to Indian Army training protocols, ceremonial drills, and discipline.'
            },
            {
                'icon': 'fa-solid fa-tents',
                'title': 'Combined Annual Training Camps',
                'desc': 'Cadets represent the school in rigorous outdoor camps (CATC), firing simulations, obstacle courses, and national integration expeditions.'
            },
            {
                'icon': 'fa-solid fa-hand-holding-hand',
                'title': 'Community Leadership & Service',
                'desc': 'Pioneering blood donation drives, coastal clean-up expeditions, road safety awareness, and disaster relief preparedness rallies.'
            },
            {
                'icon': 'fa-solid fa-medal',
                'title': 'Defense & Civil Service Gateway',
                'desc': 'Earns official NCC \'A\' certification conferring valuable bonus weighting in NDA, CDS, defense forces, and collegiate admissions.'
            }
        ],
        'factsheet': [
            {'label': 'Unit Affiliation', 'value': '1 Kerala Battalion NCC (Army Wing)'},
            {'label': 'Active Cadets', 'value': '100+ Enrolled Cadets (Junior Division)'},
            {'label': 'Officer Lead', 'value': 'Retd. Subedar Major Rajesh S (Associate NCC Officer)'},
            {'label': 'Certification', 'value': 'Official NCC \'A\' Certificate on Course Completion'}
        ]
    },
    {
        'slug': 'hindustan-scouts-guides',
        'title': 'Hindustan Scouts and Guides',
        'full_title': 'Hindustan Scouts and Guides Troop',
        'category_key': 'skills',
        'category_name': 'Skills & Cadet Corps',
        'badge': 'State-Decorated Rajya Puraskar Troop',
        'icon': 'fa-solid fa-award',
        'image': 'assets/images/scouts-and-guides.jpeg',
        'gallery': ['assets/images/scouts-and-guides.jpeg', 'assets/images/scout-and-guide.jpeg'],
        'video': None,
        'video_poster': None,
        'lead': 'Prestigious troop decorated with multiple Rajya Puraskar Governor Awards, mastering wilderness outdoor survival, civic duty, first-aid, and leadership.',
        'overview': 'As part of our commitment to moral fortitude and selfless civic duty, MGM Model School has partnered with Hindustan Scouts and Guides Kerala since 2019. Led by certified Scout Master Mr. Pravin S R, our troop of 104 active cadets is celebrated as one of the state\'s most distinguished. Notably, 45 cadets have won the prestigious Rajyapuraskar (Governor\'s Award) across successive state rallies.',
        'pillars': [
            {
                'icon': 'fa-solid fa-trophy',
                'title': '45 Rajyapuraskar Governor Awards',
                'desc': 'Honored by the Hon\'ble Governor of Kerala for exemplary wilderness survival, civic leadership, and state jamboree performance.'
            },
            {
                'icon': 'fa-solid fa-compass',
                'title': 'Wilderness Outdoor Survival',
                'desc': 'Mastery of pioneering knot-tying, tracking, compass navigation, bridge construction, and bivouac tent pitching.'
            },
            {
                'icon': 'fa-solid fa-kit-medical',
                'title': 'Emergency First Aid & Rescue',
                'desc': 'Comprehensive disaster response training: CPR, stretcher fabrication, bandaging, and community emergency management.'
            },
            {
                'icon': 'fa-solid fa-fire',
                'title': 'Campfire Brotherhood & Civic Duty',
                'desc': 'Instills the timeless Scout Law: trustworthiness, loyalty, courtesy, cleanliness, and dedication to God and country.'
            }
        ],
        'factsheet': [
            {'label': 'Active Membership', 'value': '104 Active Cadets (1 Troop, 1 Guide Co, 1 Rover-Ranger Unit)'},
            {'label': 'Governor Laureates', 'value': '45 Prestigious Rajyapuraskar Award Winners'},
            {'label': 'Scout Master Lead', 'value': 'Mr. Pravin S R (Certified Scout Master)'},
            {'label': 'State Rallies', 'value': 'Consecutive Honors in 2019, 2022, 2023, and 2024'}
        ]
    },
    {
        'slug': 'school-band-troop',
        'title': 'School Band Troop',
        'full_title': 'Ceremonial School Band Troop',
        'category_key': 'skills',
        'category_name': 'Skills & Cadet Corps',
        'badge': 'Ceremonial Marching Brass & Percussion',
        'icon': 'fa-solid fa-drum',
        'image': 'assets/images/investiture-ceremony.jpeg',
        'gallery': ['assets/images/investiture-ceremony.jpeg'],
        'video': None,
        'video_poster': None,
        'lead': 'Ceremonial marching brass and percussion band troop performing synchronized drills, patriotic anthems, and martial salutes with precision.',
        'overview': 'The ceremonial drumbeat and brass fanfare of the MGM Model School Band Troop elevate every solemn campus assembly. Dressed in striking ceremonial regalia with embroidered sashes, our band members undergo rigorous rhythmic drill practice. The troop leads all school investitures, annual sports meets, Independence Day parades, and honors visiting state dignitaries with crisp martial salutes.',
        'pillars': [
            {
                'icon': 'fa-solid fa-drum',
                'title': 'Marching Percussion & Brass Ensemble',
                'desc': 'Trained on bass drums, side snare drums, tenor drums, bugles, cymbals, and glockenspiel xylophones.'
            },
            {
                'icon': 'fa-solid fa-person-walking',
                'title': 'Synchronized Marching Drill Formations',
                'desc': 'Performing disciplined field manoeuvres, countermarches, and complex formation changes with impeccable spatial precision.'
            },
            {
                'icon': 'fa-solid fa-flag',
                'title': 'Ceremonial Honors for Dignitaries',
                'desc': 'Providing guard of honor fanfares and ceremonial national anthem salutes during gubernatorial and state visits.'
            },
            {
                'icon': 'fa-solid fa-music',
                'title': 'Teamwork, Rhythm & Confidence',
                'desc': 'Fosters collective synchronization, musical ear training, leadership character, and unshakeable stage poise.'
            }
        ],
        'factsheet': [
            {'label': 'Instrumentation', 'value': 'Side Snare Drums, Bass Drums, Bugles, Cymbals & Glockenspiels'},
            {'label': 'Ceremonial Regalia', 'value': 'Official School Uniform with Epaulettes, Sashes & Plumes'},
            {'label': 'Key Performances', 'value': 'Investiture Ceremony, Annual Sports Meet, Independence Day'},
            {'label': 'Student Leadership', 'value': 'Band Major & Section Captains Leading Formations'}
        ]
    },
    {
        'slug': 'happiness-room',
        'title': 'Happiness Room',
        'full_title': 'Happiness Room &ndash; Rejuvenation Sanctuary',
        'category_key': 'facilities',
        'category_name': 'Student Well-being & Facilities',
        'badge': 'Mindfulness & Emotional Sanctuary',
        'icon': 'fa-solid fa-face-smile',
        'image': 'assets/images/1750242382.jpeg',
        'gallery': ['assets/images/1750242382.jpeg'],
        'video': None,
        'video_poster': None,
        'lead': 'Serene emotional rejuvenation sanctuary designed with sensory calming corners, mindfulness meditation spaces, and creative expressive art therapy.',
        'overview': 'In today\'s fast-paced academic landscape, creating space for mental pause, emotional decompression, and genuine joy is essential. The "Happiness Room" at MGM Model School is a beautifully designed sanctuary created to alleviate stress, cultivate gratitude, and recharge student energy. Filled with comfortable beanbags, meditation mats, art therapy supplies, and soothing acoustics, it brings smiles back to young faces.',
        'pillars': [
            {
                'icon': 'fa-solid fa-spa',
                'title': 'Sensory Relaxation Zones',
                'desc': 'Plush ergonomic seating, warm ambient natural lighting, and sound-absorbing acoustic design for quiet decompression.'
            },
            {
                'icon': 'fa-solid fa-palette',
                'title': 'Expressive Art & Mandala Therapy',
                'desc': 'Non-evaluative creative painting, mandala coloring, clay molding, and expressive journaling to release bottled anxiety.'
            },
            {
                'icon': 'fa-solid fa-wind',
                'title': 'Guided Mindfulness & Breathing',
                'desc': 'Brief, guided breathwork and meditation sessions that reset elevated stress levels and restore focused clarity.'
            },
            {
                'icon': 'fa-solid fa-face-laugh-beam',
                'title': 'Cultivating Joy & Gratitude',
                'desc': 'Interactive gratitude walls and positive affirmations reminding students that their self-worth transcends exam numbers.'
            }
        ],
        'factsheet': [
            {'label': 'Room Ambience', 'value': 'Acoustic Sound-Dampening, Warm Light & Natural Greenery'},
            {'label': 'Activities Offered', 'value': 'Guided Breathwork, Art Therapy, Meditation & Calming Puzzles'},
            {'label': 'Target Beneficiaries', 'value': 'All Students & Faculty Members Seeking Recharge'},
            {'label': 'Operational Hours', 'value': 'Open Throughout All School Working Hours'}
        ]
    }
]

print(f"Total highlights loaded: {len(HIGHLIGHTS_DATA)}")
