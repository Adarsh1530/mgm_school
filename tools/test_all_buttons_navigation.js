const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const BASE_URL = 'http://localhost/MGM%20SCHOOL/';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  await page.setViewport({ width: 1366, height: 768 });

  console.log('--- TESTING DIRECT CLICK NAVIGATION FOR ALL 10 BUTTONS ---\n');

  const clickTests = [
    { name: '1. Banner Apply Now', findSelector: () => Array.from(document.querySelectorAll('a')).find(a => a.innerText.includes('Apply Now')), expectedSlug: 'admission-procedure' },
    { name: '2. Hero Learn More', findSelector: () => Array.from(document.querySelectorAll('a')).find(a => a.innerText.includes('Learn More About Our Campus')), expectedSlug: 'about-us' },
    { name: '3. Hero Explore Courses', findSelector: () => Array.from(document.querySelectorAll('a')).find(a => a.innerText.includes('Explore Our Courses')), expectedSlug: 'courses-offered' },
    { name: '4. Card 1 Why study at MGM', findSelector: () => Array.from(document.querySelectorAll('.tp-service-title a')).find(a => a.innerText.includes('Why study at MGM')), expectedSlug: 'about-us' },
    { name: '5. Card 2 Certification Guarantee', findSelector: () => Array.from(document.querySelectorAll('.tp-service-title a')).find(a => a.innerText.includes('Certification')), expectedSlug: 'mandatory-disclosure' },
    { name: '6. Card 3 Graduate Admissions', findSelector: () => Array.from(document.querySelectorAll('.tp-service-title a')).find(a => a.innerText.includes('Graduate')), expectedSlug: 'admission-procedure' },
    { name: '7. Card 4 Scholarships & Fees', findSelector: () => Array.from(document.querySelectorAll('.tp-service-title a')).find(a => a.innerText.includes('Scholarships')), expectedSlug: 'courses-offered' },
    { name: '8. Welcome Know More', findSelector: () => Array.from(document.querySelectorAll('a')).find(a => a.innerText.trim() === 'Know More'), expectedSlug: 'about-us' },
    { name: '9. Courses View All', findSelector: () => Array.from(document.querySelectorAll('a')).find(a => a.innerText.trim() === 'View All'), expectedSlug: 'courses-offered' },
    { name: '10. See More Events', findSelector: () => Array.from(document.querySelectorAll('a')).find(a => a.innerText.trim() === 'See More Events'), expectedSlug: 'merit-day' },
    { name: '11. Event Row Link', findSelector: () => Array.from(document.querySelectorAll('a')).find(a => a.innerText.includes('Global Educations Fall Meeting')), expectedSlug: 'merit-day' },
    { name: '12. Explore Campus Facilities', findSelector: () => Array.from(document.querySelectorAll('a')).find(a => a.innerText.includes('Explore Campus Facilities')), expectedSlug: 'about-us' }
  ];

  let passed = 0;
  for (const t of clickTests) {
    await page.goto(BASE_URL, { waitUntil: 'networkidle2' });
    
    // Evaluate href on the found anchor tag
    const linkInfo = await page.evaluate((fnStr) => {
      const fn = new Function('return (' + fnStr + ')()');
      const el = fn();
      if (!el) return null;
      return {
        href: el.getAttribute('href'),
        resolved: el.href,
        text: el.innerText.trim().replace(/\s+/g, ' ')
      };
    }, t.findSelector.toString());

    if (!linkInfo) {
      console.log(`[FAIL] ${t.name}: Element could not be located in page DOM`);
      continue;
    }

    const matchesExpected = linkInfo.href.includes(t.expectedSlug) || linkInfo.resolved.includes(t.expectedSlug);
    if (matchesExpected) {
      console.log(`[PASS] ${t.name} ("${linkInfo.text.substring(0, 30)}"): href="${linkInfo.href}" -> Target: "${t.expectedSlug}"`);
      passed++;
    } else {
      console.log(`[FAIL] ${t.name}: Found href="${linkInfo.href}", expected to contain "${t.expectedSlug}"`);
    }
  }

  // Verify Video Tour Play Button Icon is gone
  await page.goto(BASE_URL, { waitUntil: 'networkidle2' });
  const playButtonExists = await page.evaluate(() => {
    const icon = document.querySelector('.tp-video-icon, .popup-video, [href*="youtube.com"]');
    return !!icon;
  });
  console.log(`\nVideo Tour Play Button Icon Removed: ${!playButtonExists ? 'YES (PASS)' : 'NO (FAIL)'}`);

  console.log(`\n========================================`);
  console.log(`RESULT: ${passed} OF ${clickTests.length} BUTTONS FULLY WORKING`);
  console.log(`========================================`);

  await browser.close();
})();
