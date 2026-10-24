param(
    [string]$Message = ""
)

Set-Location "$PSScriptRoot\.."

if (-not $Message) {
    $now = Get-Date -Format "yyyy-MM-dd HH:mm"
    $Message = "chore: website updates on $now"
}

Write-Host "Syncing MGM Model School project with GitHub..." -ForegroundColor Cyan
git add -A
$status = git status --porcelain
if ($status) {
    git commit -m "$Message"
    git push origin main
    Write-Host "Successfully committed and pushed to GitHub!" -ForegroundColor Green
} else {
    Write-Host "Working tree clean. Nothing to commit." -ForegroundColor Yellow
}
