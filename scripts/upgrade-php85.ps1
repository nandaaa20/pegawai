# Upgrade dependencies for the portfolio project using PHP 8.5.
# Run from the repository root: powershell -ExecutionPolicy Bypass -File .\scripts\upgrade-php85.ps1
# This script never deploys, merges, or runs migrate:fresh.
$ErrorActionPreference = 'Stop'
Set-Location (Resolve-Path (Join-Path $PSScriptRoot '..'))
if (-not (Test-Path 'composer.json')) { throw 'composer.json not found' }
$phpVersion = (& php -r 'echo PHP_VERSION_ID;')
if ($LASTEXITCODE -ne 0 -or [int]$phpVersion -lt 80500) { throw 'PHP CLI 8.5 or newer is required. Run php -v.' }
$backup = Join-Path ([IO.Path]::GetTempPath()) ('simpeg-upgrade-' + [guid]::NewGuid().ToString('N'))
New-Item -Type Directory $backup | Out-Null
Copy-Item composer.json (Join-Path $backup 'composer.json')
if (Test-Path composer.lock) { Copy-Item composer.lock (Join-Path $backup 'composer.lock') }
Write-Host "Backup of original Composer files: $backup"
Write-Host 'Upgrading Laravel and compatible development dependencies...'
& composer require 'laravel/framework:^12.69' 'laravel/sanctum:^4.2' 'laravel/tinker:^2.10' 'guzzlehttp/guzzle:^7.15.2' 'barryvdh/laravel-dompdf:^3.1' --no-update
if ($LASTEXITCODE -ne 0) { throw 'Composer constraint change failed; originals are in backup.' }
& composer require --dev 'laravel/breeze:^2.4' 'nunomaduro/collision:^8.6' 'phpunit/phpunit:^11.5' 'spatie/laravel-ignition:^2.13' --no-update
if ($LASTEXITCODE -ne 0) { throw 'Dev dependency constraint change failed; originals are in backup.' }
& composer update --with-all-dependencies --no-interaction
if ($LASTEXITCODE -ne 0) { throw 'Dependency solver failed. See output above; do not commit yet. Backups are preserved.' }
& composer check-platform-reqs
if ($LASTEXITCODE -ne 0) { throw 'Platform requirements failed.' }
& composer audit --locked
if ($LASTEXITCODE -ne 0) { throw 'Security advisories remain; inspect composer audit before committing.' }
& php artisan optimize:clear
if ($LASTEXITCODE -ne 0) { throw 'Artisan bootstrap failed after upgrade.' }
& php artisan test
if ($LASTEXITCODE -ne 0) { throw 'Tests failed. Review Laravel upgrade compatibility before committing.' }
Write-Host 'Dependency update, platform check, security audit and tests passed.'
Write-Host 'Review git diff and git status, then commit composer.json and composer.lock when satisfied.'
