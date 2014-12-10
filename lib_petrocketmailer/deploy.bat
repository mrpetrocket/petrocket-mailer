@ECHO OFF
rem Copies files for lib_petrocketmailer from your git repo into a Joomla dev instance
rem Whenever you make changes to the code, you can run this script to push the changes to your Joomla instance
rem and begin testing.
rem (1) Before you use this script, you will need to install the component into Joomla the old-fashioned way (zip file).
rem Otherwise, Joomla will not know that the component is available. 
rem (2) You will need to change the joomladir variable to point to your local joomla install

rem Change this variable to point to your joomla installation. Do not include trailing slash.
SET joomladir=C:\Apache24\htdocs\joomla

rem This points to the directory where the library is installed
SET libdir=%joomladir%\libraries\petrocket

rem Copy all files from source to joomla
copy mailer.php %libdir%
