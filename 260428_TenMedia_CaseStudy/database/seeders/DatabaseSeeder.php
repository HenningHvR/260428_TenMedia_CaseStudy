<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // Befüllt die Datenbank mit vollständigen Testdaten für die TenMedia Case Study.
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Kategorien
        |--------------------------------------------------------------------------
        */

        $softwareCategory = Category::updateOrCreate(
            ['ctgry_name' => 'IT & Softwareentwicklung'],
            [
                'ctgry_description' => 'Stellenanzeigen aus Entwicklung, Datenbanken, Webentwicklung und IT-Projekten.',
            ]
        );

        $salesCategory = Category::updateOrCreate(
            ['ctgry_name' => 'Business Development & Sales/Vertrieb'],
            [
                'ctgry_description' => 'Stellenanzeigen aus PreSales, Vertrieb, AfterSales und Vertriebsunterstützung.',
            ]
        );

        $carpentryCategory = Category::updateOrCreate(
            ['ctgry_name' => 'Holzverarbeitung - Tischlerei'],
            [
                'ctgry_description' => 'Stellenanzeigen aus Holz-Handwerk für Kleinserienfertigung und Maßarbeiten.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Companies
        |--------------------------------------------------------------------------
        */

        $codehafenCompany = Company::updateOrCreate(
            ['cmpny_name' => 'Codehafen Solutions GmbH'],
            [
                'cmpny_description' => 'Entwickelt maßgeschneiderte Webanwendungen, Schnittstellen und interne Tools für kleine und mittlere Unternehmen.',
                'website' => 'www.codehafen.eu',
                'cmpny_location' => 'Jena',
            ]
        );

        $bytewerkparadeCompany = Company::updateOrCreate(
            ['cmpny_name' => 'Bytewerkparade Berlin UG'],
            [
                'cmpny_description' => 'Spezialisiert auf Laravel-, Datenbank- und Dashboard-Lösungen mit Fokus auf saubere Prozesse und wartbare Software.',
                'website' => 'www.bytewerkpara.de',
                'cmpny_location' => 'Berlin',
            ]
        );

        $marktkompassCompany = Company::updateOrCreate(
            ['cmpny_name' => 'Marktkompass Consulting GmbH'],
            [
                'cmpny_description' => 'Unterstützt Unternehmen beim Aufbau neuer Vertriebskanäle, Partnernetzwerke und datenbasierter Vertriebsstrategien.',
                'website' => 'www.MK-Consulting.com',
                'cmpny_location' => 'Frankfurt/Oder',
            ]
        );

        $leadlotseCompany = Company::updateOrCreate(
            ['cmpny_name' => 'Leadlotse Sales Services UG'],
            [
                'cmpny_description' => 'Begleitet B2B-Teams bei Leadgenerierung, Kundengewinnung und strukturierter Angebotsentwicklung.',
                'website' => 'http://www.llss.org',
                'cmpny_location' => 'Ahlen/Westf.',
            ]
        );

        $astFederCompany = Company::updateOrCreate(
            ['cmpny_name' => 'Ast & Feder Tischlerei GmbH'],
            [
                'cmpny_description' => 'Fertigt individuelle Möbel, Innenausbauten und Holzlösungen mit handwerklichem Anspruch und moderner Planung.',
                'website' => 'www.ast-feder.de',
                'cmpny_location' => 'Frankfurt/Main',
            ]
        );

        $hobelherzCompany = Company::updateOrCreate(
            ['cmpny_name' => 'Hobelherz Manufaktur UG'],
            [
                'cmpny_description' => 'Kleine Tischlerei für Maßanfertigungen, Reparaturen und nachhaltige Holzgestaltung aus regionalen Materialien.',
                'website' => 'www.hobelherz.net',
                'cmpny_location' => 'Berlin',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | User und Rollen
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => 'password',
                'role' => 'admin',
                'company_id' => null,
            ]
        );

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => 'Password',
                'role' => 'provider',
                'company_id' => $hobelherzCompany->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'test_1-applicant_1@example.com'],
            [
                'name' => 'Test_1 Applicant_1',
                'password' => 'password',
                'role' => 'applicant',
                'company_id' => null,
            ]
        );

        User::updateOrCreate(
            ['email' => 'provider@codehafen.eu'],
            [
                'name' => 'Test_2 Provider_1',
                'password' => 'code1234',
                'role' => 'provider',
                'company_id' => $codehafenCompany->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'provider@bytewerkpara.de'],
            [
                'name' => 'Test_2 Provider_2',
                'password' => 'Byte5678',
                'role' => 'provider',
                'company_id' => $bytewerkparadeCompany->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'provider@mk-consulting.com'],
            [
                'name' => 'Test_2 Provider_3',
                'password' => 'Compass0',
                'role' => 'provider',
                'company_id' => $marktkompassCompany->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'provider@llss.org'],
            [
                'name' => 'Test_2 Provider_4',
                'password' => 'Sales238',
                'role' => 'provider',
                'company_id' => $leadlotseCompany->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'provider@ast-feder.org'],
            [
                'name' => 'Test_2 Provider_5',
                'password' => 'ast+feder',
                'role' => 'provider',
                'company_id' => $astFederCompany->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'provider@hobelherz.net'],
            [
                'name' => 'Test_2 Provider_6',
                'password' => 'hobel679',
                'role' => 'provider',
                'company_id' => $hobelherzCompany->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'applicant_2@privat.de'],
            [
                'name' => 'Test_3 Applicant_2',
                'password' => '12345678',
                'role' => 'applicant',
                'company_id' => null,
            ]
        );

        User::updateOrCreate(
            ['email' => 'applicant_3@eigen.de'],
            [
                'name' => 'Test_3 Applicant_3',
                'password' => 'Pa$$w0rt',
                'role' => 'applicant',
                'company_id' => null,
            ]
        );

        User::updateOrCreate(
            ['email' => 'applicant_4@t-online.de'],
            [
                'name' => 'Test_3 Applicant_4',
                'password' => '=K5&!}Y/eTEBx9S:&ls?H38)v)',
                'role' => 'applicant',
                'company_id' => null,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | JobPostings für Codehafen Solutions GmbH
        |--------------------------------------------------------------------------
        */

        JobPosting::updateOrCreate(
            [
                'title' => 'Laravel Developer für Hafenlogik und Schnittstellen',
                'company_id' => $codehafenCompany->id,
            ],
            [
                'category_id' => $softwareCategory->id,
                'jp_description' => 'Entwicklung wartbarer Laravel-Anwendungen, API-Anbindungen und interner Werkzeuge für mittelständische Kunden.',
                'jp_location' => 'Jena / Hybrid',
                'experience_level' => 'Junior bis Professional',
                'employment_type' => 'Vollzeit',
                'salary' => 46000,
                'is_active' => true,
            ]
        );

        JobPosting::updateOrCreate(
            [
                'title' => 'Datenbankentwickler MySQL für interne Tools',
                'company_id' => $codehafenCompany->id,
            ],
            [
                'category_id' => $softwareCategory->id,
                'jp_description' => 'Konzeption relationaler Datenmodelle, Optimierung von SQL-Abfragen und Pflege bestehender Datenbankstrukturen.',
                'jp_location' => 'Jena',
                'experience_level' => 'Professional',
                'employment_type' => 'Vollzeit',
                'salary' => 52000,
                'is_active' => true,
            ]
        );

        JobPosting::updateOrCreate(
            [
                'title' => 'Werkstudent Webentwicklung PHP und JavaScript',
                'company_id' => $codehafenCompany->id,
            ],
            [
                'category_id' => $softwareCategory->id,
                'jp_description' => 'Unterstützung bei Frontend-Anpassungen, Formularlogik, Tests und kleineren Laravel-Modulen.',
                'jp_location' => 'Jena',
                'experience_level' => 'Entry Level',
                'employment_type' => 'Teilzeit',
                'salary' => 18000,
                'is_active' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | JobPostings für Bytewerkparade Berlin UG
        |--------------------------------------------------------------------------
        */

        JobPosting::updateOrCreate(
            [
                'title' => 'Backend Developer Laravel für Dashboard-Projekte',
                'company_id' => $bytewerkparadeCompany->id,
            ],
            [
                'category_id' => $softwareCategory->id,
                'jp_description' => 'Entwicklung von rollenbasierten Dashboards, CRUD-Modulen und Reporting-Funktionen mit Laravel und MySQL.',
                'jp_location' => 'Berlin',
                'experience_level' => 'Professional',
                'employment_type' => 'Vollzeit',
                'salary' => 54000,
                'is_active' => true,
            ]
        );

        JobPosting::updateOrCreate(
            [
                'title' => 'Junior Fullstack Developer für Prozesssoftware',
                'company_id' => $bytewerkparadeCompany->id,
            ],
            [
                'category_id' => $softwareCategory->id,
                'jp_description' => 'Mitarbeit an Weboberflächen, Datenbankabfragen, Formularvalidierung und sauber strukturierten Laravel-Controllern.',
                'jp_location' => 'Berlin / Hybrid',
                'experience_level' => 'Junior',
                'employment_type' => 'Vollzeit',
                'salary' => 41000,
                'is_active' => true,
            ]
        );

        JobPosting::updateOrCreate(
            [
                'title' => 'QA-orientierter PHP Developer für Wartbarkeit',
                'company_id' => $bytewerkparadeCompany->id,
            ],
            [
                'category_id' => $softwareCategory->id,
                'jp_description' => 'Verbesserung bestehender Codebasen, Refactoring, einfache Tests und Dokumentation technischer Entscheidungen.',
                'jp_location' => 'Berlin',
                'experience_level' => 'Professional',
                'employment_type' => 'Teilzeit',
                'salary' => 39000,
                'is_active' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | JobPostings für Marktkompass Consulting GmbH
        |--------------------------------------------------------------------------
        */

        JobPosting::updateOrCreate(
            [
                'title' => 'Business Development Manager Partnervertrieb',
                'company_id' => $marktkompassCompany->id,
            ],
            [
                'category_id' => $salesCategory->id,
                'jp_description' => 'Aufbau neuer Partnerkanäle, Marktanalyse und strukturierte Entwicklung von Vertriebsmaßnahmen im B2B-Umfeld.',
                'jp_location' => 'Frankfurt/Oder',
                'experience_level' => 'Professional',
                'employment_type' => 'Vollzeit',
                'salary' => 56000,
                'is_active' => true,
            ]
        );

        JobPosting::updateOrCreate(
            [
                'title' => 'PreSales Consultant Datenbasierte Vertriebsstrategie',
                'company_id' => $marktkompassCompany->id,
            ],
            [
                'category_id' => $salesCategory->id,
                'jp_description' => 'Übersetzung fachlicher Kundenbedarfe in umsetzbare Angebotskonzepte und datenbasierte Vertriebsargumentationen.',
                'jp_location' => 'Frankfurt/Oder / Remote',
                'experience_level' => 'Professional',
                'employment_type' => 'Vollzeit',
                'salary' => 59000,
                'is_active' => true,
            ]
        );

        JobPosting::updateOrCreate(
            [
                'title' => 'Junior Sales Analyst für Markt- und Zielgruppenarbeit',
                'company_id' => $marktkompassCompany->id,
            ],
            [
                'category_id' => $salesCategory->id,
                'jp_description' => 'Pflege von Zielkundenlisten, Auswertung von Vertriebsdaten und Unterstützung beim Aufbau neuer Kampagnen.',
                'jp_location' => 'Frankfurt/Oder',
                'experience_level' => 'Junior',
                'employment_type' => 'Teilzeit',
                'salary' => 32000,
                'is_active' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | JobPostings für Leadlotse Sales Services UG
        |--------------------------------------------------------------------------
        */

        JobPosting::updateOrCreate(
            [
                'title' => 'Lead Manager B2B Kundengewinnung',
                'company_id' => $leadlotseCompany->id,
            ],
            [
                'category_id' => $salesCategory->id,
                'jp_description' => 'Recherche, Qualifikation und strukturierte Übergabe von B2B-Leads an Vertriebsteams.',
                'jp_location' => 'Ahlen/Westf.',
                'experience_level' => 'Junior bis Professional',
                'employment_type' => 'Vollzeit',
                'salary' => 38000,
                'is_active' => true,
            ]
        );

        JobPosting::updateOrCreate(
            [
                'title' => 'Sales Operations Assistenz mit CRM-Fokus',
                'company_id' => $leadlotseCompany->id,
            ],
            [
                'category_id' => $salesCategory->id,
                'jp_description' => 'Pflege von CRM-Daten, Vorbereitung von Angeboten und Unterstützung bei Vertriebsprozessen.',
                'jp_location' => 'Ahlen/Westf. / Hybrid',
                'experience_level' => 'Entry Level',
                'employment_type' => 'Teilzeit',
                'salary' => 29000,
                'is_active' => true,
            ]
        );

        JobPosting::updateOrCreate(
            [
                'title' => 'AfterSales Koordinator für Bestandskunden',
                'company_id' => $leadlotseCompany->id,
            ],
            [
                'category_id' => $salesCategory->id,
                'jp_description' => 'Betreuung bestehender B2B-Kunden, Nachverfolgung offener Angebote und Identifikation weiterer Bedarfe.',
                'jp_location' => 'Ahlen/Westf.',
                'experience_level' => 'Professional',
                'employment_type' => 'Vollzeit',
                'salary' => 44000,
                'is_active' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | JobPostings für Ast & Feder Tischlerei GmbH
        |--------------------------------------------------------------------------
        */

        JobPosting::updateOrCreate(
            [
                'title' => 'Tischler für hochwertigen Innenausbau',
                'company_id' => $astFederCompany->id,
            ],
            [
                'category_id' => $carpentryCategory->id,
                'jp_description' => 'Fertigung und Montage individueller Innenausbauten mit Schwerpunkt auf Präzision, Materialgefühl und sauberer Umsetzung.',
                'jp_location' => 'Frankfurt/Main',
                'experience_level' => 'Professional',
                'employment_type' => 'Vollzeit',
                'salary' => 39000,
                'is_active' => true,
            ]
        );

        JobPosting::updateOrCreate(
            [
                'title' => 'Arbeitsvorbereiter Holztechnik und CAD',
                'company_id' => $astFederCompany->id,
            ],
            [
                'category_id' => $carpentryCategory->id,
                'jp_description' => 'Planung von Zuschnitten, Materiallisten und Fertigungsunterlagen für individuelle Möbel- und Innenausbauprojekte.',
                'jp_location' => 'Frankfurt/Main',
                'experience_level' => 'Professional',
                'employment_type' => 'Vollzeit',
                'salary' => 43000,
                'is_active' => true,
            ]
        );

        JobPosting::updateOrCreate(
            [
                'title' => 'Ausbauhelfer Holz und Montage',
                'company_id' => $astFederCompany->id,
            ],
            [
                'category_id' => $carpentryCategory->id,
                'jp_description' => 'Unterstützung bei Montagearbeiten, Oberflächenvorbereitung und Transport hochwertiger Innenausbauelemente.',
                'jp_location' => 'Frankfurt/Main',
                'experience_level' => 'Entry Level',
                'employment_type' => 'Teilzeit',
                'salary' => 28000,
                'is_active' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | JobPostings für Hobelherz Manufaktur UG
        |--------------------------------------------------------------------------
        */

        JobPosting::updateOrCreate(
            [
                'title' => 'Tischler für Maßanfertigungen und Reparaturen',
                'company_id' => $hobelherzCompany->id,
            ],
            [
                'category_id' => $carpentryCategory->id,
                'jp_description' => 'Anfertigung individueller Holzlösungen, Reparaturarbeiten und Umsetzung kleiner Serien mit regionalen Materialien.',
                'jp_location' => 'Berlin',
                'experience_level' => 'Professional',
                'employment_type' => 'Vollzeit',
                'salary' => 37000,
                'is_active' => true,
            ]
        );

        JobPosting::updateOrCreate(
            [
                'title' => 'Werkstattassistenz nachhaltige Holzgestaltung',
                'company_id' => $hobelherzCompany->id,
            ],
            [
                'category_id' => $carpentryCategory->id,
                'jp_description' => 'Unterstützung bei Materialvorbereitung, Oberflächenbehandlung und Organisation einer kleinen Werkstatt.',
                'jp_location' => 'Berlin',
                'experience_level' => 'Entry Level',
                'employment_type' => 'Teilzeit',
                'salary' => 26000,
                'is_active' => true,
            ]
        );

        JobPosting::updateOrCreate(
            [
                'title' => 'Projektleiter Kleinserienfertigung Holz',
                'company_id' => $hobelherzCompany->id,
            ],
            [
                'category_id' => $carpentryCategory->id,
                'jp_description' => 'Koordination kleiner Fertigungsserien, Abstimmung mit Kundinnen und Kunden sowie Qualitätssicherung in der Werkstatt.',
                'jp_location' => 'Berlin',
                'experience_level' => 'Professional',
                'employment_type' => 'Vollzeit',
                'salary' => 45000,
                'is_active' => true,
            ]
        );
    }
}
