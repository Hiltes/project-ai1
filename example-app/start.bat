@echo off
cd /d "%~dp0"

echo === Instalacja zaleznosci PHP ===
call composer install

echo === Instalacja zależnosci JS ===
call npm install

echo === Tworzenie .env (jesli brak) ===
IF NOT EXIST .env (
    copy .env.example .env
)

echo === Generowanie APP_KEY ===
call php artisan key:generate

echo === Migracja i seedy ===
call php artisan migrate:fresh --seed

echo === Uruchamianie backendu i frontend ===
call composer run dev

echo.
echo === Aplikacja uruchomiona. Naciśnij dowolny klawisz, aby zamknąć ===
pause >nul
