@echo off
setlocal enabledelayedexpansion

cd /d "%~dp0\.."

set "COMMIT_MSG=%~1"
if "%COMMIT_MSG%"=="" (
    for /f "tokens=1-4 delims=/ " %%a in ('date /t') do (
        set "MYDATE=%%c-%%a-%%b"
    )
    for /f "tokens=1-2 delims=: " %%a in ('time /t') do (
        set "MYTIME=%%a:%%b"
    )
    set "COMMIT_MSG=chore: website updates on !MYDATE! !MYTIME!"
)

echo Syncing MGM Model School project with GitHub...
git add -A
git commit -m "%COMMIT_MSG%"
git push origin main
echo Done.
