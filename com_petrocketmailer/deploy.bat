@ECHO OFF
rem Copies files for com_petrocketmailer from your git repo into a Joomla dev instance
rem Whenever you make changes to the code, you can run this script to push the changes to your Joomla instance
rem and begin testing.
rem (1) Before you use this script, you will need to install the component into Joomla the old-fashioned way (zip file).
rem Otherwise, Joomla will not know that the component is available. 
rem (2) You will need to change the joomladir variable to point to your local joomla install

rem Change this variable to point to your joomla installation. Do not include trailing slash.
SET joomladir=C:\Apache24\htdocs\joomla

rem These point to the site part and admin part of the component, respectively
SET sitedir=%joomladir%\components\com_petrocketmailer
SET admindir=%joomladir%\administrator\components\com_petrocketmailer

rem Copy all files from source to joomla
xcopy site %sitedir% /I /Y /E
xcopy admin %admindir% /I /Y /E

rem Language folders need to be copied to a special place
rmdir %sitedir%\language /s /q
rmdir %admindir%\language /s /q
xcopy admin\language %joomladir%\administrator\language /I /Y /E
xcopy site\language %joomladir%\language /I /Y /E