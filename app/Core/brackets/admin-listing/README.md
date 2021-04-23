# Admin Listing

AdminListing is a helper that simplifies administration listing for your Eloquent models. It helps transforming a typical request to data. It can auto-handle all the basic stuff like pagination, ordering, search. It can handle also translatable eloquent models (see [Translatable Eloquent Models](https://docs.brackets.sk/#/translatable#make-your-model-translatable)).

You can find full documentation at https://docs.getcraftable.com/#/admin-listing

## Testing

In order to run tests, this package requires a PostgreSQL database running (SQLite is not enough for this package). You can use one that is shipped with docker running:

```
docker-compose up -d
``` 

and then run tests:

```
./vendor/bin/phpunit
```

To stop the server use:

```
docker-compose down
```

## Issues
Where do I report issues?
If something is not working as expected, please open an issue in the main repository https://github.com/BRACKETS-by-TRIAD/craftable.