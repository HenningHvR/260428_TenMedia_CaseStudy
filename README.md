# TenMedia Case Study

## Projektbeschreibung

Dieses Laravel-Projekt wurde im Rahmen einer Case Study umgesetzt. Ziel ist die Entwicklung einer einfachen Jobplattform mit Rollen-, Rechte- und CRUD-Logik.

Die Anwendung bildet folgende fachliche Bereiche ab:

- Kategorien für Stellenanzeigen
- Firmen
- JobPostings
- Userverwaltung mit Rollenmodell
- Authentifizierung über Laravel Breeze
- Rechteprüfung über Laravel Policies
- Datenbankstruktur über Laravel Migrations
- Testdaten über Seeder

Das Projekt dient als Ausbildungs- und Lernprojekt im Bereich Laravel, MVC, Datenmodellierung, Rollenverwaltung und sauberer CRUD-Umsetzung.

---

## Technologiestack

- PHP
- Laravel
- Laravel Breeze
- Laravel Sail
- Docker
- MySQL
- Blade Templates
- Tailwind CSS
- PowerShell unter Windows

---

## Rollenmodell

Die Anwendung verwendet drei Rollen:

| Rolle | Beschreibung |
|---|---|
| `admin` | Darf alle Bereiche sehen, erstellen, bearbeiten und löschen |
| `provider` | Darf eigene Firma und eigene JobPostings verwalten |
| `applicant` | Darf Kategorien, Firmen und JobPostings ansehen |

---

## Berechtigungskonzept

Die Rechte werden über Laravel Policies umgesetzt.

### Admin

Der Admin wird in den Policies über eine `before()`-Methode freigeschaltet.

```php
public function before(User $user, string $ability): ?bool
{
    if ($user->role === 'admin') {
        return true;
    }

    return null;
}
```

Dadurch darf der Admin alle Aktionen ausführen.

### Provider

Provider dürfen:

- JobPostings ansehen
- eigene JobPostings erstellen
- eigene JobPostings bearbeiten
- eigene JobPostings löschen
- die eigene Firma bearbeiten
- Kategorien ansehen
- Firmen ansehen

Provider dürfen nicht:

- User verwalten
- Kategorien erstellen, bearbeiten oder löschen
- fremde JobPostings bearbeiten oder löschen
- Firmen löschen

### Applicant

Applicants dürfen:

- Kategorien ansehen
- Firmen ansehen
- JobPostings ansehen

Applicants dürfen nicht:

- User verwalten
- Firmen verwalten
- Kategorien verwalten
- JobPostings erstellen, bearbeiten oder löschen

---

## Datenmodell

### Zentrale Beziehungen

Das Projekt verwendet folgendes Beziehungsmodell:

| Beziehung | Bedeutung |
|---|---|
| `User belongsTo Company` | Ein Provider kann maximal einer Firma zugeordnet sein |
| `Company hasMany User` | Eine Firma kann mehrere Provider haben |
| `Company hasMany JobPosting` | Eine Firma kann mehrere JobPostings besitzen |
| `Category hasMany JobPosting` | Eine Kategorie kann mehrere JobPostings enthalten |
| `JobPosting belongsTo Company` | Ein JobPosting gehört zu genau einer Firma |
| `JobPosting belongsTo Category` | Ein JobPosting gehört zu genau einer Kategorie |

### Wichtiger Architekturwechsel

Die Firmenzuordnung erfolgt über:

```text
users.company_id -> companies.id
```

Nicht mehr über:

```text
companies.user_id -> users.id
```

Das ermöglicht:

- eine Firma mit mehreren Providern
- einen Provider mit maximal einer Firma
- Admins ohne eigene Firmenzuordnung
- Applicants ohne Firmenzuordnung

---

## Hauptfunktionen

### Kategorien

- Kategorien anzeigen
- einzelne Kategorie anzeigen
- Kategorie erstellen
- Kategorie bearbeiten
- Kategorie löschen
- Löschschutz, wenn JobPostings zugeordnet sind

### Firmen

- Firmen anzeigen
- einzelne Firma anzeigen
- Firma erstellen
- Firma bearbeiten
- Firma löschen
- Anzeige zugeordneter Provider
- Anzeige zugehöriger JobPostings
- Löschschutz, wenn Provider oder JobPostings zugeordnet sind

### JobPostings

- JobPostings anzeigen
- einzelnes JobPosting anzeigen
- JobPosting erstellen
- JobPosting bearbeiten
- JobPosting löschen
- Zuordnung zu Firma und Kategorie
- Rollenbasierte Rechteprüfung

### Userverwaltung

- User anzeigen
- einzelnen User anzeigen
- User bearbeiten
- Name bearbeiten
- E-Mail bearbeiten
- Passwort optional ändern
- Rolle ändern
- Firma zu Provider zuordnen
- eigene Rolle kann nicht geändert werden
- Userverwaltung nur für Admin sichtbar

Die User-Erstellung erfolgt über Laravel Breeze. Die administrative Userverwaltung umfasst Listenansicht, Detailansicht und Bearbeitung inklusive Rollen- und Company-Zuordnung.

---

## Testdaten

Die Testdaten werden über `DatabaseSeeder.php` angelegt.

### Kategorien

- IT & Softwareentwicklung
- Business Development & Sales/Vertrieb
- Holzverarbeitung - Tischlerei

### Firmen

- Codehafen Solutions GmbH
- Bytewerkparade Berlin UG
- Marktkompass Consulting GmbH
- Leadlotse Sales Services UG
- Ast & Feder Tischlerei GmbH
- Hobelherz Manufaktur UG

### JobPostings

Je Firma werden drei JobPostings angelegt.

Insgesamt werden erzeugt:

| Datentyp | Anzahl |
|---|---:|
| Kategorien | 3 |
| Firmen | 6 |
| JobPostings | 18 |
| User | 12 |

---

## Testzugänge

Nach dem Seed stehen folgende Testzugänge zur Verfügung.

### Admin

| E-Mail | Passwort |
|---|---|
| `admin@example.com` | `password` |

### Provider

| E-Mail | Passwort | Firma |
|---|---|---|
| `test@example.com` | `Password` | Hobelherz Manufaktur UG |
| `provider@codehafen.eu` | `code1234` | Codehafen Solutions GmbH |
| `provider@bytewerkpara.de` | `Byte5678` | Bytewerkparade Berlin UG |
| `provider@mk-consulting.com` | `Compass0` | Marktkompass Consulting GmbH |
| `provider@llss.org` | `Sales238` | Leadlotse Sales Services UG |
| `provider@ast-feder.org` | `ast+feder` | Ast & Feder Tischlerei GmbH |
| `provider@hobelherz.net` | `hobel679` | Hobelherz Manufaktur UG |

### Applicants

| E-Mail | Passwort |
|---|---|
| `test_1-applicant_1@example.com` | `password` |
| `applicant_2@privat.de` | `12345678` |
| `applicant_3@eigen.de` | `Pa$$w0rt` |
| `applicant_4@t-online.de` | `=K5&!}Y/eTEBx9S:&ls?H38)v)` |

---

## Installation und Start

Die folgenden Befehle sind für Windows PowerShell und Docker ausgelegt.

### 1. Projekt starten

```powershell
docker compose up -d
```

### 2. Abhängigkeiten installieren

Falls erforderlich:

```powershell
docker compose exec laravel.test composer install
```

### 3. Environment-Datei prüfen

Die Datei `.env` muss vorhanden sein.

Wichtig für Laravel Sail:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

### 4. App-Key erzeugen

```powershell
docker compose exec laravel.test php artisan key:generate
```

### 5. Datenbank neu aufbauen und Testdaten einspielen

```powershell
docker compose exec laravel.test php artisan migrate:fresh --seed
```

### 6. Cache leeren

```powershell
docker compose exec laravel.test php artisan optimize:clear
```

### 7. Routen prüfen

```powershell
docker compose exec laravel.test php artisan route:list
```

### 8. Anwendung öffnen

Im Browser:

```text
http://localhost:8080
```

oder direkt:

```text
http://localhost:8080/login
```

---

## Wichtige Routen

| Bereich | Route |
|---|---|
| Dashboard | `/dashboard` |
| Kategorien | `/categories` |
| Firmen | `/companies` |
| JobPostings | `/job-postings` |
| Userverwaltung | `/users` |

Die Userverwaltung ist nur für Admins sichtbar und erreichbar.

---

## Navigation und Dashboard

Das Dashboard enthält Kacheln für:

- Kategorien
- Firmen
- JobPostings
- User, nur für Admins

Die Hauptnavigation enthält Links zu:

- Dashboard
- Kategorien
- Firmen
- JobPostings
- User, nur für Admins

Die Sichtbarkeit der Userverwaltung wird über die `UserPolicy` gesteuert.

---

## Erfüllte Aufgaben der Case Study

### Aufgabe 1: Konzept

Umgesetzt wurden:

- Datenmodell
- Rollenmodell
- Seitenstruktur
- Beziehungen zwischen User, Company, Category und JobPosting
- Rechtekonzept über Policies

### Aufgabe 2: Laravel-Projekt

Umgesetzt wurden:

- Laravel-Projekt
- Laravel Sail
- Docker-basierte Entwicklungsumgebung
- Laravel Breeze für Authentifizierung
- MySQL-Datenbank

### Aufgabe 3: Models, Controller, Migrations, Policies

Umgesetzt wurden:

- `User`
- `Company`
- `Category`
- `JobPosting`
- passende Controller
- passende Migrations
- passende Policies
- Form Requests für Validierung

### Aufgabe 4: Views und CRUD

Umgesetzt wurden CRUD-nahe Ansichten für:

- Kategorien
- Firmen
- JobPostings
- Userverwaltung für Admins

Die Views sind mit den Controllern verbunden und nutzen rollenbasierte Rechte über Policies.

---

## Besondere Umsetzungen

### Rollenbasierte Rechte

Die Anwendung nutzt Laravel Policies, um Rollen sauber voneinander zu trennen.

### Löschschutz

Firmen und Kategorien können nicht gelöscht werden, wenn abhängige Datensätze vorhanden sind.

Beispiele:

- Kategorie mit JobPostings kann nicht gelöscht werden
- Firma mit JobPostings kann nicht gelöscht werden
- Firma mit Providern kann nicht gelöscht werden

### Provider-Zuordnung

Ein Provider kann maximal einer Firma zugeordnet sein.

Eine Firma kann mehrere Provider besitzen.

### Admin-Zugriff

Admins sind keiner Firma zugeordnet, dürfen aber alle Firmen, Kategorien, JobPostings und User verwalten.

---

## Testempfehlung

Nach dem Einspielen der Seeder sollten folgende Tests durchgeführt werden.

### Admin-Test

Login:

```text
admin@example.com
password
```

Prüfen:

- Dashboard öffnen
- Kategorien anzeigen, erstellen, bearbeiten
- Firmen anzeigen, erstellen, bearbeiten
- JobPostings anzeigen, erstellen, bearbeiten
- User anzeigen und bearbeiten
- Provider einer Firma zuordnen

### Provider-Test

Login zum Beispiel:

```text
provider@codehafen.eu
code1234
```

Prüfen:

- Dashboard öffnen
- Kategorien ansehen
- Firmen ansehen
- eigene Firma bearbeiten
- eigene JobPostings bearbeiten
- keine Userverwaltung sehen
- keine fremden JobPostings bearbeiten

### Applicant-Test

Login zum Beispiel:

```text
test_1-applicant_1@example.com
password
```

Prüfen:

- Dashboard öffnen
- Kategorien ansehen
- Firmen ansehen
- JobPostings ansehen
- keine Erstellen-Buttons sehen
- keine Bearbeiten-Buttons sehen
- keine Userverwaltung sehen

---

## Nützliche PowerShell-Befehle

### Container starten

```powershell
docker compose up -d
```

### Container stoppen

```powershell
docker compose down
```

### Migrationen ausführen

```powershell
docker compose exec laravel.test php artisan migrate
```

### Datenbank zurücksetzen und Seeder ausführen

```powershell
docker compose exec laravel.test php artisan migrate:fresh --seed
```

### Cache leeren

```powershell
docker compose exec laravel.test php artisan optimize:clear
```

### Routen anzeigen

```powershell
docker compose exec laravel.test php artisan route:list
```

### Tinker starten

```powershell
docker compose exec laravel.test php artisan tinker
```

---

## Hinweise zum Projektstand

Dieses Projekt ist eine Case Study und dient der Demonstration grundlegender Laravel-Konzepte:

- MVC-Struktur
- Migrationen
- Eloquent-Beziehungen
- Controller-Logik
- Form Requests
- Policies
- Blade Views
- Seeder
- Authentifizierung
- Rollen- und Rechtekonzept

Der Fokus liegt auf Nachvollziehbarkeit, sauberer Struktur und einer prüfbaren Umsetzung der geforderten CRUD- und Rechtefunktionen.
