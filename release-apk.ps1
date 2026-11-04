# Gemelli Garage APK Automated Release Script
param(
    [string]$releaseNotes = "Përmirësime në Firebase Push, WhatsApp Gateway dhe performancë."
)

$ErrorActionPreference = "Stop"

Write-Host "🚀 Nisi procesi i automatizuar për ndërtimin e APK (Gemelli Garage)..." -ForegroundColor Green

# 1. Update Version Code in version.json
$versionFile = "$PSScriptRoot\version.json"
if (Test-Path $versionFile) {
    $versionData = Get-Content $versionFile | ConvertFrom-Json
    $versionData.version_code += 1
    $versionData.latest_version = "1.0.$($versionData.version_code)"
    if ($releaseNotes) { $versionData.release_notes = $releaseNotes }
    $versionData | ConvertTo-Json -Depth 5 | Set-Content $versionFile
    Write-Host "✅ Version Code u rrit në: $($versionData.version_code) ($($versionData.latest_version))" -ForegroundColor Yellow
}

# 2. Configure JDK 17 & Internal Gradle Cache
$env:JAVA_HOME = "C:\Program Files\Eclipse Adoptium\jdk-17.0.14.7-hotspot"
$gradleHomeDir = "$PSScriptRoot\mobile-gateway\android\.gradle_home"
if (-not (Test-Path $gradleHomeDir)) { New-Item -ItemType Directory -Path $gradleHomeDir | Out-Null }
$env:GRADLE_USER_HOME = $gradleHomeDir
$env:PATH = "$env:JAVA_HOME\bin;" + $env:PATH

# 3. Build Release APK via Flutter
Set-Location "$PSScriptRoot\mobile-gateway"

Write-Host "🧹 Pastrimi i cache-it Flutter..." -ForegroundColor Cyan
flutter clean

Write-Host "📦 Shkarkimi i paketave flutter pub get..." -ForegroundColor Cyan
flutter pub get

Write-Host "🔨 Ekzekutimi: flutter build apk --release..." -ForegroundColor Cyan
flutter build apk --release

# 4. Copy Output APK to downloads directory
$sourceApk = "$PSScriptRoot\mobile-gateway\build\app\outputs\flutter-apk\app-release.apk"
$targetDir = "$PSScriptRoot\public\downloads"
if (-not (Test-Path $targetDir)) { New-Item -ItemType Directory -Path $targetDir }
$targetApk = "$targetDir\app-release.apk"

if (Test-Path $sourceApk) {
    Copy-Item -Path $sourceApk -Destination $targetApk -Force
    Write-Host "🎉 APK u publikua me sukses në: $targetApk" -ForegroundColor Green
} else {
    Write-Error "❌ APK nuk u gjend te build output."
}

Set-Location $PSScriptRoot
