# slim-example


**Note:** PHP >= 8.0 is required


This is an example api written using slim and php-di.  PSR-12 coding standards are used. A repository domain model pattern is used where the data is statically provided for example simplicity.


## Overview

Routing and middleware are wired in corresponding files in `config/`.

Bootstrapping is done in `public/index.php`

Models, repositories, middleware, and controller are in `src/`

The authentication requires a key, which currently is set to `testkey`.

## Asks

### Requirement
An API using the Slim framework (PHP 7.4 or greater)

#### Solution
Project completed with PHP 8.0.9 and Slim 4.8.1

--

### Requirement
Create a couple endpoints for fetching some dummy data (doesn't matter what)

#### Solution
The following endpoints were created.

```
/items/id/{id}
/items/name/{name}
/items/out-of-stock
/items/organic
```
--

### Requirement
Create Controller class(es) for the endpoints.

#### Solution
A controller was created at `src/Controller/InventoryController.php`

Actions for each endpoint is defined as methods in the controller.

--

### Requirement
Create a repository interface and concrete class to use for fetching applicable data for endpoint(s). You don't need to use a DB connection they can simply use static data from an array. The return type from repository method(s) should a domain model for the entity you are returning. Include some logic in the repository class so that you can fetch different data based on criteria. For example if you have a method defined like getFooById(int $id) have a few data elements in there that would allow a user to pass a valid id and get back the appropriate data.

#### Solution
A repository interface is created.  A repository that gets data from a static array is made to implement the interface.  Several methods are created to retrieve data and return models.

--

### Requirement
To secure the endpoint(s) assume there is a secret key passed in each request that gets verified, otherwise the user can not access the endpoint(s). You can create a static hash (and store it somewhere in the code for this). There should be a class that's responsible for taking the requestor's token and verifying that it is valid.

#### Solution
An authentication middleware is created that checks for a key, performs a sha1 on the key, then checks it against a statically defined hash.

--

### Requirement
Set up/import a DI container in Slim to inject dependencies into the Controller(s)

#### Solution
php-di is used for DI.  The controller receives the repository via DI.

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

### Get list items that are out of stock
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