# PowerShell deployment script for Windows

# FTP server details
$HOSTINGER_HOST = "46.28.46.86"
$HOSTINGER_PORT = "65002"
$HOSTINGER_USER = "u285585646"
$HOSTINGER_PASSWORD = "Wardak@1161997"

# Change these to your local and remote directories (using current directory)
$LOCAL_DIR = "."
$REMOTE_DIR = "/home/u285585646/domains/topmotar.com/public_html/beta"

# Print debug information
Write-Host "FTP_HOST: $HOSTINGER_HOST"
Write-Host "FTP_PORT: $HOSTINGER_PORT"
Write-Host "FTP_USERNAME: $HOSTINGER_USER"
Write-Host "LOCAL_DIR: $LOCAL_DIR"
Write-Host "REMOTE_DIR: $REMOTE_DIR"

# Check if lftp is installed
try {
    $lftpPath = where.exe lftp 2>$null
    if ($lftpPath) {
        Write-Host "lftp found at: $lftpPath"
    } else {
        Write-Host "lftp not found. Please install lftp for Windows."
        exit 1
    }
} catch {
    Write-Host "Error checking for lftp: $_"
    exit 1
}

# Use lftp to mirror the local directory to the remote directory
try {
    # Save the current location
    $originalLocation = Get-Location
    
    # Change to the project directory
    Set-Location -Path "D:\web\carProject"
    
    # Create a temporary file with the lftp commands in the project directory
    $tempFile = "lftp_commands.txt"
    Set-Content -Path $tempFile -Value "set ssl:verify-certificate no"
    Add-Content -Path $tempFile -Value "open -p $HOSTINGER_PORT -u $HOSTINGER_USER,$HOSTINGER_PASSWORD $HOSTINGER_HOST"
    Add-Content -Path $tempFile -Value "mirror -R --verbose --only-newer --parallel=10 $LOCAL_DIR $REMOTE_DIR"
    Add-Content -Path $tempFile -Value "bye"
    
    Write-Host "Running lftp with commands from $tempFile"
    Write-Host "Current directory: $(Get-Location)"
    # Use the full path to lftp
    & "C:\Users\DELL XPS\scoop\shims\lftp.exe" -f $tempFile
    
    # Clean up the temporary file
    Remove-Item $tempFile -Force
    
    # Restore the original location
    Set-Location -Path $originalLocation
} catch {
    Write-Host "Error running lftp: $_"
    exit 1
}