# Bearbeitungskonzept 260428_TenMedia_CaseStudy

## Ausgangspunkt der Aufgabe
Browserbasierte Anwendung zur Verwaltung von Stellenanzeigen.

Hinweis:
Das in der Aufgabenstellung genannte Modell "Job" wird in dieser Lösung
als "JobPosting" umgesetzt.

## Modelle
- User
- Company
- Category
- JobPosting

### Attribute User
- id
- usr_name
- eMail
- password
- role
- created_at
- updated_at

### Attribute Company
- id
- cmpny_name
- cmpny_description
- website
- cmpny_location
- created_at
- updated_at
- FK user_id

### Attribute Category
- id
- ctgry_name
- ctgry_description
- created_at
- updated_at

### Attribute JobPosting
- id
- title
- jp_description
- jp_location
- experience_level
- employment_type
- salary
- is_active
- created_at
- updated_at
- FK company_id
- FK category_id

## Rollen
- Admin
- provider / Anbietende
- applicant / Bewerbende

### Rechte/Policies Übersicht
- Jobposting sehen
- Jobposting erstellen
- Eigenes Jobpostings bearbeiten
- Fremde Jobposition bearbeiten
- Companies sehen
- Eigene Company bearbeiten
- Categories verwalten
- Users sehen
- User Rollen bearbeiten

#### Rechte/Policies ADMIN
- darf alles

#### Rechte/Policies provider/Anbietende
- Jobposting sehen
- Jobposting erstellen
- Eigenes Jobpostings bearbeiten
- Companies sehen
- Eigene Company bearbeiten

#### Rechte/Policies applicant/Bewerbende
- Jobposting sehen
- Companies sehen

## Visualisierung mit draw.io
- 260427_RDBM_TenMedia_CaseStudy
- 260427_Sitemap_Policies_TenMedia_CaseStudy
- 260427_ERD_TenMedia_CaseStudy



























