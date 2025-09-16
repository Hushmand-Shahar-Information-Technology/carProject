# PowerShell script to run Laravel scheduler
Write-Host "Starting Laravel Scheduler..."
Write-Host "This window will remain open to keep the scheduler running."
Write-Host "Press Ctrl+C to stop the scheduler."
Write-Host ""

Set-Location "c:\Users\Office PC\Desktop\Project\new\carProject"
php scheduler-runner.phps