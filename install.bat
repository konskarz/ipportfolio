@echo off
setlocal

set "_path=%temp%\ipportfolio"
set "_root=%_path%\htdocs"
set "_base=%~dp0"

set "_trg=%_path%\mysql-5.0.91-win32\bin\mysqld-nt.exe"
if exist "%_trg%" goto :_mysqlinst

set "_src=%_path%\mysql50.zip"
if exist "%_src%" goto :_mysqldl

call :_download "%_src%" "http://downloads.mysql.com/archives/get/file/mysql-noinstall-5.0.91-win32.zip" "%0"
if not exist "%_src%" call :_error "%_src% not found"
:_mysqldl

call :_unzip "%_src%" "%_path%" "%0"
if not exist "%_trg%" call :_error "%_trg% not found"
:_mysqlinst

set "_trg=%_path%\Apache24\bin\httpd.exe"
if exist "%_trg%" goto :_apacheinst

set "_src=%_path%\apache24.zip"
if exist "%_src%" goto :_apachedl

call :_download "%_src%" "http://www.apachehaus.com/downloads/httpd-2.4.18-x86.zip" "%0"
if not exist "%_src%" call :_error "%_src% not found"
:_apachedl

call :_unzip "%_src%" "%_path%" "%0"
if not exist "%_trg%" call :_error "%_trg% not found"
:_apacheinst

set "_trg=%_path%\php54\php.exe"
if exist "%_trg%" goto :_phpinst

set "_src=%_path%\php54.zip"
if exist "%_src%" goto :_phpdl

call :_download "%_src%" "http://windows.php.net/downloads/releases/archives/php-5.4.45-Win32-VC9-x86.zip" "%0"
if not exist "%_src%" call :_error "%_src% not found"
:_phpdl

call :_unzip "%_src%" "%_path%\php54" "%0"
if not exist "%_trg%" call :_error "%_trg% not found"
:_phpinst

set "_trg=%_root%\joomla.xml"
if exist "%_trg%" goto :_joomlainst

set "_src=%_path%\joomla33.zip"
if exist "%_src%" goto :_joomladl

call :_download "%_src%" "https://github.com/joomla/joomla-cms/releases/download/3.3.6/Joomla_3.3.6-Stable-Full_Package.zip" "%0"
if not exist "%_src%" call :_error "%_src% not found"
:_joomladl

call :_unzip "%_src%" "%_root%" "%0"
if not exist "%_trg%" call :_error "%_trg% not found"
:_joomlainst

set "_src=%_base%plg_content_imagegallery"
set "_trg=%_root%\plugins\content\imagegallery"
if exist "%_src%" if not exist "%_trg%" xcopy /Q/E/I "%_src%" "%_trg%"

set "_src=%_base%plg_content_pagenavigationmod"
set "_trg=%_root%\plugins\content\pagenavigationmod"
if exist "%_src%" if not exist "%_trg%" xcopy /Q/E/I "%_src%" "%_trg%"

set "_src=%_base%plg_editors-xtd_imagegallery"
set "_trg=%_root%\plugins\editors-xtd\imagegallery"
if exist "%_src%" if not exist "%_trg%" xcopy /Q/E/I "%_src%" "%_trg%"

set "_src=%_root%\plugins\editors-xtd\imagegallery\language"
set "_trg=%_root%\administrator\language\en-GB
set "_ini=en-GB.plg_editors-xtd_imagegallery.ini"
if exist "%_trg%" if exist "%_src%\%_ini%" if not exist "%_trg%\%_ini%" xcopy /Q "%_src%\%_ini%" "%_trg%\"
set "_trg=%_root%\administrator\language\ru-RU
set "_ini=ru-RU.plg_editors-xtd_imagegallery.ini"
if exist "%_trg%" if exist "%_src%\%_ini%" if not exist "%_trg%\%_ini%" xcopy /Q "%_src%\%_ini%" "%_trg%\"
if exist "%_src%" rd /s/q "%_src%"

set "_src=%_base%plg_editors_mcecm"
set "_trg=%_root%\plugins\editors\mcecm"
if exist "%_src%" if not exist "%_trg%" xcopy /Q/E/I "%_src%" "%_trg%"

set "_src=%_base%plg_system_artcatmenu"
set "_trg=%_root%\plugins\system\artcatmenu"
if exist "%_src%" if not exist "%_trg%" xcopy /Q/E/I "%_src%" "%_trg%"

set "_src=%_base%tmpl_blank"
set "_trg=%_root%\templates\blank"
if exist "%_src%" if not exist "%_trg%" xcopy /Q/E/I "%_src%" "%_trg%"

set "_src=%_base%tmpl_ipportfolio"
set "_trg=%_root%\templates\ipportfolio"
if exist "%_src%" if not exist "%_trg%" xcopy /Q/E/I "%_src%" "%_trg%"

REM Global Configuration - Site ­ Default Editor: Editor ­ MCECM
set "_src=%_base%configuration.php"
set "_trg=%_root%\installation\model\configuration.php"
if exist "%_src%" if exist "%_trg%" xcopy /Q/Y "%_src%" "%_trg%"

REM Category Manager: Cases
REM Article Manager - Options - Editing Layout ­ Frontend Images and Links: Yes
REM Article Manager - Options - Editing Layout ­ Intro Image Float: None
REM Article Manager - Options - Editing Layout ­ Full Text Image Float: None
REM Article Manager - Options - Category ­ Choose a layout: List
REM User Manager - Options - Allow User Registration: No
REM Extension Manager - Upload Package File: plg_content_imagegallery, plg_content_pagenavigationmod, plg_editors-xtd_imagegallery, plg_editors_mcecm, plg_system_artcatmenu, tmpl_blank, tmpl_ipportfolio
set "_src=%_base%joomla.sql"
set "_trg=%_root%\installation\sql\mysql\joomla.sql"
if exist "%_src%" if exist "%_trg%" xcopy /Q/Y "%_src%" "%_trg%"

REM Article Manager: About, Editing, Styles, Resources, Template
REM Plug-in Manager - System ­ ArtCatMenu ­ Basic Options ­ Category: Cases
REM Menu Manager - Main Menu ­ About - Default Page: Yes
REM Menu Manager - Main Menu ­ Home - Menu Item Type: List All Categories
REM Menu Manager - Main Menu ­ Home - Access: Super Users
REM Module Manager: Older Posts
REM Template Manager -  ipportfolio: Default
set "_src=%_base%sample_blog.sql"
set "_trg=%_root%\installation\sql\mysql\sample_blog.sql"
if exist "%_src%" if exist "%_trg%" xcopy /Q/Y "%_src%" "%_trg%"

pause
goto :eof

:_error
echo %~1
pause
exit 1

:_download
if not exist "%~dp1" md "%~dp1"
set "_vbs=%TEMP%\getbin.vbs"
>> "%_vbs%" (findstr "'--getbin.vbs" "%~3" | findstr /v "findstr")
cscript //nologo "%_vbs%" "%~2" "%~1"
del /q "%_vbs%"
goto :eof

:_unzip
if not exist "%~2" md "%~2"
set "_vbs=%TEMP%\unzip.vbs"
>> "%_vbs%" (findstr "'--unzip.vbs" "%~3" | findstr /v "findstr")
cscript //nologo "%_vbs%" "%~1" "%~2"
del /q "%_vbs%"
goto :eof

With CreateObject("WinHttp.WinHttpRequest.5.1") '--getbin.vbs
	.Open "GET", Wscript.Arguments(0), false '--getbin.vbs
	.setRequestHeader "User-Agent", WScript.ScriptName '--getbin.vbs
	.Send '--getbin.vbs
	WScript.Echo .getAllResponseHeaders '--getbin.vbs
	If .Status = 200 Then '--getbin.vbs
		ResponseBody = .ResponseBody '--getbin.vbs
		With CreateObject("ADODB.Stream") '--getbin.vbs
			.Open '--getbin.vbs
			.Type = 1 '//binary '--getbin.vbs
			.Write ResponseBody '--getbin.vbs
			.Position = 0 '--getbin.vbs
			.SaveToFile Wscript.Arguments(1), 2 '//overwrite '--getbin.vbs
		End With '--getbin.vbs
	End If '--getbin.vbs
End With '--getbin.vbs

With CreateObject("Shell.Application") '--unzip.vbs
	.NameSpace(Wscript.Arguments(1)).CopyHere .NameSpace(Wscript.Arguments(0)).Items '--unzip.vbs
End With '--unzip.vbs
