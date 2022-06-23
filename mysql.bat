@echo off
setlocal

set "_path=%temp%\ipportfolio"

set "MYSQL_HOME=%_path%\mysql-5.0.91-win32"
set "_mysql=bin\mysqld-nt.exe"
if exist "%MYSQL_HOME%\%_mysql%" goto :_mysql
:set_mysql
set /p "MYSQL_HOME=Please enter the path to the MySQL installation: "
if not exist "%MYSQL_HOME%\%_mysql%" goto :set_mysql
:_mysql

set "_data=%_path%\data"
if not exist "%_data%" xcopy /Q/E/I "%MYSQL_HOME%\data\*.*" "%_data%"

start "MySQL" "%MYSQL_HOME%\%_mysql%" --datadir="%_data%" --skip-innodb --console
