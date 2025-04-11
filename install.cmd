@echo off
setlocal

:: === Konfigurasi Login MySQL (XAMPP) ===
set MYSQL_BIN="C:\xampp\mysql\bin\mysql.exe"
set DB_NAME=minimarket
set SQL_FILE=db.sql

:: === Cek mysql.exe tersedia ===
if not exist %MYSQL_BIN% (
    echo ❌ Tidak ditemukan mysql.exe di %MYSQL_BIN%
    echo Pastikan XAMPP sudah terinstal dan path-nya benar.
    pause
    exit /b
)

:: === Membuat database (jika belum ada) ===
echo ⏳ Membuat database '%DB_NAME%' (jika belum ada)...
%MYSQL_BIN% -u root -e "CREATE DATABASE IF NOT EXISTS %DB_NAME% CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
if errorlevel 1 (
    echo ❌ Gagal membuat database!
    pause
    exit /b
)

:: === Mengimpor file SQL ===
echo ⏳ Mengimpor file '%SQL_FILE%' ke database '%DB_NAME%'...
%MYSQL_BIN% -u root %DB_NAME% < %SQL_FILE%
if errorlevel 1 (
    echo ❌ Terjadi kesalahan saat mengimpor!
    pause
    exit /b
)

echo ✅ Impor selesai tanpa password!
pause
