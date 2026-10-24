const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

async function testForms() {
  const browser = await puppeteer.launch({ executablePath: CHROME_PATH, headless: 'new', args: ['--no-sandbox'] });
  const page = await browser.newPage();

  // 1. Test Admission Enquiry Form
  console.log('Testing /admission-procedure/ form...');
  await page.goto('http://localhost/MGM%20SCHOOL/admission-procedure/', { waitUntil: 'networkidle0' });
  const formExists = await page.evaluate(() => !!document.querySelector('form'));
  console.log('  Form element exists on admission page:', formExists);

  // If the rendered ninja table has an enquiry form or if we submit a post request
  const admissionPostRes = await page.evaluate(async () => {
    const formData = new FormData();
    formData.append('action', 'admission_enquiry');
    formData.append('name', 'Antigravity Test Student');
    formData.append('phone', '9876543210');
    formData.append('email', 'student@test.com');
    formData.append('grade_applied', 'Grade 5');
    formData.append('message', 'Testing admission procedure submission');

    const res = await fetch('http://localhost/MGM%20SCHOOL/admission-procedure/', {
      method: 'POST',
      body: formData
    });
    const text = await res.text();
    return { status: res.status, containsSuccess: text.includes('Thank you! Your admission enquiry has been submitted.') };
  });
  console.log('  Admission form POST response:', admissionPostRes);

  // 2. Test Alumni Registration Form
  console.log('\nTesting /alumni/ form...');
  await page.goto('http://localhost/MGM%20SCHOOL/alumni/', { waitUntil: 'networkidle0' });
  const alumniPostRes = await page.evaluate(async () => {
    const formData = new FormData();
    formData.append('action', 'alumni_join');
    formData.append('name', 'Antigravity Test Alumnus');
    formData.append('phone', '9876543211');
    formData.append('email', 'alumnus@test.com');
    formData.append('passing_year', '2020');
    formData.append('profession', 'Software Engineer');

    const res = await fetch('http://localhost/MGM%20SCHOOL/alumni/', {
      method: 'POST',
      body: formData
    });
    const text = await res.text();
    return { status: res.status, containsSuccess: text.includes('Thank you! You have successfully registered with the MGM Model School Alumni Network.') };
  });
  console.log('  Alumni form POST response:', alumniPostRes);

  await browser.close();
}

testForms().catch(console.error);
