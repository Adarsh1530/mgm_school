const mysql = require('mysql2/promise');

async function run() {
  const conn = await mysql.createConnection({
    host: '127.0.0.1',
    user: 'root',
    password: '',
    database: 'mgm_school'
  });

  const [rows] = await conn.execute('SELECT slug, content_html FROM pages');
  rows.forEach(r => {
    const matches = r.content_html ? r.content_html.match(/assets\/(images|docs)\/[^\s\"\'\)]+/g) : null;
    if (matches) {
      console.log(`${r.slug.padEnd(25)} has ${matches.length} relative asset matches: ${matches.slice(0, 2).join(', ')}`);
    } else {
      console.log(`${r.slug.padEnd(25)} no matches`);
    }
  });

  await conn.end();
}

run().catch(console.error);
