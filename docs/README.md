# Party Planner - Dokumentace

Tento adresář obsahuje projektovou dokumentaci pro aplikaci Party Planner.

## Struktura dokumentace

- `index.html` - Hlavní stránka dokumentace s přehledem projektu a týmu
- `party_planner_gantt.html` - Ganttův diagram projektu s časovým plánem

## GitLab Pages hosting

Dokumentace je automaticky nasazována na GitLab Pages při push do následujících větví:
- `main` - Hlavní dokumentace
- `ANALYTICAL` - Dokumentace analytické fáze
- `IMPLEMENTATION` - Dokumentace implementační fáze

## Přístup k dokumentaci

Po nasazení bude dokumentace dostupná na:
- **Hlavní dokumentace**: `https://[username].gitlab.io/pm2-partyplanner/`
- **Analytická větev**: `https://[username].gitlab.io/pm2-partyplanner/-/analytical/`
- **Implementační větev**: `https://[username].gitlab.io/pm2-partyplanner/-/implementation/`

## Jak přidat novou dokumentaci

1. Přidejte HTML soubory do tohoto adresáře (`docs/`)
2. Aktualizujte `index.html` s odkazy na nové dokumenty
3. Commitněte změny do příslušné větve
4. GitLab CI automaticky nasadí aktualizovanou dokumentaci

## Technické detaily

- Používá se GitLab CI/CD pipeline definovaná v `.gitlab-ci.yml`
- Dokumentace se nasazuje pomocí GitLab Pages
- Podporuje HTML, CSS a JavaScript
- Automatická validace HTML před nasazením
