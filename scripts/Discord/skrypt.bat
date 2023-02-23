@echo off
cd ..
cd ..
:start
cls
type message.txt
timeout 1 > NUL
goto start
