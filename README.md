# slim-example


**Note:** PHP >= 8.0 is required


This is an example api written using slim and php-di.  PSR-12 coding standards are used. A repository domain model pattern is used where the data is statically provided for example simplicity.


## Overview

Routing and middleware are wired in corresponding files in `config/`.

Bootstrapping is done in `public/index.php`

Models, repositories, middleware, and controller are in `src/`

The authentication requires a key, which currently is set to `testkey`.

## Examples

### Authentication not found
```
$ curl localhost:8001/
{"error":"Not Authorized"}
```

### Invalid request
```
$ curl localhost:8001/?key=testkey
{"error":"Not found."}
```

### Get inventory item by ID
```
$ curl localhost:8001/items/id/4?key=testkey
{
    "id": 4,
    "name": "cucumber",
    "quantity": 1,
    "organic": true
}
```

### Get inventory item by name
```
$ curl localhost:8001/items/name/tomato?key=testkey
{
    "id": 2,
    "name": "tomato",
    "quantity": 2,
    "organic": true
}
```

### Get list of organic items
```
$ curl localhost:8001/items/organic?key=testkey
[
    {
        "id": 0,
        "name": "onion",
        "quantity": 3,
        "organic": true
    },
    {
        "id": 2,
        "name": "tomato",
        "quantity": 2,
        "organic": true
    },
    {
        "id": 4,
        "name": "cucumber",
        "quantity": 1,
        "organic": true
    },
    {
        "id": 8,
        "name": "kiwi",
        "quantity": 0,
        "organic": true
    }
]
```

### Get items that are out of stock
```
$ curl localhost:8001/items/out-of-stock?key=testkey
[
    {
        "id": 1,
        "name": "potato",
        "quantity": 0,
        "organic": false
    },
    {
        "id": 8,
        "name": "kiwi",
        "quantity": 0,
        "organic": true
    },
    {
        "id": 10,
        "name": "mango",
        "quantity": 0,
        "organic": false
    }
]
```
