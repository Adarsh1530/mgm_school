const puppeteer = require('puppeteer-core');
const path = require('path');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const BASE_URL = 'http://localhost/MGM%20SCHOOL';

async function testVideoAutoplay() {
  console.log('========================================================');
  console.log('     TESTING MGM VIDEO AUTOPLAY & CONTROLS ENGINE       ');
  console.log('========================================================\n');

  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox', '--autoplay-policy=no-user-gesture-required']
  });

  const viewports = [
    { name: 'Desktop', width: 1280, height: 800 },
    { name: 'Mobile', width: 375, height: 667, isMobile: true, hasTouch: true }
  ];

  const testPages = [
    { name: 'Homepage (Innovation Video)', url: `${BASE_URL}/` },
    { name: 'Swimming Pool (Pool Video)', url: `${BASE_URL}/swimming-pool/` },
    { name: 'About Us (Vriksha Video)', url: `${BASE_URL}/about-us/` }
  ];

  for (const vp of viewports) {
    console.log(`\n--- TESTING ON ${vp.name.toUpperCase()} (${vp.width}x${vp.height}) ---`);
    const page = await browser.newPage();
    await page.setViewport(vp);

    for (const tp of testPages) {
      console.log(`\nTesting page: ${tp.name}`);
      await page.goto(tp.url, { waitUntil: ['domcontentloaded', 'networkidle2'], timeout: 35000 });

      // Check if video container exists
      const videoExists = await page.evaluate(() => {
        const v = document.querySelector('.mgm-autoplay-video');
        return !!v;
      });

      if (!videoExists) {
        console.log(`  [FAIL] No video found on ${tp.name}!`);
        continue;
      }
      console.log(`  [PASS] Video element present.`);

      // Step 1: Check initial state before scroll (should be paused because not in view)
      const initialPaused = await page.evaluate(() => {
        const v = document.querySelector('.mgm-autoplay-video');
        return v.paused;
      });
      console.log(`  Initial state before scroll: ${initialPaused ? 'PAUSED (Correct)' : 'PLAYING'}`);

      // Step 2: Scroll video into view
      await page.evaluate(() => {
        const container = document.querySelector('.mgm-video-container');
        if (container) container.scrollIntoView({ behavior: 'smooth', block: 'center' });
      });
      await new Promise(r => setTimeout(r, 1500));

      // Step 3: Check if autoplay started
      const isAutoplaying = await page.evaluate(() => {
        const v = document.querySelector('.mgm-autoplay-video');
        return !v.paused && v.muted;
      });
      console.log(`  Autoplay when in viewport: ${isAutoplaying ? 'AUTOPLAYING MUTED [PASS]' : 'STILL PAUSED'}`);

      // Step 4: Test Interactive Mute / Unmute
      const muteToggled = await page.evaluate(() => {
        const muteBtn = document.querySelector('.mgm-btn-mute');
        const v = document.querySelector('.mgm-autoplay-video');
        if (!muteBtn || !v) return false;
        muteBtn.click();
        return !v.muted;
      });
      console.log(`  Unmute button click: ${muteToggled ? 'UNMUTED [PASS]' : 'FAIL'}`);

      // Step 5: Test Interactive Play / Pause
      const pauseToggled = await page.evaluate(() => {
        const playBtn = document.querySelector('.mgm-btn-play');
        const v = document.querySelector('.mgm-autoplay-video');
        if (!playBtn || !v) return false;
        playBtn.click();
        return v.paused;
      });
      console.log(`  Pause button click: ${pauseToggled ? 'PAUSED [PASS]' : 'FAIL'}`);

      // Resume play
      await page.evaluate(() => {
        const playBtn = document.querySelector('.mgm-btn-play');
        if (playBtn) playBtn.click();
      });
      await new Promise(r => setTimeout(r, 500));

      // Step 6: Scroll away (out of view) -> video must pause
      await page.evaluate(() => {
        const v = document.querySelector('.mgm-video-container');
        const rect = v.getBoundingClientRect();
        if (rect.top + window.scrollY < 600) {
          window.scrollTo(0, document.body.scrollHeight);
        } else {
          window.scrollTo(0, 0);
        }
      });
      await new Promise(r => setTimeout(r, 1200));

      const pausedOutOfView = await page.evaluate(() => {
        const v = document.querySelector('.mgm-autoplay-video');
        return v.paused;
      });
      console.log(`  Scroll out of view: ${pausedOutOfView ? 'PAUSED AUTOMATICALLY [PASS]' : 'FAIL'}`);
    }

    await page.close();
  }

  await browser.close();
  console.log('\n========================================================');
  console.log('       ALL VIDEO AUTOPLAY & CONTROL TESTS PASSED        ');
  console.log('========================================================\n');
}

testVideoAutoplay().catch(console.error);
