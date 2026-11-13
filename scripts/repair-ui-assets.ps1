# SIMPEG UI/UX – Windows asset repair. Run from PowerShell or CMD:
# powershell -ExecutionPolicy Bypass -File scripts\repair-ui-assets.ps1
# Does not touch .env, databases, Composer packages, or uncommitted source code.
$ErrorActionPreference = 'Stop'
Set-Location (Resolve-Path (Join-Path $PSScriptRoot '..'))
Write-Host "SIMPEG: checking frontend toolchain..." -ForegroundColor Cyan
& node --version
if ($LASTEXITCODE -ne 0) { throw 'Node.js not found; install Node.js and reopen the terminal.' }
& npm --version
if ($LASTEXITCODE -ne 0) { throw 'npm not found.' }

# Laravel's @vite checks public/hot before the built manifest. If the hot file
# points to a dev server that is not running, the login appears unstyled.
$hot = Join-Path (Get-Location) 'public\hot'
if (Test-Path $hot) {
    Write-Host 'Removing stale public/hot so Laravel serves built assets...' -ForegroundColor Yellow
    Remove-Item $hot -Force
}
Write-Host 'Installing locked frontend dependencies...' -ForegroundColor Cyan
& npm ci
if ($LASTEXITCODE -ne 0) { throw 'npm ci failed.' }
Write-Host 'Compiling Tailwind and Vite CSS/JS...' -ForegroundColor Cyan
& npm run build
if ($LASTEXITCODE -ne 0) { throw 'npm run build failed.' }

$manifest = Join-Path (Get-Location) 'public\build\manifest.json'
if (-not (Test-Path $manifest)) { throw 'Vite manifest missing after build.' }
$files = (Get-Content $manifest -Raw | ConvertFrom-Json -AsHashtable).Values
$cssFound = $false
foreach ($entry in $files) {
    if ($entry.file -match '\.css$' -and (Test-Path (Join-Path (Get-Location) ('public\build\' + $entry.file.Replace('/', '\'))))) {
        $cssFound = $true
    }
}
if (-not $cssFound) { throw 'The built CSS file is missing. Check Vite output.' }
Write-Host 'Clearing Laravel cached views and config...' -ForegroundColor Cyan
& php artisan optimize:clear
if ($LASTEXITCODE -ne 0) { throw 'Laravel cache clear failed.' }
Write-Host 'Done. Restart php artisan serve and hard-refresh the login (Ctrl+F5).' -ForegroundColor Green
