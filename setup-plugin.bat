@echo off
setlocal enabledelayedexpansion

:: Get user input for the plugin name
set /p pluginName=Enter the plugin name: 
set /p pluginURI=Enter the plugin URI: 
set /p pluginDescription=Enter the plugin description: 
set /p pluginAuthor=Enter the plugin author: 
set /p pluginAuthorURI=Enter the plugin author URI: 


:: Convert plugin name to various formats
set kebabCase=!pluginName: =-!
set snakeCase=!pluginName: =_!
set pascalSnakeCase=!pluginName: =_!
set upperSnakeCase=!snakeCase: =_!
set lowerSnakeCase=!snakeCase: =_!

for %%i in (a b c d e f g h i j k l m n o p q r s t u v w x y z) do (
    set lowerSnakeCase=!lowerSnakeCase:%%i=%%i!
    set kebabCase=!kebabCase:%%i=%%i!
)
for %%i in (A B C D E F G H I J K L M N O P Q R S T U V W X Y Z) do (
    set upperSnakeCase=!upperSnakeCase:%%i=%%i!
)

:: Rename files recursively
for /R %%f in (*plugin-name*) do (
    set newName=%%~nf
    set newName=!newName:plugin-name=%kebabCase%!
    ren "%%f" "!newName!%%~xf"
)

:: Replace content in files recursively
for /R %%f in (*.php) do (
    > "%%f.tmp" (
        for /f "usebackq delims=" %%l in ("%%f") do (
            set "line=%%l"
            if "!line!"=="<n>" (
                echo(
            ) else (
                set "line=!line:<kebabCase>=%kebabCase%!"
                set "line=!line:<lowerSnakeCase>=%lowerSnakeCase%!"
                set "line=!line:<pascalSnakeCase>=%pascalSnakeCase%!"
                set "line=!line:<upperSnakeCase>=%upperSnakeCase%!"
                set "line=!line:<pluginName>=%pluginName%!"
                set "line=!line:<pluginURI>=%pluginURI%!"
                set "line=!line:<pluginDescription>=%pluginDescription%!"
                set "line=!line:<pluginAuthor>=%pluginAuthor%!"
                set "line=!line:<pluginAuthorURI>=%pluginAuthorURI%!"
                echo(!line!
            )
        )
    )
    move /y "%%f.tmp" "%%f" >nul
)

echo All done!
pause

endlocal