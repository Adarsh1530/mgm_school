# MGM Model School Project - Assistant Guidelines

## Automatic GitHub Synchronization
Whenever any file or code modification, correction, feature addition, or asset update is made in this project during any conversation or user request:
1. Always stage all changes (`git add -A`).
2. Commit the changes with a concise and descriptive message summarizing what was modified.
3. Automatically push the commit to the GitHub repository: `https://github.com/Adarsh1530/mgm_school.git` on branch `main` at the end of the turn without requiring the user to explicitly ask.
4. Always verify that `.gitignore` prevents pushing sensitive credentials, `.env` files, `node_modules/`, or large temporary test screenshots.
5. If the database schema or data is changed, export clean database dumps to `database.sql` and `database/database.sql` before committing.
