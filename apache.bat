@echo off
setlocal

set "_path=%temp%\ipportfolio"

set "APACHE_HOME=%_path%\Apache24"
set "_apache=bin\httpd.exe"
if exist "%APACHE_HOME%\%_apache%" goto :_apache
:set_apache
set /p "APACHE_HOME=Please enter the path to the Apache installation: "
if not exist "%APACHE_HOME%\%_apache%" goto :set_apache
:_apache

set "PHP_HOME=%_path%\php54"
set "_php=php.exe"
if exist "%PHP_HOME%\%_php%" goto :_php
:set_php
set /p "PHP_HOME=Please enter the path to the PHP installation: "
if not exist "%PHP_HOME%\%_php%" goto :set_php
:_php

set "_base=%~dp0"
set "_conf=%_base%httpd.conf"
if exist "%_conf%" goto :_conf
:set_conf
set /p "_conf=Please enter the path to the httpd.conf: "
if not exist "%_conf%" goto :set_conf
:_conf

set "_temp=%_path%\tmp"
set "_root=%_path%\htdocs"

if not exist "%_root%" md "%_root%" & > "%_root%\index.php" echo ^<?php phpinfo();
if exist "%_temp%" rd /s/q "%_temp%"
md "%_temp%"

start "Apache" "%APACHE_HOME%\%_apache%" -w -f "%_base%httpd.conf"
start /max http://localhost