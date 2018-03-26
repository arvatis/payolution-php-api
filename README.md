#  Payolution php api

Php implementatio of the payolution xml api.
To get started have a look at the phpunit integration tests (see folder tests/Integration).

## Tests

To run the unit tests execute 

```phpunit --exclude-group online```

To run tests agains the Payone API, set up your merchant credentials in the phpunit.ini file (see phpunit.ini.dist as 
reference for the field names).

Run ```phpunit```

## Changelog

See the [changelog](./CHANGELOG.md).