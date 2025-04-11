@echo off
setlocal

:: Ganti jika username MySQL-mu bukan 'root'
set MYSQL_USER=root
set MYSQL_HOST=localhost
set MYSQL_PORT=3306

:: Buat database jika belum ada
echo Membuat database 'minimarket' jika belum ada...
mysql -u%MYSQL_USER% -h%MYSQL_HOST% -P%MYSQL_PORT% -e "CREATE DATABASE IF NOT EXISTS minimarket CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"

:: Import file db.sql ke database minimarket
echo Mengimpor file 'db.sql' ke database 'minimarket'...
mysql -u%MYSQL_USER% -h%MYSQL_HOST% -P%MYSQL_PORT% minimarket < db.sql

if %errorlevel% equ 0 (
    echo ✅ Import berhasil!
) else (
    echo ❌ Terjadi kesalahan saat mengimpor!
)

pause
