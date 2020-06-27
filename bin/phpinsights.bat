@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../vendor/nunomaduro/phpinsights/bin/phpinsights
php "%BIN_TARGET%" %*
