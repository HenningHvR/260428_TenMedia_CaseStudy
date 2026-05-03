<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // Befüllt die Datenbank mit sinnvollen Testdaten.
    public function run(): void
    {
        // Admin-User ohne Company-Zuordnung.
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => 'password',
                'role' => 'admin',
                'company_id' => null,
            ]
        );

        // Companies werden unabhängig von Usern angelegt.
        $tenMediaCompany = Company::updateOrCreate(
            ['cmpny_name' => 'TenMedia GmbH'],
            [
                'cmpny_description' => 'Agentur für digitale Produkte und Softwareentwicklung.',
                'website' => 'https://www.tenmedia.de',
                'cmpny_location' => 'Berlin',
            ]
        );

        $exampleCompany = Company::updateOrCreate(
            ['cmpny_name' => 'Beispiel IT GmbH'],
            [
                'cmpny_description' => 'Beispielunternehmen für IT-nahe Dienstleistungen.',
                'website' => 'www.beispiel-it.de',
                'cmpny_location' => 'Berlin',
            ]
        );

        // Provider bekommen maximal eine Company über users.company_id.
        // Mehrere Provider dürfen derselben Company zugeordnet sein.
        $providerOne = User::updateOrCreate(
            ['email' => 'provider1@example.com'],
            [
                'name' => 'Provider Eins',
                'password' => 'password',
                'role' => 'provider',
                'company_id' => $tenMediaCompany->id,
            ]
        );

        $providerTwo = User::updateOrCreate(
            ['email' => 'provider2@example.com'],
            [
                'name' => 'Provider Zwei',
                'password' => 'password',
                'role' => 'provider',
                'company_id' => $tenMediaCompany->id,
            ]
        );

        $providerThree = User::updateOrCreate(
            ['email' => 'provider3@example.com'],
            [
                'name' => 'Provider Drei',
                'password' => 'password',
                'role' => 'provider',
                'company_id' => $exampleCompany->id,
            ]
        );

        // Applicant ohne Company-Zuordnung.
        $applicantUser = User::updateOrCreate(
            ['email' => 'applicant@example.com'],
            [
                'name' => 'Applicant User',
                'password' => 'password',
                'role' => 'applicant',
                'company_id' => null,
            ]
        );

        // Kategorien anlegen.
        $softwareCategory = Category::updateOrCreate(
            ['ctgry_name' => 'Softwareentwicklung'],
            [
                'ctgry_description' => 'Berufe im Bereich Softwareentwicklung und Programmierung.',
            ]
        );

        $projectManagementCategory = Category::updateOrCreate(
            ['ctgry_name' => 'Projektmanagement'],
            [
                'ctgry_description' => 'Berufe im Bereich Planung, Steuerung und Koordination.',
            ]
        );

        // JobPostings gehören weiterhin zu genau einer Company und einer Category.
        JobPosting::updateOrCreate(
            ['title' => 'Junior Laravel Developer'],
            [
                'company_id' => $tenMediaCompany->id,
                'category_id' => $softwareCategory->id,
                'jp_description' => 'Entwicklung einer Laravel-Anwendung im Team.',
                'jp_location' => 'Berlin',
                'experience_level' => 'Junior',
                'employment_type' => 'Vollzeit',
                'salary' => 42000,
                'is_active' => true,
            ]
        );

        JobPosting::updateOrCreate(
            ['title' => 'PHP Backend Developer'],
            [
                'company_id' => $tenMediaCompany->id,
                'category_id' => $softwareCategory->id,
                'jp_description' => 'Backend-Entwicklung mit PHP, Laravel und MySQL.',
                'jp_location' => 'Berlin / Hybrid',
                'experience_level' => 'Professional',
                'employment_type' => 'Vollzeit',
                'salary' => 52000,
                'is_active' => true,
            ]
        );

        JobPosting::updateOrCreate(
            ['title' => 'IT Projektassistenz'],
            [
                'company_id' => $exampleCompany->id,
                'category_id' => $projectManagementCategory->id,
                'jp_description' => 'Unterstützung bei IT-Projekten und Abstimmung mit Fachbereichen.',
                'jp_location' => 'Berlin',
                'experience_level' => 'Entry Level',
                'employment_type' => 'Teilzeit',
                'salary' => 36000,
                'is_active' => true,
            ]
        );
    }
}
