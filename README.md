# Projekt AI1

[Repozytorium projektu](https://github.com/Hiltes/project-ai1)

[Tablica projektowa](https://github.com/users/Hiltes/projects/3)

---


### Temat projektu

Platforma do zamawiania jedzenia do domu

---

### Zespół G4

| Profil | Rola |
| ------ | ------ |
| [Dariusz Szymanek](https://github.com/Hiltes) | lider zespołu |
| [Filip Ślemp](https://github.com/FilipSl3) | członek zespołu |
| [Jakub Róg](https://github.com/xkubax242) | członek zespołu |
| [Kacper Papiernik](https://github.com/LeNexusLe) | członek zespołu |

---


## Opis projektu

Projektowana aplikacja obejmuje swoim działaniem obsługę zamówień w ramach platformy do zamawiania jedzenia online. System umożliwia zarówno klientom końcowym dokonywanie zakupów, jak i administratorom zarządzanie zamówieniami i analizowanie danych sprzedażowych. Aplikacja obejmuje cyfrowe pośrednictwo pomiędzy użytkownikiem a restauracjami, zapewniając mechanizmy zakupowe, obliczanie kosztów dostawy, przechowywanie historii zamówień oraz obsługę panelu administracyjnego. System przewiduje dwa główne interfejsy: dla klienta końcowego oraz dla administratora platformy.

Dostępne funkcjonalności:

Panel Klienta
* Obsługa koszyka - mechanizm umożliwiający dodawanie, edytowanie i usuwanie produktów z koszyka zakupowego
* Dokonywanie zakupów - klient może przeglądać menu restauracji, dodawać produkty do koszyka
* Wyliczanie kosztów dostawy - w momencie składania zamówienia, system automatycznie oblicza koszt dostawy na podstawie wybranych restauracji
* Historia zakupów - klient może przeglądać historię swoich wcześniejszych oraz aktualnych zamówień
* Przeglądanie dostępnych dań z różnych restauracji
* Wyświetlanie szczegółów dań z różnych restauracji
* Ranking najlepszych potraw z tego miesiąca
* Wystawianie opinii o daniach
* Przeglądanie dostępnych restauracji
* Wystawanie opinii o restauracjach
* Wyświetlanie informacji o restauracjach


Panel Admina
* Statystyki sprzedaży - możliwość przeglądania danych statystycznych dotyczących sprzedaży, takich jak liczba zamówień, przychody, najczęściej wybierane produkty itp.
* Pełna obsługa CRUD zasobu zamówień - możliwość tworzenia, odczytu, edytowania i usuwania zamówień.
* Pełna obsługa CRUD zasobu dań - możliwość tworzenia, odczytu, edytowania i usuwania zamówień.
* Pełna obsługa CRUD zasobu restauracji -  możliwość tworzenia, odczytu, edytowania i usuwania restauracji.
* Pełna obsługa CRUD zasobu użytkowników - możliwość tworzenia, odczytu, edytowania i usuwania użytkowników.
* Obsługa ról (admin, customer) – middleware + routing warunkowy.



Ogólne Funkcjonalności
* Logowanie i rejestracja użytkownika z walidacją danych.
* Obsługa resetu hasła z wykorzystaniem tokenu.
* Obsługa dwuetapowej weryfikacji TOTP (Google Authenticator).
* Możliwość zmiany hasła i zarządzania swoim profilem.
* Obsługa widoków błędów HTTP (403, 404, 419, 500)


Bezpieczeństwo aplikacji
* Ochrona przed brute-force (RateLimiter na logowanie)
* TOTP – dwuetapowa weryfikacja logowania
* Hasła szyfrowane (bcrypt)
* Walidacja i komunikaty błędów dostosowane do użytkownika
* Middleware – zabezpiecza dostęp do zasobów po zalogowaniu


# Reset hasła (komenda CLI)
```
php artisan password:reset janek@example.com
```

### Narzędzia i technologie
* Laravel 11 (backend, framework aplikacji)
* PHP 8.3
* Livewire Volt (komponenty frontendowe i interakcja)
* Tailwind CSS (stylowanie widoków)
* PostgreSQL
* spomky-labs/otphp (2FA – TOTP)

### Uruchomienie aplikacji

composer install
npm install

```
echo === Instalacja zaleznosci PHP ===
call composer install

echo === Instalacja zaleznosci JS ===
call npm install

echo === Tworzenie .env (jesli brak) ===
IF NOT EXIST .env (
    copy .env.example .env
)

echo === Generowanie APP_KEY ===
call php artisan key:generate

echo === Tworzenie dowiazania storage ===
call php artisan storage:link

echo === Migracja i seedy ===
call php artisan migrate:fresh --seed

echo === Uruchamianie backendu i frontend ===
call composer run dev

```

Przykładowi użytkownicy aplikacji:
* administrator: anna@example.com password
* użytkownik: janek@example.com password

### Baza danych

![Diagram ERD](./docs-img/erd.png)

## Widoki aplikacji 

![Strona główna](./docs-img/koszyk.png)
*Koszyk*

![Strona główna](./docs-img/historiaZakupu.png)
*Historia zakupów*

![Strona główna](./docs-img/statystykiSprzedazy.png)
*Statystyki sprzedaży*

![Strona główna](./docs-img/zarzadzanieZamowieniami.png)
*Zarządzanie zamówieniami*

![Strona główna](./docs-img/daniaCRUD.png)
*Zarządzanie daniami*

![Strona główna](./docs-img/przeglodaniedan.png)
*Przeglądarka dań*

![Strona główna](./docs-img/rankingnajlepszychdan.png)
*Ranking Najlepiej ocenianych dań*


![Strona główna](./docs-img/ocenadania.png)
*Wystawianie opinni o daniach*


![Strona główna](./docs-img/Wyswietlanieszczegolowdania.png)
*Wyświetlanie szczegółów wybranego dania*

![Strona główna](./docs-img/informacjeoRestauracji.png)
*Wyświetlanie informacji o wybranej restauracji*

![Strona główna](./docs-img/przegladarkaRestauracji.png)
*Przeglądarka restauracji*

![Strona główna](./docs-img/zarzadzanieRestauracjami.png)
*Zarządzanie restauracjami*

![Strona główna](./docs-img/ocenaRestauracji.png)
*Wystawianie opinii o restauracji*



![Strona główna](./docs-img/ocenaRestauracji.png)
*Wystawianie opinii o restauracji*






![Logowanie](./docs-img/Logowanie.png)  
*Formularz logowania z walidacją i komunikatami błędów*

![Rejestracja](./docs-img/Rejestracja.png)  
*Formularz rejestracji użytkownika z walidacją danych*

![Reset hasła](./docs-img/ResetujHaslo.png)  
*Formularz resetowania hasła z obsługą tokenów i walidacji*

![Panel administratora](./docs-img/PanelAdministratora.png)  
*Panel administratora z dostępem do zarządzania zasobami*

![Panel użytkownika](./docs-img/PanelUzytkownika.png)  
*Panel klienta z dostępem do ustawień i historii zamówień*

![Zarządzanie użytkownikami](./docs-img/ZarzadzanieUzytkownikami.png)  
*Lista użytkowników z opcją edycji i usuwania (CRUD)*

![Tworzenie nowego użytkownika](./docs-img/TworzenieNowegoUzytkownika.png)  
*Formularz tworzenia nowego użytkownika (CRUD – Create)*

![Edycja danych użytkownika](./docs-img/EdytujDaneUzytkownika.png)  
*Formularz edycji danych użytkownika (CRUD – Update)*

![Szczegóły użytkownika](./docs-img/SzczegolyUzytkownika.png)  
*Widok szczegółów użytkownika (CRUD – Read)*

![Weryfikacja dwuetapowa (TOTP)](./docs-img/Weryfikacja2etapowa.png)  
*Widok weryfikacji kodu TOTP (Google Authenticator)*

![Strona błędu 404](./docs-img/StronaBledu.png)  
*Dedykowany widok błędu HTTP – przykład 404*
