# Liberu Accounting Core

Accounting Core is the provider-neutral boundary for legal entities and the accounting foundation shared by Liberu applications. It owns its persistence and does not depend on application `App\\` classes or presentation frameworks.

## Installation

```bash
composer require liberusoftware/module-accounting-core
```

The package provides `Liberu\\Accounting\\Core\\AccountingCoreServiceProvider`, its module manifest, a typed accounting-basis enum, a currency-code value object, and the legal-entity migration/model. API, Filament, and Livewire adapters are separate packages and must depend on this package's public boundary.

## Compatibility

PHP 8.5 · Laravel 13 · Composer 2 · MIT

## Scope

The package also owns books, fiscal calendars, numbering sequences, defaults, policies, and the legal-entity creation event behind this independently versioned boundary. No presentation adapter may bypass these domain rules.
