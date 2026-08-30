# ADR-0001: Liberu module package naming

- Status: accepted
- Date: 2026-08-24

## Context

Liberu cross-product capabilities are independently released Composer packages
and must remain unambiguous when installed alongside product modules. The
documentation requires the `module-` prefix for module repositories, Composer
package basenames, and installed module directories. Presentation adapters are
one-to-one with their core module.

## Decision

Use the following stable naming pattern for new Liberu packages:

- core: `liberusoftware/module-liberu-{capability}`
- API: `liberusoftware/module-liberu-{capability}-api`
- Filament: `liberusoftware/module-liberu-{capability}-filament`
- Livewire: `liberusoftware/module-liberu-{capability}-livewire`

The matching installer names omit the vendor prefix but retain the module
prefix. Each adapter depends only on its matching core package's public
boundary. No application `App\\` classes are package dependencies.

## Consequences

Package repositories, Composer metadata, module manifests, namespaces, release
tags, and documentation links must use this mapping consistently. Existing
packages with historical names require an explicit migration release and are
not silently renamed by this ADR.
