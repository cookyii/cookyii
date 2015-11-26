@echo off

rem -------------------------------------------------------------
rem  Build command line bootstrap script for Windows.
rem -------------------------------------------------------------

@setlocal

set PROJECT_PATH=%~dp0

if "%PHP_COMMAND%" == "" set PHP_COMMAND=php.exe

"%PHP_COMMAND%" "%PROJECT_PATH%build.phar" %*

@endlocal
