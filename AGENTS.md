# AGENTS.md

## Project Context

Dit project is een custom WordPress / WooCommerce plugin voor **trefik.nl**.
De plugin wordt gebruikt om uiteenlopende onderdelen van de webshop functioneel en visueel te customizen.

De plugin bevat ook een integratie met de **Wixmo API**.
Wixmo is een ELP waarin via trefik.nl aangeschafte pakketten verwerkt of gekoppeld kunnen worden.

## Scope

Werk **uitsluitend** binnen deze plugin.

- Pas nooit WordPress core aan
- Pas nooit WooCommerce core aan
- Pas nooit andere plugins aan
- Pas nooit het actieve theme aan, tenzij daar expliciet om gevraagd wordt
- Maak geen wijzigingen buiten deze plugin-map
- Focus alleen op code die direct relevant is voor de gevraagde wijziging

## Architecture

Volg altijd de bestaande architectuur van deze plugin.

### Autoloading

- De autoloader staat in `./src/Autoloader.php`
- Deze autoloader laadt alle classes en namespaces vanuit `./includes`
- Houd bij nieuwe classes en namespaces altijd rekening met deze autoload-structuur
- Gebruik geen losse `require` of `include` statements voor classes als dat via de bestaande autoloader opgelost hoort te worden

### Coding Standards

Volg altijd:

- **PSR-4** voor namespaces en class loading
- **PSR-12** voor formatting en code style

Aanvullend:

- Houd classes klein en logisch gescheiden
- Gebruik duidelijke verantwoordelijkheden per class
- Behoud bestaande naamgeving en structuur waar mogelijk
- Refactor alleen als dat echt nodig is voor de taak

## WordPress / WooCommerce Best Practices

Bij iedere wijziging:

- Werk op een WordPress-native manier
- Gebruik hooks, filters, actions en WooCommerce extensiepunten waar passend
- Vermijd harde overrides als een hook/filter mogelijk is
- Houd rekening met compatibiliteit en onderhoudbaarheid

### Security

Pas altijd de juiste WordPress security-principes toe:

- Sanitize input
- Escape output
- Controleer capabilities waar nodig
- Gebruik nonces bij state-changing acties
- Vertrouw nooit direct op ruwe `$_POST`, `$_GET`, `$_REQUEST` of externe API-data

## Wixmo API Integration

Deze plugin bevat een integratie met de **Wixmo API**.

Belangrijke uitgangspunten:

- Breek bestaande Wixmo-koppelingen niet
- Respecteer bestaande request flows, authenticatie en payload-structuren
- Wijzig Wixmo-gerelateerde logica alleen als dat direct onderdeel is van de opdracht
- Houd API-code gescheiden van WooCommerce- of UI-logica waar mogelijk
- Voeg logging en foutafhandeling zorgvuldig toe wanneer relevant
- Maak geen aannames over API responses zonder de bestaande implementatie te volgen

Als je Wixmo-gerelateerde code aanpast:

- Controleer eerst welke classes/services hier al voor bestaan
- Hergebruik bestaande API-lagen, helpers of clients
- Voeg geen dubbele integratielaag toe als er al een patroon aanwezig is

## Working Style

Bij iedere taak:

1. Bepaal eerst welke bestanden echt aangepast moeten worden
2. Houd wijzigingen zo klein en gericht mogelijk
3. Pas alleen relevante bestanden aan
4. Behoud bestaande structuur tenzij expliciet om refactor gevraagd wordt
5. Licht kort toe welke bestanden gewijzigd worden voordat grotere wijzigingen worden gedaan

## Preferred Approach

Geef voorkeur aan:

- Kleine, gerichte wijzigingen
- Hergebruik van bestaande classes en helpers
- Duidelijke class- en namespace-structuur
- Oplossingen die passen binnen de bestaande plugin-architectuur
- Onderhoudbare en voorspelbare code

Vermijd:

- Grote onnodige rewrites
- Nieuwe abstractielagen zonder duidelijke noodzaak
- Logica dupliceren
- Hidden side effects in WooCommerce checkout, cart, order of account flows

## File / Code Awareness

Let extra goed op bij wijzigingen in code die invloed kan hebben op:

- WooCommerce checkout
- Winkelwagenlogica
- Orderverwerking
- Productdata
- Gebruikersaccounts
- API-koppelingen met Wixmo
- Hooks die sitebreed gedrag beïnvloeden

Wijzig dit soort code alleen doelgericht en voorzichtig.

## Output Expectations

Wanneer je code genereert of wijzigt:

- Lever production-minded code
- Houd code PSR-12 netjes opgemaakt
- Zorg dat namespaces en class-locaties PSR-4-consistent zijn
- Sluit aan op de bestaande autoloader in `./src/Autoloader.php`
- Voeg alleen nieuwe bestanden toe als dat echt nodig is
- Voeg geen overbodige comments toe
- Gebruik korte, functionele toelichtingen waar nodig

## Summary

Dit is een custom plugin voor trefik.nl met WooCommerce-customizations en een Wixmo API-integratie.

Belangrijkste regels:

- Werk alleen binnen deze plugin
- Volg PSR-4 en PSR-12
- Respecteer de autoloader in `./src/Autoloader.php`
- Classes en namespaces worden geladen vanuit `./includes`
- Gebruik WordPress / WooCommerce best practices
- Houd wijzigingen klein, veilig en gericht
- Behoud de Wixmo-integratie en bestaande architectuur