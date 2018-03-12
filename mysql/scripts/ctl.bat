@echo off
rem START or STOP Services
rem ----------------------------------
rem Check if argument is STOP or START

if not ""%1"" == ""START"" goto stop


"D:\xaamp\mysql\bin\mysqld" --defaults-file="D:\xaamp\mysql\bin\my.ini" --standalone --console
if errorlevel 1 goto error
goto finish

:stop
"D:\xaamp\apache\bin\pv" -f -k mysqld.exe -q

if not exist "D:\xaamp\mysql\data\%computername%.pid" goto finish
echo Delete %computername%.pid ...
del "D:\xaamp\mysql\data\%computername%.pid"
goto finish


:error
echo MySQL could not be started

:finish
exit
