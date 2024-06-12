# Dokumentace projektu webové aplikace "Joohle"

## Úvod
"Joohle" je webová aplikace pro vytváření a vyplňování testů postavená na frameworku CodeIgniter 4. Tato dokumentace popisuje rozdělení práce mezi členy týmu, použití externích nástrojů, popisy metod v kontrolerech, vlastní knihovny a konfigurační proměnné.

## Rozdělení práce

### Michal Hlúch
- Návrh metod a kontrolérů
- Vytvoření vzorových souborů
- Přihlašovací systém
- Správa kategorií
- Správa uživatelů

### Martin Jagoš
- Vytvoření databázového schématu
- Testovací záznamy databáze
- Systém testů
- Zobrazování testů
- Správa testů, otázek a odpovědí

## Použité externí nástroje

1. **CodeIgniter 4**
   - Název knihovny: CodeIgniter
   - Verze knihovny: 4.x
   - Autor knihovny: British Columbia Institute of Technology
   - Licence knihovny: MIT License
   - [Link na knihovnu: CodeIgniter](https://codeigniter.com)

2. **Ion Auth**
   - Název knihovny: Ion Auth
   - Verze knihovny: 4.x
   - Autor knihovny: Ben Edmunds
   - Licence knihovny: MIT License
   - [Link na knihovnu: Ion Auth](https://github.com/benedmunds/CodeIgniter-Ion-Auth)

3. **jQuery**
   - Název knihovny: jQuery
   - Verze knihovny: 3.7.1
   - Autor knihovny: The jQuery Foundation
   - Licence knihovny: MIT License
   - [Link na knihovnu: jQuery](https://jquery.com)

4. **jQuery Validation Plugin**
   - Název knihovny: jQuery Validation Plugin
   - Verze knihovny: 1.20.0
   - Autor knihovny: The jQuery Foundation
   - Licence knihovny: MIT License
   - [Link na knihovnu: jQuery Validation Plugin](https://jqueryvalidation.org)

5. **Bootstrap 5**
   - Název knihovny: Bootstrap
   - Verze knihovny: 5.x
   - Autor knihovny: Twitter Inc.
   - Licence knihovny: MIT License
   - [Link na knihovnu: Bootstrap](https://getbootstrap.com)

## Popis metod v kontrolerech

### AuthController

- `initController()`
  - Inicializuje kontroler, nastavuje knihovnu IonAuth a načítá konfiguraci IonAuth. Tato metoda je volána při každém požadavku na tento kontroler.

- `login()`
  - Zobrazí přihlašovací formulář. Vrací pohled `auth/login` s titulem "Login".

- `register()`
  - Zobrazí registrační formulář. Předává do pohledu minimální délku hesla a titul "Registration".

- `loginComplete()`
  - Zpracovává odeslaný přihlašovací formulář. Přijímá uživatelské jméno, heslo a případně informaci o zapamatování uživatele. Pokud jsou přihlašovací údaje správné, přesměruje uživatele na hlavní stránku, jinak zobrazí chybovou zprávu a vrátí uživatele zpět na přihlašovací stránku.

- `registerComplete()`
  - Zpracovává odeslaný registrační formulář. Přijímá uživatelské jméno, jméno, příjmení, email a heslo. Poté vytvoří nového uživatele pomocí IonAuth knihovny. Pokud registrace proběhne úspěšně, přesměruje uživatele na hlavní stránku.

- `registerUsername()`
  - Zpracovává požadavek na kontrolu dostupnosti uživatelského jména. Kontroluje, zda je uživatelské jméno podle požadavků a vrací odpovídající odpověď.

- `registerEmail()`
  - Zpracovává požadavek na kontrolu dostupnosti emailu. Kontroluje, zda je email podle požadavků a vrací odpovídající odpověď.

- `logout()`
  - Odhlásí uživatele. Zavolá metodu `logout` z knihovny IonAuth, přesměruje uživatele na přihlašovací stránku a zobrazí potvrzovací zprávu o úspěšném odhlášení.

### TestController

- `index()`
  - Zobrazí seznam všech testů, pokud je uživatel přihlášen.
  - Načte testy, kategorie a pager (stránkování).
  - Pokud není uživatel přihlášen, přesměruje na stránku pro přihlášení.

- `categoryRender()`
  - Zobrazí testy v konkrétní kategorii.
  - Načte kategorii podle ID, testy v této kategorii a pager (stránkování).
  - Nastaví titulek stránky na základě názvu kategorie.

- `test()`
  - Zobrazí detaily konkrétního testu.
  - Načte test podle ID, pokusy uživatele o tento test, obtížnost testu a další informace.
  - Nastaví titulek stránky na základě názvu testu.

- `testPassword()`
  - Zkontroluje, zda zadané heslo odpovídá heslu testu.
  - Pokud je heslo správné, uloží do session pokus o test a čas pokusu a přesměruje na stránku s pokusem.
  - Pokud je heslo nesprávné, přesměruje zpět na stránku s detailem testu.

- `testFree()`
  - Uloží do session pokus o test a čas pokusu.
  - Přesměruje na stránku s pokusem.

- `testAttempt()`
  - Zobrazí otázky testu pro aktuální pokus.
  - Načte test a otázky (podle nastavení, zda mají být promíchány).
  - Zkontroluje, zda uživatel začal pokus o tento test, pokud ne, přesměruje zpět na stránku s detailem testu.

- `testComplete()`
  - Uloží výsledky pokusu o test.
  - Načte odpovědi uživatele, spočítá získané body a maximální možné body.
  - Uloží výsledky do databáze a odstraní informace o pokusu ze session.
  - Přesměruje zpět na stránku s detailem testu.

### DashboardController

- `index()`
  - Zobrazí dashboard s informacemi o počtu uživatelů, pokusů, testů a kategorií.
  - Načte uživatele, pokusy, testy a kategorie, které nejsou smazány.

- `users()`
  - Zobrazí seznam všech uživatelů.
  - Načte všechny uživatele a zobrazí je na stránce dashboardu.

- `tests()`
  - Zobrazí seznam všech testů.
  - Načte všechny testy, které nejsou smazány, a zobrazí je na stránce dashboardu.

- `editTest()`
  - Zobrazí formulář pro editaci konkrétního testu.
  - Načte test podle ID, obtížnosti, otázky a odpovědi.

- `updateTest()`
  - Aktualizuje konkrétní test s novými údaji z formuláře.
  - Načte nové údaje z formuláře a aktualizuje test v databázi.
  - Přesměruje na seznam testů v dashboardu.

- `deleteTest()`
  - Označí konkrétní test jako smazaný.
  - Nastaví datum smazání u testu, otázek a odpovědí a aktualizuje je v databázi.
  - Přesměruje na seznam testů v dashboardu.

- `addTest()`
  - Zobrazí formulář pro přidání nového testu.
  - Načte obtížnosti a zobrazí je ve formuláři.

- `createTest()`
  - Vytvoří nový test s údaji z formuláře.
  - Načte nové údaje z formuláře a vloží nový test do databáze.
  - Přesměruje na seznam testů v dashboardu.

- `createQuestion()`
  - Vytvoří novou otázku a odpověď pro konkrétní test.
  - Načte nové údaje z formuláře a vloží novou otázku a odpověď do databáze.
  - Přesměruje na stránku pro editaci testu.

- `deleteQuestion()`
  - Označí konkrétní otázku a její odpovědi jako smazané.
  - Nastaví datum smazání u otázky a odpovědí a aktualizuje je v databázi.
  - Přesměruje na stránku pro editaci testu.

- `deleteUser()`
  - Smaže konkrétního uživatele.
  - Smaže uživatele z databáze.
  - Přesměruje na seznam uživatelů v dashboardu.

- `editUser()`
  - Zobrazí formulář pro editaci konkrétního uživatele.
  - Načte údaje o uživateli a zobrazí je ve formuláři.

- `updateUser()`
  - Aktualizuje údaje o konkrétním uživateli s novými údaji z formuláře.
  - Načte nové údaje z formuláře a aktualizuje uživatele v databázi.
  - Přesměruje na dashboard.

- `updateGroups()`
  - Aktualizuje skupiny, do kterých uživatel patří.
  - Načte aktuální a nové skupiny uživatele a aktualizuje je v databázi.

- `categories()`
  - Zobrazí seznam všech kategorií.
  - Načte všechny kategorie, které nejsou smazány, a zobrazí je na stránce dashboardu.

- `editCategory()`
  - Zobrazí formulář pro editaci konkrétní kategorie.
  - Načte kategorii podle ID a zobrazí ji ve formuláři.

- `updateCategory()`
  - Aktualizuje konkrétní kategorii s novými údaji z formuláře.
  - Načte nové údaje z formuláře a aktualizuje kategorii v databázi.
  - Přesměruje na seznam kategorií v dashboardu.

- `addCategory()`
  - Zobrazí formulář pro přidání nové kategorie.
  - Načte a zobrazí titulní údaje pro formulář.

- `createCategory()`
  - Vytvoří novou kategorii s údaji z formuláře.
  - Načte nové údaje z formuláře a vloží novou kategorii do databáze.
  - Přesměruje na seznam kategorií v dashboardu.

- `deleteCategory()`
  - Označí konkrétní kategorii jako smazanou.
  - Nastaví datum smazání u kategorie a aktualizuje ji v databázi.
  - Přesměruje na seznam kategorií v dashboardu.

- `attempts()`
  - Zobrazí seznam všech pokusů.
  - Načte všechny pokusy a zobrazí je na stránce dashboardu.

- `deleteAttempt()`
  - Označí konkrétní pokus jako smazaný.
  - Nastaví datum smazání u pokusu a aktualizuje ho v databázi.
  - Přesměruje na seznam pokusů v dashboardu.

## Závěr
Tato dokumentace poskytuje přehled o struktuře a funkcionalitě aplikace "Joohle", rozdělení práce v týmu, použití externích nástrojů, popis metod a konfigurací. V případě jakýchkoli dotazů nebo problémů se obraťte na příslušného člena týmu dle rozdělení práce.
