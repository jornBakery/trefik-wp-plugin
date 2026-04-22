# AGENTS.md

## Project Context

Dit project is een custom WordPress / WooCommerce plugin voor **trefik.nl**.

De plugin wordt gebruikt om functionaliteit, gedrag en presentatie van de webshop te customizen.
Daarnaast bevat de plugin een integratie met de **Wixmo API**.

Wixmo is een ELP waarin via trefik.nl aangeschafte pakketten verwerkt, gekoppeld of geactiveerd kunnen worden.

---

## Scope

Werk **uitsluitend binnen deze plugin**.

NIET toegestaan:
- WordPress core aanpassen
- WooCommerce core aanpassen
- Andere plugins aanpassen
- Themes aanpassen
- Bestanden buiten deze plugin wijzigen
- Serverconfiguratie wijzigen
- Database-schema direct aanpassen zonder expliciete opdracht

---

## Repository Structure Awareness

Deze plugin heeft meerdere functionele domeinen. Houd altijd rekening met de bestaande structuur.

Belangrijke onderdelen:
- `tref-ik.php` → plugin bootstrap / constants / initialisatie
- `src/Autoloader.php` → autoloader
- `includes/Admin` → admin functionaliteit
- `includes/Ajax` → AJAX handlers
- `includes/Core` → kernlogica / bootstrap / helpers / config
- `includes/Frontend` → frontend hooks / rendering
- `includes/Shortcodes` → shortcodes
- `includes/Integrations/WooCommerce` → WooCommerce integraties
- `includes/Integrations/Wixmo` → Wixmo API integratie
- `includes/Integrations/Elementor` → Elementor gerelateerde integratie
- `includes/Integrations/Curl` → request/transport gerelateerde code

Werk altijd binnen het meest logische domein.
Voeg geen code toe in een willekeurige map als daar al een bestaande structuur voor bestaat.

---

## Active Code Awareness

Ga **nooit automatisch ervan uit** dat een bestaande class ook daadwerkelijk actief gebruikt wordt.

Controleer altijd eerst:
- of de class ergens geïnstantieerd wordt
- of de class via `register_hooks()` wordt gekoppeld
- of de class via `includes/Core/Plugin.php` of andere bootstrap-logica wordt geladen
- of de code legacy / commented-out / ongebruikt is

Gebruik bestaande actieve codepaden als bron van waarheid.

Behandel:
- commented-out code
- oude experimenten
- ongebruikte classes
- legacy implementaties

als **niet-actief**, tenzij expliciet anders gevraagd.

---

## Architecture

### Autoloading

- De autoloader staat in `./src/Autoloader.php`
- De namespace root is `Trefik\`
- Classes worden geladen vanuit `./includes`

Regels:
- Gebruik PSR-4 namespaces
- Namespace en bestandspad moeten exact op elkaar aansluiten
- Plaats nieuwe classes in `/includes`
- Gebruik geen handmatige `require` of `include` voor classes
- Respecteer de bestaande namespace-structuur

Voorbeeld:
- `Trefik\Core\Plugin` → `includes/Core/Plugin.php`
- `Trefik\Ajax\CartAjaxHandler` → `includes/Ajax/CartAjaxHandler.php`

---

## Coding Standards

Verplicht:
- PSR-4
- PSR-12

Aanvullend:
- Kleine, duidelijke classes
- Single responsibility per class
- Geen onnodige abstractie
- Geen onnodige nieuwe service-lagen
- Bestaande structuur behouden waar mogelijk
- Geen grote refactors tenzij expliciet gevraagd

---

## WordPress / WooCommerce Best Practices

- Gebruik hooks, filters en actions
- Gebruik WooCommerce extensiepunten
- Vermijd overrides als hooks mogelijk zijn
- Gebruik WordPress-native patronen
- Respecteer lifecycle van requests, cart, checkout, sessions en order creation

Wanneer code checkout, cart of order flow raakt:
- wees extra defensief
- voorkom side effects
- maak wijzigingen minimaal en gericht

---

## Security

Altijd toepassen:
- Sanitize input
- Escape output
- Gebruik nonces
- Check capabilities
- Vertrouw nooit direct op `$_GET`, `$_POST`, `$_REQUEST`, `$_COOKIE` of externe API data
- Log nooit gevoelige data ongefilterd

---

## Secrets / Credentials / Configuration

Voeg **nooit** secrets, client secrets, access tokens, bearer tokens, API keys of wachtwoorden toe aan versioned plugin code.

Verboden:
- hardcoded credentials in PHP files
- secrets in constants binnen de plugin
- logging van tokens of gevoelige request headers

Voorkeur:
- configuratie buiten de codebase
- `wp-config.php`
- environment variables
- beveiligde settings-opslag wanneer expliciet gewenst

Als bestaande code al hardcoded secrets bevat:
- breid dat patroon niet verder uit
- stel liever een migratie naar veilige configuratie voor
- behoud backward compatibility tenzij expliciet om wijziging gevraagd wordt

---

## Wixmo API Integration

- Breek bestaande Wixmo integratie NIET
- Gebruik bestaande API classes, base classes, clients en response/error patronen
- Respecteer bestaande request flows
- Respecteer authenticatie en payloadstructuren
- Maak geen dubbele API implementaties
- Activeer geen legacy of commented-out Wixmo code zonder expliciete opdracht

Bij wijzigingen:
- analyseer eerst welke Wixmo-klassen al actief gebruikt worden
- hergebruik bestaande lagen
- houd API logica gescheiden van UI en WooCommerce presentatie
- voeg foutafhandeling zorgvuldig toe
- laat Wixmo-fouten niet onnodig kritische WooCommerce flows blokkeren, tenzij dat functioneel vereist is

---

## AJAX Handling

Voor AJAX code:
- controleer altijd op nonce waar relevant
- valideer input altijd
- sanitize alle inkomende data
- gebruik consistente JSON responses
- houd rekening met requests van niet-ingelogde gebruikers indien van toepassing
- check WooCommerce cart/session beschikbaarheid voordat cart logica wordt uitgevoerd
- voorkom fatals in AJAX endpoints

---

## Working Style

Bij elke taak:

1. Bepaal welke bestanden echt aangepast moeten worden
2. Controleer of het actieve codepaden betreft
3. Houd wijzigingen klein en gericht
4. Werk alleen in relevante bestanden
5. Houd bootstrap- en hookregistratie in gedachten
6. Licht bij grotere wijzigingen kort toe welke bestanden geraakt worden

---

## Kritische onderdelen

Wees extra voorzichtig met:
- plugin bootstrap
- checkout flow
- winkelwagen
- orders
- productdata
- AJAX handlers
- user accounts
- Wixmo API calls
- classes die hooks registreren
- globale filters / sitebrede hooks

---

## Output Expectations

- Productieklare code
- PSR-12 formatting
- Correcte namespaces
- Compatibel met de autoloader
- Geen overbodige comments
- Geen duplicate logic
- Geen aannames dat ongebruikte code actief is
- Geen nieuwe secrets in code

---

## Summary

- Werk alleen binnen deze plugin
- Volg PSR-4 en PSR-12
- Respecteer `src/Autoloader.php`
- Namespace root is `Trefik\`
- Classes staan in `/includes`
- Controleer altijd of code actief gebruikt wordt
- Respecteer bootstrap en hookregistratie
- Breek WooCommerce checkout/cart/order flow niet
- Breek Wixmo integratie niet
- Voeg nooit secrets toe aan de codebase
- Houd wijzigingen klein, veilig en gericht