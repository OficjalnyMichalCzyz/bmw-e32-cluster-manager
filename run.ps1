Clear-Host
Start-Process powershell.exe -ArgumentList '.\Tools\VirtualIbus.ps1' -WindowStyle Normal
Start-Process powershell.exe -ArgumentList '.\Tools\VirtualLCD.ps1' -WindowStyle Normal
Start-Process php.exe -ArgumentList "bin\console app:discordListener" -WindowStyle Normal
Start-Process php.exe -ArgumentList "bin\console app:run --no-debug" -WindowStyle Normal