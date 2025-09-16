@echo off
echo Starting Laravel Scheduler...
echo This window will remain open to keep the scheduler running.
echo Press Ctrl+C to stop the scheduler.
echo.

cd /d "c:\Users\Office PC\Desktop\Project\new\carProject"
php scheduler-runner.php

pause