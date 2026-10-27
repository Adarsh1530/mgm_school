<?php
/**
 * Campus Highlights Module
 * Exact Content from HIGHLIGHTS -1.docx
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = 'highlights';
$pageTitle = 'Campus Highlights';
$breadcrumbTitle = 'Highlights';
$metaDescription = 'Explore the distinctive campus highlights of MGM Model School, Ayiroor, Varkala — from our National Water Award recognition to our swimming pool, 20-20 teaching method, robotics, and eco-initiatives.';

$highlights = json_decode(<<<'JSON'
[
  {
    "id": "swimming-pool",
    "order": 1,
    "title": "Swimming Pool Facility",
    "category_key": "facilities",
    "category_name": "Student Well-being & Facilities",
    "image": "assets/images/swimming-pool-1.jpeg",
    "icon": "fa-solid fa-person-swimming",
    "url": "/swimming-pool/",
    "has_dedicated_page": true,
    "video": "assets/videos/swimming-pool.mp4",
    "summary": "Our state-of-the-art swimming pool complex has been a vibrant part of our campus for the last three years, enhancing the physical fitness and holistic development of our students.",
    "details": "Our facility features two pools, including a pool exclusively for children below 8 years. Designed and constructed with the highest safety standards, the pools are managed by well-trained and qualified coaches who ensure expert guidance and constant supervision.",
    "bullets": [
      "Two distinct pools including an exclusive shallow pool for children under 8 years",
      "Constructed strictly adhering to highest aquatic safety standards",
      "Supervised by well-trained and qualified professional coaches",
      "Enhances physical stamina, water safety skills and holistic development"
    ],
    "tags": [
      "Physical Fitness & Water Safety",
      "Dual-Pool Complex (Senior & Junior under 8)"
    ]
  },
  {
    "id": "twenty-twenty-method",
    "order": 2,
    "title": "20-20 Method of Teaching",
    "category_key": "academic",
    "category_name": "Academic & Innovation",
    "image": "assets/images/twenty-twenty-method.jpeg",
    "icon": "fa-solid fa-chalkboard-user",
    "url": "/twenty-twenty-method/",
    "has_dedicated_page": true,
    "summary": "At MGM Model School, true education is not about imposing knowledge, but about nurturing the power of thought in every student. Our innovative Twenty-20 method redefines the 40-minute period into 20 minutes for the teacher and 20 minutes for the students. The next day's topic is given in advance, so students come prepared.",
    "details": "Each day, 5 students present their understanding in 4 minutes each, ensuring every child gets a chance to think, speak and lead. The best presentations are appreciated and encouraged, building confidence, communication skills, critical thinking and independent learning.",
    "bullets": [
      "Redefines the 40-minute period into 20 mins teacher instruction & 20 mins student presentation",
      "Next day's topic assigned in advance ensuring self-study and preparation",
      "5 students present daily for 4 minutes each, ensuring every child participates",
      "Builds confidence, communication skills, critical thinking and leadership"
    ],
    "tags": [
      "Innovative Pedagogical Model",
      "20 Mins Teacher & 20 Mins Students"
    ]
  },
  {
    "id": "libraries-at-mgm",
    "order": 3,
    "title": "Libraries @ MGM",
    "category_key": "academic",
    "category_name": "Academic & Innovation",
    "image": "assets/images/libraries-1.jpeg",
    "icon": "fa-solid fa-book-open-reader",
    "url": "/libraries-at-mgm/",
    "has_dedicated_page": true,
    "summary": "MGM Model School houses three well-stocked libraries catering to Primary, Secondary and Higher Secondary sections - fostering a love for reading, learning, and inquiry from an early age. Our Secondary Library is digitalized, giving students seamless access to e-books, reference materials and digital learning resources, while still preserving the joy of traditional reading.",
    "details": "We believe a library is where curiosity takes flight and knowledge finds its true meaning.",
    "bullets": [
      "Three well-stocked libraries dedicated to Primary, Secondary & Higher Secondary",
      "Digitalized Secondary Library with e-books and online reference archives",
      "Preserves the timeless joy of traditional reading alongside digital resources",
      "Fosters lifelong habits of inquiry, intellectual exploration and scholarship"
    ],
    "tags": [
      "Knowledge & Reading Sanctuary",
      "3 Libraries (Primary, Secondary & Higher Secondary)"
    ]
  },
  {
    "id": "poly-house",
    "order": 4,
    "title": "Polyhouse - Aksharammuttathe Krishithottam",
    "category_key": "green",
    "category_name": "Campus & Green Initiatives",
    "image": "assets/images/poly-house-akshara-muttathe-krishithottam-3.jpeg",
    "icon": "fa-solid fa-leaf",
    "url": "/poly-house/",
    "has_dedicated_page": true,
    "summary": "Cultivating the culture of farming among the new generation, MGM Model School, Ayiroor, Varkala has established a Hi-Tech Vegetable Garden (Polyhouse) in our campus. The Polyhouse was inaugurated by Adv. K. M. Laji, Chairman, Varkala Municipality. The inaugural function was welcomed by Principal Dr. Pooja S. and presided over by PTA President Sri. V. Haridev.",
    "details": "Felicitations were offered by Smt. Soorya, President, Elakamon Grama Panchayat and Sri. G. Anil Kumar, Assistant Agriculture Officer. Trust Secretary Dr. P. K. Sukumaran felicitated the chief guest. The function was graced by Science Club Coordinator Ms. Sini S. R. and members of the teaching faculty. With the vision of instilling the value and importance of agriculture in our students, this green initiative \u2013 Aksharammuttathe Krishithottam \u2013 was dedicated to our children, to inspire them towards farming and to nurture the promises of tomorrow.",
    "bullets": [
      "Hi-Tech Vegetable Garden Polyhouse established on school campus",
      "Inaugurated by Adv. K. M. Laji, Chairman, Varkala Municipality",
      "Supported by Elakamon Grama Panchayat & Assistant Agriculture Officer",
      "Instills respect for agrarian labor, food sovereignty and sustainable cultivation"
    ],
    "tags": [
      "Hi-Tech Agriculture Initiative",
      "Hi-Tech Vegetable Garden Polyhouse"
    ]
  },
  {
    "id": "krishi-thottam",
    "order": 5,
    "title": "Aksharammuttathe Krishithottam",
    "category_key": "green",
    "category_name": "Campus & Green Initiatives",
    "image": "assets/images/poly-house-akshara-muttathe-krishithottam-3.jpeg",
    "icon": "fa-solid fa-seedling",
    "url": "/krishi-thottam/",
    "has_dedicated_page": true,
    "summary": "With the vision of instilling the value and importance of agriculture in our students, this green initiative \u2013 Aksharammuttathe Krishithottam \u2013 was dedicated to our children, to inspire them towards farming and to nurture the promises of tomorrow.",
    "details": "Cultivating the culture of farming among the new generation, MGM Model School, Ayiroor, Varkala has established a Hi-Tech Vegetable Garden (Polyhouse) in our campus. The inaugural function was welcomed by Principal Dr. Pooja S. and presided over by PTA President Sri. V. Haridev. Felicitations were offered by Smt. Soorya, President, Elakamon Grama Panchayat and Sri. G. Anil Kumar, Assistant Agriculture Officer. Trust Secretary Dr. P. K. Sukumaran felicitated the chief guest.",
    "bullets": [
      "Dedicated campus vegetable cultivation connecting students to nature",
      "Encourages organic agriculture and sustainable green habits",
      "Active mentorship from Agricultural Officers and Science Club teachers",
      "Nurtures environmental consciousness and practical farming skills"
    ],
    "tags": [
      "Campus Green Agriculture",
      "Aksharammuttathe Krishithottam"
    ]
  },
  {
    "id": "amma-school",
    "order": 6,
    "title": "Amma School",
    "category_key": "facilities",
    "category_name": "Student Well-being & Facilities",
    "image": "assets/images/amma-school-clean.jpeg",
    "icon": "fa-solid fa-heart",
    "url": "/amma-school/",
    "has_dedicated_page": true,
    "summary": "Amma School was established with the noble aim of empowering parents with the knowledge and skills to raise confident and resilient children. In today's fast-paced world, children face numerous challenges that require guidance and support.",
    "details": "Through Amma School, we strive to create awareness among parents about the various issues adolescents encounter and provide them with practical strategies to nurture their children into responsible citizens. The Amma School was inaugurated by Sri. Udit Chaithanya, marking the beginning of a journey to foster positive change in our community.",
    "bullets": [
      "Empowers parents with skills to raise confident, resilient children",
      "Creates awareness about adolescent growth, emotional wellness and modern challenges",
      "Offers practical parenting strategies to nurture responsible citizens",
      "Inaugurated by esteemed motivational speaker Sri. Udit Chaithanya"
    ],
    "tags": [
      "Parental Empowerment Platform",
      "Amma School Parental Forum"
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
    "url": "/vriksha-chikitsa/",
    "has_dedicated_page": true,
    "video": "assets/videos/vriksha-chikitsa.mp4",
    "summary": "In the year 2024, MGM Model School, Ayiroor, Varkala took a unique step towards environmental conservation by organizing a \"Vriksha Chikitsa\" \u2013 Traditional Ayurvedic Tree Treatment project in our campus.",
    "details": "The program was led by renowned tree healer and environmental activist Shri. K. Binu, popularly known as Vriksha Vaidyan or 'Tree Doctor'. The Kerala-based Tree Doctor enlightened our students about the meticulous process involved in the preparation of Ayurvedic medicines for healing injured trees. As part of this green initiative, we invited Shri. Binu and his team to treat and rejuvenate our beloved jackfruit tree, aged over 40 years, standing tall in our campus. The ancient Ayurvedic healing ritual gave our children a rare and inspiring lesson on compassion, conservation and co-existing with nature.",
    "bullets": [
      "Led by renowned tree healer Shri. K. Binu (popularly known as Vriksha Vaidyan / 'Tree Doctor')",
      "Hands-on demonstration of traditional Ayurvedic medicine preparation for plants",
      "Rejuvenation of campus 40+ year-old heritage jackfruit tree",
      "Inspiring practical lesson on compassion, conservation and co-existing with nature"
    ],
    "tags": [
      "Traditional Eco-Conservation",
      "Organized in 2024"
    ]
  },
  {
    "id": "counselling-centre",
    "order": 8,
    "title": "Counselling Centre",
    "category_key": "facilities",
    "category_name": "Student Well-being & Facilities",
    "image": "assets/images/counselling-centre-clean.jpeg",
    "icon": "fa-solid fa-comments",
    "url": "/counselling-centre/",
    "has_dedicated_page": true,
    "summary": "The Counselling Centre at MGM Model School is a dedicated platform that coordinates student advocacy and promotes mental well-being. We believe that academic success is rooted in emotional well-being. The Centre focuses on providing both individual and group counselling in a safe, confidential, and supportive environment.",
    "details": "Our services include identifying and addressing issues such as lack of interest in studies, stress, anxiety, depression and interpersonal relationship challenges. Offering remedial and preventive support to enhance academic, personal and career development. Organizing various well-being activities, awareness programs and orientation classes for students, parents and teachers. Providing referral services to concerned experts for further support when required. We also leverage the CBSE tele-counselling initiative 'MANODARPAN' (Ph: 8448440632) to ensure extended care and support for our students. Because at MGM, every mind matters.",
    "bullets": [
      "Individual and group counselling in a safe, confidential and supportive atmosphere",
      "Addresses academic stress, anxiety, depression and interpersonal challenges",
      "Conducts wellness programs, awareness seminars and orientations for students and parents",
      "Integrated with CBSE MANODARPAN Tele-Counselling Helpline (Ph: 8448440632)"
    ],
    "tags": [
      "Student Advocacy & Mental Well-being",
      "Nurturing Minds, Empowering Lives (Every Mind Matters)"
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
    "url": "/innovation-centre/",
    "has_dedicated_page": true,
    "video": "assets/videos/innovation-centre.mp4",
    "summary": "Mahatma Gandhi Memorial Model School has introduced a state-of-the-art Innovation Centre equipped with world-class amenities. The centre was inaugurated by the Hon'ble Governor of Kerala, Shri Arif Mohammed Khan.",
    "details": "Packed with cutting-edge technology and brilliant minds, the lab also offers 3D Printing, VR Experience and much more.",
    "bullets": [
      "Officially inaugurated by the Hon'ble Governor of Kerala, Shri Arif Mohammed Khan",
      "Equipped with world-class amenities and cutting-edge educational tech",
      "Features advanced 3D Printing stations and immersive Virtual Reality (VR) experiences",
      "Nurtures brilliant student minds in robotics, engineering and creative problem-solving"
    ],
    "tags": [
      "State-of-the-Art STEM Lab",
      "Shri Arif Mohammed Khan (Hon'ble Governor of Kerala)"
    ]
  },
  {
    "id": "gdc",
    "order": 10,
    "title": "GDC (General Development Cell)",
    "category_key": "facilities",
    "category_name": "Student Well-being & Facilities",
    "image": "assets/images/gdc-clean.jpeg",
    "icon": "fa-solid fa-compass",
    "url": "/gdc/",
    "has_dedicated_page": true,
    "summary": "The General Development Cell (GDC) is an innovative initiative at MGM Model School to arouse curiosity and broaden knowledge horizons beyond textbooks.",
    "details": "GDC aims to prepare students to face the challenges of the 21st century by encouraging them to delve into global affairs, science, culture and more. Through its activities, it inculcates communicative and collaborative skills, fostering a spirit of adaptability and lifelong learning. Conducted for Classes I to VIII, GDC is led by a student President and Secretary, providing early opportunities to develop leadership, organizational and responsibility-taking skills. Students are given a vibrant platform to share their knowledge and perspectives through: Role Play | Paper Presentations | Speeches | Quizzes | Video Presentations | Newspaper Discussions | Poster Making | Slogan Writing & More.",
    "bullets": [
      "Conducted for Classes I to VIII, led by student President and Secretary",
      "Encourages exploration into global affairs, science, culture and current events",
      "Inculcates communicative, collaborative, adaptability and lifelong learning skills",
      "Activities include Role Play, Paper Presentations, Speeches, Quizzes & Newspaper Discussions"
    ],
    "tags": [
      "Curiosity & Global Knowledge Platform",
      "Conducted for Classes I to VIII"
    ]
  },
  {
    "id": "life-skills",
    "order": 11,
    "title": "Life Skills",
    "category_key": "skills",
    "category_name": "Skills & Cadet Corps",
    "image": "assets/images/life-skills-2026.jpeg",
    "icon": "fa-solid fa-lightbulb",
    "url": "/life-skills/",
    "has_dedicated_page": true,
    "summary": "Life Skills Education at MGM focuses on cultivating crucial abilities for personal growth, meaningful relationships and future achievements.",
    "details": "These sessions cover: Communication and Interpersonal Skills | Problem-solving and Decision-making | Emotional Intelligence and Self-awareness | Stress Management and Resilience | Goal-setting and Time Management. These skills empower our students to navigate challenges with confidence, build strong character and evolve into well-rounded individuals.",
    "bullets": [
      "Communication and Interpersonal Skills mastery",
      "Problem-solving and Decision-making capabilities",
      "Emotional Intelligence and Self-awareness development",
      "Stress Management, Resilience, Goal-setting and Time Management"
    ],
    "tags": [
      "Personal Growth & Resilience",
      "Personal Growth, Character Building & Relationships"
    ]
  },
  {
    "id": "voice-of-mgm",
    "order": 12,
    "title": "Voice of MGM - Campus Radio Club",
    "category_key": "skills",
    "category_name": "Skills & Cadet Corps",
    "image": "assets/images/voice-of-mgm-clean.jpeg",
    "icon": "fa-solid fa-microphone",
    "url": "/voice-of-mgm/",
    "has_dedicated_page": true,
    "summary": "The Voice of MGM is more than a radio club \u2013 it's where confidence finds its voice. We provide a vibrant platform for our students to overcome stage fear, master the art of public speaking and unleash their creativity. At MGM, we believe every student has a story to tell, and we give them the mic to tell it.",
    "details": "The club builds confidence through a closed-studio environment that is far less intimidating than a stage or camera, while developing essential skills in public speaking, communication, teamwork and commitment. Our user-friendly setup encourages participation from students of all ages and abilities. Proudly inaugurated by Ms. Rashmi Roja Thushara Nair IAS, Bureau Director, Press Information Bureau.",
    "bullets": [
      "Closed-studio acoustic setup providing a non-intimidating broadcasting space",
      "Helps students overcome stage fear and develop public speaking poise",
      "Fosters creativity, journalistic expression, storytelling and teamwork",
      "Proudly inaugurated by Ms. Rashmi Roja Thushara Nair IAS (Bureau Director, PIB)"
    ],
    "tags": [
      "Public Speaking & Broadcasting Platform",
      "Give Your Voice a Stage"
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
    "url": "/school-canteen/",
    "has_dedicated_page": true,
    "summary": "At MGM Model School, we believe healthy food fuels better learning. Our spacious and hygienic School Canteen serves delicious and nutritious meals at a nominal payment, for both staff and students.",
    "details": "We offer a wide variety of both Vegetarian and Non-Vegetarian options, prepared fresh daily under the highest standards of hygiene and quality. Vegetarian food is served on Tuesdays and Thursdays.",
    "bullets": [
      "Serves delicious and nutritious meals at a nominal payment for staff and students",
      "Spacious and hygienic cafeteria maintaining highest food quality standards",
      "Wide variety of freshly prepared Vegetarian and Non-Vegetarian options",
      "Dedicated Vegetarian food served on Tuesdays and Thursdays"
    ],
    "tags": [
      "Spacious & Hygienic Dining",
      "Spacious & Spotlessly Hygienic Canteen"
    ]
  },
  {
    "id": "butterfly-garden",
    "order": 14,
    "title": "Butterfly Garden & Kids Zone",
    "category_key": "green",
    "category_name": "Campus & Green Initiatives",
    "image": "assets/images/butterfly-garden-1.jpeg",
    "icon": "fa-solid fa-shapes",
    "url": "/butterfly-garden/",
    "has_dedicated_page": true,
    "summary": "Nestled in our vibrant Kids Zone, the Butterfly Garden is a little paradise crafted especially for our tiny tots. A colourful world filled with cheerful play equipment, blooming plants and fluttering butterflies, it is a treat to the eyes and a joy to the heart.",
    "details": "Here, children don't just play \u2013 they engage with nature, come close to it and learn to love it. Amidst laughter, swings and slides, our children experience pure enjoyment, freedom and the magic of early childhood, all in a safe, secure and stimulating environment.",
    "bullets": [
      "Enchanting sanctuary with cheerful play equipment and blooming nectar flora",
      "Fluttering native butterflies providing joyful visual and sensory discovery",
      "Encourages children to love and engage with nature through play",
      "Safe, secure and stimulating environment with swings and slides"
    ],
    "tags": [
      "Nature Discovery & Early Play",
      "Kindergarten & Early Childhood Scholars"
    ]
  },
  {
    "id": "3d-max-zone",
    "order": 15,
    "title": "3D Maths Zone",
    "category_key": "academic",
    "category_name": "Academic & Innovation",
    "image": "assets/images/maths-zone-3d.jpeg",
    "icon": "fa-solid fa-cube",
    "url": "/3d-max-zone/",
    "has_dedicated_page": true,
    "video": "assets/videos/3d-max-zone.mp4",
    "summary": "Our outdoor 3D Maths Zone turns abstract concepts into a hands-on experience. At MGM Model School, we believe learning is best when it can be seen, touched and experienced. Set within the school campus, this interactive zone features large, vividly coloured 3D models of solid shapes including Triangular Pyramid, Square Pyramid, Pentagonal Pyramid, Hexagonal Pyramid, Cubes, Rectangular Prisms, Frustum of a Cone, Cones and more.",
    "details": "Each model is mounted on a pedestal that clearly displays its properties \u2013 Faces, Vertices, Edges, and the Euler's formula (F+V-E), along with Lateral Surface Area, Total Surface Area and Volume \u2013 making learning spontaneous and engaging. Instead of just memorizing formulas from a textbook, students walk through geometry, observe, count and correlate. It fosters spatial intelligence, logical reasoning and a genuine love for Mathematics from the foundational years.",
    "bullets": [
      "Large, vividly coloured outdoor 3D solid shape models across campus",
      "Includes Triangular/Square/Pentagonal/Hexagonal Pyramids, Cubes, Prisms & Cones",
      "Pedestals display Faces, Vertices, Edges, Euler's formula (F+V-E), Surface Area & Volume",
      "Builds spatial intelligence and logical reasoning by seeing, touching and experiencing"
    ],
    "tags": [
      "Outdoor Interactive Geometry",
      "Outdoor Hands-On 3D Mathematics Laboratory"
    ]
  },
  {
    "id": "ominis",
    "order": 16,
    "title": "OMNIS \u2013 The MGM Robot",
    "category_key": "academic",
    "category_name": "Academic & Innovation",
    "image": "assets/images/omnis-robot.jpeg",
    "icon": "fa-solid fa-robot",
    "url": "/ominis/",
    "has_dedicated_page": true,
    "summary": "OMNIS is our interactive AI-powered learning companion. Designed to engage with students, answer their queries, explain complex concepts and make classroom learning more interactive, OMNIS brings together Robotics, Artificial Intelligence and Education.",
    "details": "More than just a robot, OMNIS gives our learners a first-hand experience of future technology, sparking curiosity, encouraging exploration and nurturing innovative thinking.",
    "bullets": [
      "Interactive AI-powered companion uniting Robotics, Artificial Intelligence & Education",
      "Engages with students, answers queries and explains complex concepts interactively",
      "Provides first-hand experiential interaction with cutting-edge future technology",
      "Sparks curiosity, encourages technological exploration and innovative thinking"
    ],
    "tags": [
      "Robotics & Artificial Intelligence",
      "OMNIS - Interactive AI-Powered School Robot"
    ]
  },
  {
    "id": "nova-ai-hub",
    "order": 17,
    "title": "NOVA \u2013 The AI HUB",
    "category_key": "academic",
    "category_name": "Academic & Innovation",
    "image": "assets/images/1756461341.jpg",
    "icon": "fa-solid fa-microchip",
    "url": "/nova-ai-hub/",
    "has_dedicated_page": true,
    "video": "assets/videos/nova-ai-hub.mp4",
    "summary": "NOVA is our KG Innovation Lab, where our youngest learners explore technology through fun and hands-on activities. The lab features Cubelets for building small robots, block-based coding to introduce programming in a simple and engaging way, and MIKO \u2013 a student-friendly robot that interacts with children and supports their learning.",
    "details": "NOVA encourages students to explore, create and experiment, while developing creativity, logical thinking and problem-solving skills from an early age.",
    "bullets": [
      "Cubelets modular magnetic robotics for building small autonomous robots",
      "Block-based coding introducing programming logic in an engaging, simple format",
      "MIKO student-friendly interactive learning companion robot",
      "Develops creativity, logical algorithmic thinking and problem-solving early"
    ],
    "tags": [
      "Junior AI & Robotics Lab",
      "NOVA - Kindergarten Innovation Lab"
    ]
  },
  {
    "id": "ncc",
    "order": 18,
    "title": "NCC (National Cadet Corps)",
    "category_key": "skills",
    "category_name": "Skills & Cadet Corps",
    "image": "assets/images/ncc-unit-1.jpeg",
    "icon": "fa-solid fa-person-military-pointing",
    "url": "/ncc/",
    "has_dedicated_page": true,
    "summary": "MGM Model School launched its NCC unit - '1 Kerala Battalion, Kerala Lakshadweep Group' on 7th July 2022 with cadets from the Junior Wing (Class VIII).",
    "details": "Functioning as a self-financing scheme with 4 years of service, the unit provides comprehensive training every Friday from 3:00 PM to 5:30 PM including basic military parades, small arms training, drills and community service. Cadets also participate in camps and expeditions that develop leadership, resilience and a deep sense of patriotism. On successful completion of 2 years, cadets are awarded the NCC Certificate - a recognition of their dedication and discipline, which adds significant value to their future academic and career pursuits. The Associate NCC Officer is Retd. Subedar Major Mr. Rajesh S.",
    "bullets": [
      "Launched on 7th July 2022 under 1 Kerala Battalion, Kerala Lakshadweep Group",
      "Weekly training every Friday from 3:00 PM to 5:30 PM",
      "Curriculum includes basic military parades, drills, small arms training & community service",
      "Awarded official NCC Certificate after 2 years of dedicated service",
      "Led by Associate NCC Officer Retd. Subedar Major Mr. Rajesh S"
    ],
    "tags": [
      "Discipline, Leadership & Patriotism",
      "1 Kerala Battalion, Kerala Lakshadweep Group"
    ]
  },
  {
    "id": "hindustan-scouts-guides",
    "order": 19,
    "title": "Hindustan Scouts & Guides",
    "category_key": "skills",
    "category_name": "Skills & Cadet Corps",
    "image": "assets/images/scouts-and-guides.jpeg",
    "icon": "fa-solid fa-award",
    "url": "/hindustan-scouts-guides/",
    "has_dedicated_page": true,
    "summary": "MGM Model School, Ayiroor, Varkala is proud to be associated with Hindustan Scouts & Guides, Kerala since 2019. Led by our trained Scout Master Mr. Pravin S R, our troop of 104 active cadets is learning the true spirit of discipline, leadership and service to the nation.",
    "details": "45 cadets have been awarded the prestigious Rajyapuraskar - The Governor's Award in the last seven years.",
    "bullets": [
      "Proud association with Hindustan Scouts & Guides, Kerala since 2019",
      "104 active cadets mastering discipline, leadership and service to the nation",
      "45 cadets honoured with the prestigious Rajyapuraskar (The Governor's Award)",
      "Led by certified Scout Master Mr. Pravin S R"
    ],
    "tags": [
      "State-Decorated Rajyapuraskar Troop",
      "104 Enrolled Scouts & Guides Cadets"
    ]
  },
  {
    "id": "school-band-troop",
    "order": 20,
    "title": "School Band Troop",
    "category_key": "skills",
    "category_name": "Skills & Cadet Corps",
    "image": "assets/images/school-band-troop.jpeg",
    "icon": "fa-solid fa-drum",
    "url": "/school-band-troop/",
    "has_dedicated_page": true,
    "summary": "One band, one rhythm marching with courage and confidence. Our band troop of 25 boys & girls perform with precision, harmony, discipline & unwavering dedication.",
    "details": "One band, one rhythm marching with courage and confidence. Our band troop of 25 boys & girls perform with precision, harmony, discipline & unwavering dedication.",
    "bullets": [
      "Troop of 25 dedicated boys & girls marching in synchronized harmony",
      "Crisp precision, musical discipline and martial cadence",
      "Performs at all major ceremonial assemblies, sports meets & campus parades",
      "Instills collective rhythm, performance poise and team pride"
    ],
    "tags": [
      "Ceremonial Marching Ensemble",
      "25 Boys & Girls Ensemble"
    ]
  },
  {
    "id": "happiness-room",
    "order": 21,
    "title": "Happiness Room",
    "category_key": "facilities",
    "category_name": "Student Well-being & Facilities",
    "image": "assets/images/happiness-room-clean.jpeg",
    "icon": "fa-solid fa-face-smile",
    "url": "/happiness-room/",
    "has_dedicated_page": true,
    "summary": "Pause. Create. Express. Shine.",
    "details": "At MGM Model School, the Happiness Room is a vibrant space designed to make free time more meaningful and joyful. It is a welcoming haven where students can read, create, express themselves, discover their talents and unwind. With dedicated zones for reading, creativity and relaxation, it encourages every student to pause, explore their interests, and nurture their well-being. A space to be yourself. A space to discover yourself.",
    "bullets": [
      "Dedicated zones for reading, creative arts and sensory relaxation",
      "Designed to make free intervals meaningful, joyful and rejuvenating",
      "Encourages students to discover talents, express themselves and unwind",
      "A welcoming sanctuary: 'A space to be yourself. A space to discover yourself.'"
    ],
    "tags": [
      "Pause. Create. Express. Shine.",
      "Pause. Create. Express. Shine."
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
  <div class="highlights-header-banner text-center text-white" style="background: linear-gradient(135deg, #141B2B 0%, #2A1724 50%, #800000 100%); padding: 65px 0 50px;">
    <div class="container custom-container-larg position-relative" style="z-index: 2;">
      <span class="highlights-badge-pill mb-3 d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-danger text-white fw-bold small">
        <i class="fa-solid fa-star"></i> Distinctive Excellence &bull; MGM Model School
      </span>
      <h1 class="highlights-title fw-bold text-white mb-3" style="font-size: clamp(32px, 4.5vw, 48px);">Campus Highlights &amp; Distinctive Facilities</h1>
      <p class="highlights-lead text-light mx-auto mb-0" style="max-width: 820px; font-size: 17px; opacity: 0.95; line-height: 1.8;">
        Discover the hallmark initiatives, innovative pedagogies, eco-conservation programs, and student facilities that define holistic 21st-century education at MGM Model School, Ayiroor, Varkala.
      </p>
    </div>
  </div>

  <!-- National Honors Spotlight Cards (From HIGHLIGHTS -1.docx) -->
  <div class="container custom-container-larg mt-n4 mb-5" style="margin-top: -30px; position: relative; z-index: 3;">
    <div class="row g-4 justify-content-center">
      
      <!-- National Water Award 2024 -->
      <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white" style="border-top: 4px solid #2563EB !important;">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-primary px-3 py-1 text-uppercase fw-bold" style="font-size: 11px;">National Recognition</span>
            <span class="text-muted small"><i class="fa-solid fa-calendar-day me-1"></i> 18th November 2025</span>
          </div>
          <h4 class="fw-bold text-dark mb-2" style="font-size: 20px;">
            <i class="fa-solid fa-award text-primary me-2"></i>National Water Award 2024 &ndash; A Moment of National Pride
          </h4>
          <p class="text-secondary small mb-3" style="line-height: 1.8;">
            MGM Model School, Ayiroor, Varkala has been conferred with a <strong>Special Mention &ndash; Best School/College Category at the 6th National Water Awards 2024</strong> by the Ministry of Jal Shakti, Government of India. Selected from 751 schools across India, the honour was presented at Vigyan Bhawan, New Delhi in the august presence of <strong>Hon'ble President of India Smt. Droupadi Murmu</strong>. Principal Dr. Pooja S received the award from Hon'ble Union Minister Shri C. R. Paatil.
          </p>
          <div class="p-2 rounded-3 bg-light border text-muted small">
            <i class="fa-solid fa-droplet text-primary me-1"></i> Features 36 rainwater conservation pits and rooftop harvesting replenishing campus groundwater.
          </div>
        </div>
      </div>

      <!-- National Principal Award 2025 -->
      <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white" style="border-top: 4px solid var(--tp-theme-primary, #ab0c2f) !important;">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-danger px-3 py-1 text-uppercase fw-bold" style="font-size: 11px;">Leadership Honour</span>
            <span class="text-muted small"><i class="fa-solid fa-calendar-day me-1"></i> 22nd August 2025</span>
          </div>
          <h4 class="fw-bold text-dark mb-2" style="font-size: 20px;">
            <i class="fa-solid fa-medal text-danger me-2"></i>Dr. Sarvepalli Radhakrishnan National Principal Award 2025
          </h4>
          <p class="text-secondary small mb-3" style="line-height: 1.8;">
            Our beloved <strong>Principal Dr. Pooja S</strong> was honoured with the prestigious Dr. Sarvepalli Radhakrishnan National Principal Award 2025. The award was presented by Dr. Subramanyam Sharma, grandson of Bharat Ratna Dr. S. Radhakrishnan, former President of India, at the Grand Conclave held in Hyderabad, in recognition of her visionary leadership and unwavering commitment to delivering quality education.
          </p>
          <div class="p-2 rounded-3 bg-light border text-muted small">
            <i class="fa-solid fa-star text-danger me-1"></i> Elevating MGM Model School, Ayiroor to nationwide heights of academic and holistic excellence.
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Interactive Search & Filter Controls -->
  <div class="container custom-container-larg mb-4">
    <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 bg-white">
      <div class="row align-items-center g-3">
        
        <!-- Live Search Box -->
        <div class="col-lg-5 col-md-12">
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0 rounded-start-pill text-muted px-3">
              <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" id="highlightSearchInput" class="form-control bg-light border-start-0 rounded-end-pill py-2" placeholder="Search swimming pool, 20-20 method, robotics, polyhouse..." autocomplete="off">
          </div>
        </div>

        <!-- Category Filter Buttons -->
        <div class="col-lg-7 col-md-12">
          <div class="d-flex flex-wrap gap-2 justify-content-lg-end" id="highlightFilterGroup">
            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill active highlights-filter-btn" data-category="all">
              All Highlights <span class="badge bg-danger text-white ms-1">21</span>
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill highlights-filter-btn" data-category="academic">
              Academic &amp; Innovation <span class="badge bg-secondary text-white ms-1">6</span>
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill highlights-filter-btn" data-category="green">
              Campus &amp; Green <span class="badge bg-secondary text-white ms-1">4</span>
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill highlights-filter-btn" data-category="facilities">
              Student Facilities <span class="badge bg-secondary text-white ms-1">6</span>
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill highlights-filter-btn" data-category="skills">
              Skills &amp; Cadets <span class="badge bg-secondary text-white ms-1">5</span>
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
          <i class="fa-solid fa-circle-info text-danger me-1"></i> Click any card to explore its dedicated separate page
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
        $targetUrl = rtrim(BASE_URL, '/') . '/' . e($h['id']) . '/';
      ?>
        <div class="col-lg-4 col-md-6 highlight-card-col" 
             id="<?= e($h['id']) ?>-col"
             data-category="<?= e($h['category_key']) ?>" 
             data-keywords="<?= e($keywords) ?>">
          
          <div class="card highlight-card border-0 shadow-sm rounded-4 h-100 bg-white" 
               id="<?= e($h['id']) ?>"
               data-href="<?= $targetUrl ?>"
               role="button"
               tabindex="0"
               aria-label="Explore <?= e($h['title']) ?>">
            
            <!-- Thumbnail & Category Tag (Exact Natural Ratio, Clean Edge-to-Edge Without Artificial Frames) -->
            <div class="highlight-thumb-wrap position-relative">
              <a href="<?= $targetUrl ?>" class="d-block w-100 text-decoration-none">
                <img src="<?= asset_url(ltrim($h['image'], 'assets/')) ?>" 
                     alt="<?= e($h['title']) ?>" 
                     class="highlight-thumb-img"
                     loading="lazy">
              </a>
              
              <span class="highlight-category-tag">
                <?= e($h['category_name']) ?>
              </span>
              
              <span class="highlight-order-num">
                #<?= sprintf('%02d', $h['order']) ?>
              </span>

              <?php if (!empty($h['video'])): ?>
                <span class="highlight-video-badge position-absolute" style="bottom: 12px; right: 12px; background: rgba(171, 12, 47, 0.9); color: #fff; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 9999px; backdrop-filter: blur(4px); box-shadow: 0 2px 8px rgba(0,0,0,0.2); pointer-events: none; z-index: 2;">
                  <i class="fa-solid fa-play me-1" style="font-size: 9px;"></i> Video Tour
                </span>
              <?php endif; ?>
            </div>

            <!-- Card Body -->
            <div class="card-body p-4 d-flex flex-column">
              <h3 class="fw-bold text-dark mb-2" style="font-size: 20px;">
                <i class="<?= e($h['icon']) ?> text-danger me-2"></i>
                <a href="<?= $targetUrl ?>" class="text-dark text-decoration-none highlight-title-link">
                  <span><?= e($h['title']) ?></span>
                </a>
              </h3>

              <p class="text-secondary small mb-3 flex-grow-1 leading-relaxed" style="line-height: 1.7;">
                <?= e($h['summary']) ?>
              </p>

              <!-- Tags / Features -->
              <div class="d-flex flex-wrap gap-1 mb-3">
                <?php foreach ($h['tags'] as $tag): ?>
                  <span class="badge bg-light text-muted border small px-2 py-1">
                    <i class="fa-solid fa-check text-success me-1"></i> <?= e($tag) ?>
                  </span>
                <?php endforeach; ?>
              </div>

              <!-- Direct Navigation Full-Width Button -->
              <div class="pt-3 border-top mt-auto">
                <a href="<?= $targetUrl ?>" 
                   class="btn btn-danger btn-sm rounded-pill px-4 py-2 fw-bold w-100 text-center shadow-sm highlight-btn-link" 
                   title="Explore <?= e($h['title']) ?>"
                   style="background: var(--tp-theme-primary, #ab0c2f); border-color: var(--tp-theme-primary, #ab0c2f);">
                  Explore <?= e($h['title']) ?> <i class="fa-solid fa-arrow-right ms-2"></i>
                </a>
              </div>

            </div>

          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('highlightSearchInput');
  const filterBtns = document.querySelectorAll('.highlights-filter-btn');
  const cardCols = document.querySelectorAll('.highlight-card-col');
  const counter = document.getElementById('highlightResultsCounter');
  const noFound = document.getElementById('noHighlightsFound');
  const resetBtn = document.getElementById('resetHighlightFiltersBtn');

  let activeCategory = 'all';

  function filterHighlights() {
    const query = searchInput.value.toLowerCase().trim();
    let visibleCount = 0;

    cardCols.forEach(function(col) {
      const cat = col.getAttribute('data-category');
      const keywords = col.getAttribute('data-keywords') || '';

      const matchCat = (activeCategory === 'all' || cat === activeCategory);
      const matchQuery = (query === '' || keywords.includes(query));

      if (matchCat && matchQuery) {
        col.classList.remove('d-none');
        visibleCount++;
      } else {
        col.classList.add('d-none');
      }
    });

    if (counter) {
      counter.innerHTML = 'Showing <strong class="text-dark">' + visibleCount + '</strong> of <strong>21</strong> campus highlights';
    }

    if (noFound) {
      if (visibleCount === 0) {
        noFound.classList.remove('d-none');
      } else {
        noFound.classList.add('d-none');
      }
    }
  }

  if (searchInput) {
    searchInput.addEventListener('input', filterHighlights);
  }

  filterBtns.forEach(function(btn) {
    btn.addEventListener('click', function() {
      filterBtns.forEach(b => {
        b.classList.remove('active', 'btn-outline-danger');
        b.classList.add('btn-outline-secondary');
      });
      this.classList.add('active', 'btn-outline-danger');
      this.classList.remove('btn-outline-secondary');
      activeCategory = this.getAttribute('data-category');
      filterHighlights();
    });
  });

  if (resetBtn) {
    resetBtn.addEventListener('click', function() {
      searchInput.value = '';
      activeCategory = 'all';
      filterBtns.forEach(b => {
        if (b.getAttribute('data-category') === 'all') {
          b.classList.add('active', 'btn-outline-danger');
          b.classList.remove('btn-outline-secondary');
        } else {
          b.classList.remove('active', 'btn-outline-danger');
          b.classList.add('btn-outline-secondary');
        }
      });
      filterHighlights();
    });
  }

  // Make entire highlight card clickable for instant direct navigation to dedicated page
  document.querySelectorAll('.highlight-card').forEach(function(card) {
    card.addEventListener('click', function(e) {
      // If user clicked an anchor or button inside, let natural event propagate
      if (e.target.closest('a') || e.target.closest('button')) {
        return;
      }
      const href = this.getAttribute('data-href');
      if (href) {
        window.location.href = href;
      }
    });

    card.addEventListener('keydown', function(e) {
      if (e.key === 'Enter') {
        const href = this.getAttribute('data-href');
        if (href) {
          window.location.href = href;
        }
      }
    });
  });

});
</script>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
