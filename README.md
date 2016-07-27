# terra-monitoring-web-rest [![codecov](https://codecov.io/gh/terra-monitoring/terra-monitoring-web-rest/branch/master/graph/badge.svg)](https://codecov.io/gh/terra-monitoring/terra-monitoring-web-rest)
## Autoren
- Andre Trogisch
- Christian Zöller

## Installation
- `git clone https://github.com/terra-monitoring/terra-monitoring-web-rest.git`
- `cd terra-monitoring-web-rest`
- `vagrant up`
- `vagrant ssh`
- `cd /vagrant/sources`
- `composer install`

Der erste Aufruf der API kann Datenbankfehler liefern, da die sqlite-Datenbank dann erst erstellt wird.

## Adressen
- [swagger.json](http://terra.vm/docs/swagger.json) http://terra.vm/docs/swagger.json
- [SwaggerUI](http://terra.vm/docs/swagger) http://terra.vm/docs/swagger
