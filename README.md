# Readify-Api

## Installation

When the container is mounted, exec in the container the following command to setup the JWT token of the API:

```bash
php bin/console lexik:jwt:generate-keypair
php bin/console assets:install
```
