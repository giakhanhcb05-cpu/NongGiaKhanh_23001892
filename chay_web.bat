@echo off
chcp 65001 >nul
set PHP=D:\xampp\php\php.exe

echo === Chon bai de chay ===
echo   4 = Buoi4 (khong dang nhap)  -^> http://127.0.0.1:8084/product_list.php
echo   5 = Buoi5 (co dang nhap)     -^> http://127.0.0.1:8085/login.php
set /p B=Nhap 4 hoac 5:

:: Bat MySQL neu chua chay
tasklist /fi "imagename eq mysqld.exe" | find /i "mysqld.exe" >nul
if errorlevel 1 (
    echo Dang bat MySQL...
    start "" /min D:\xampp\mysql\bin\mysqld.exe --defaults-file=D:\xampp\mysql\bin\my.ini --standalone
    timeout /t 8 >nul
)

if "%B%"=="4" (
    start http://127.0.0.1:8084/product_list.php
    "%PHP%" -S 127.0.0.1:8084 -t D:\LapTrinhWeb\Buoi4\app
) else (
    start http://127.0.0.1:8085/login.php
    "%PHP%" -S 127.0.0.1:8085 -t D:\LapTrinhWeb\Buoi5\app
)
