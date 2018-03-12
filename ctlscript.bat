@echo off
rem START or STOP Services
rem ----------------------------------
rem Check if argument is STOP or START

if not ""%1"" == ""START"" goto stop

if exist D:\xaamp\hypersonic\scripts\ctl.bat (start /MIN /B D:\xaamp\server\hsql-sample-database\scripts\ctl.bat START)
if exist D:\xaamp\ingres\scripts\ctl.bat (start /MIN /B D:\xaamp\ingres\scripts\ctl.bat START)
if exist D:\xaamp\mysql\scripts\ctl.bat (start /MIN /B D:\xaamp\mysql\scripts\ctl.bat START)
if exist D:\xaamp\postgresql\scripts\ctl.bat (start /MIN /B D:\xaamp\postgresql\scripts\ctl.bat START)
if exist D:\xaamp\apache\scripts\ctl.bat (start /MIN /B D:\xaamp\apache\scripts\ctl.bat START)
if exist D:\xaamp\openoffice\scripts\ctl.bat (start /MIN /B D:\xaamp\openoffice\scripts\ctl.bat START)
if exist D:\xaamp\apache-tomcat\scripts\ctl.bat (start /MIN /B D:\xaamp\apache-tomcat\scripts\ctl.bat START)
if exist D:\xaamp\resin\scripts\ctl.bat (start /MIN /B D:\xaamp\resin\scripts\ctl.bat START)
if exist D:\xaamp\jboss\scripts\ctl.bat (start /MIN /B D:\xaamp\jboss\scripts\ctl.bat START)
if exist D:\xaamp\jetty\scripts\ctl.bat (start /MIN /B D:\xaamp\jetty\scripts\ctl.bat START)
if exist D:\xaamp\subversion\scripts\ctl.bat (start /MIN /B D:\xaamp\subversion\scripts\ctl.bat START)
rem RUBY_APPLICATION_START
if exist D:\xaamp\lucene\scripts\ctl.bat (start /MIN /B D:\xaamp\lucene\scripts\ctl.bat START)
if exist D:\xaamp\third_application\scripts\ctl.bat (start /MIN /B D:\xaamp\third_application\scripts\ctl.bat START)
goto end

:stop
echo "Stopping services ..."
if exist D:\xaamp\third_application\scripts\ctl.bat (start /MIN /B D:\xaamp\third_application\scripts\ctl.bat STOP)
if exist D:\xaamp\lucene\scripts\ctl.bat (start /MIN /B D:\xaamp\lucene\scripts\ctl.bat STOP)
rem RUBY_APPLICATION_STOP
if exist D:\xaamp\subversion\scripts\ctl.bat (start /MIN /B D:\xaamp\subversion\scripts\ctl.bat STOP)
if exist D:\xaamp\jetty\scripts\ctl.bat (start /MIN /B D:\xaamp\jetty\scripts\ctl.bat STOP)
if exist D:\xaamp\hypersonic\scripts\ctl.bat (start /MIN /B D:\xaamp\server\hsql-sample-database\scripts\ctl.bat STOP)
if exist D:\xaamp\jboss\scripts\ctl.bat (start /MIN /B D:\xaamp\jboss\scripts\ctl.bat STOP)
if exist D:\xaamp\resin\scripts\ctl.bat (start /MIN /B D:\xaamp\resin\scripts\ctl.bat STOP)
if exist D:\xaamp\apache-tomcat\scripts\ctl.bat (start /MIN /B /WAIT D:\xaamp\apache-tomcat\scripts\ctl.bat STOP)
if exist D:\xaamp\openoffice\scripts\ctl.bat (start /MIN /B D:\xaamp\openoffice\scripts\ctl.bat STOP)
if exist D:\xaamp\apache\scripts\ctl.bat (start /MIN /B D:\xaamp\apache\scripts\ctl.bat STOP)
if exist D:\xaamp\ingres\scripts\ctl.bat (start /MIN /B D:\xaamp\ingres\scripts\ctl.bat STOP)
if exist D:\xaamp\mysql\scripts\ctl.bat (start /MIN /B D:\xaamp\mysql\scripts\ctl.bat STOP)
if exist D:\xaamp\postgresql\scripts\ctl.bat (start /MIN /B D:\xaamp\postgresql\scripts\ctl.bat STOP)

:end

