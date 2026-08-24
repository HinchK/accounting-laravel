# Liberu Accounting Core

Accounting Core is the provider-neutral boundary for legal entities and the accounting foundation shared by Liberu applications. It owns its persistence and does not depend on application `App\\` classes or presentation frameworks.

## Installation

```bash
composer require liberusoftware/accounting-core
```

The package provides `Liberu\\Accounting\\Core\\AccountingCoreServiceProvider`, its module manifest, a typed accounting-basis enum, a currency-code value object, and the legal-entity migration/model. API, Filament, and Livewire adapters are separate packages and must depend on this package's public boundary.

## Compatibility

PHP 8.5 · Laravel 13 · Composer 2 · MIT

## Scope

The remaining Accounting Core capabilities—books, fiscal calendars, numbering, defaults, policies, and domain events—are being added behind this same independently versioned boundary. No presentation adapter may bypass these domain rules.
