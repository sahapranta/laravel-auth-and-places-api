# Spacenus GmbH Assignment

![Test](https://github.com/sahapranta/laravel-auth-and-places-api/actions/workflows/laravel.yml/badge.svg)

This assignment is to setup laravel REST API for Authentication and retrieving places within a 5km radius using Google Map API that takes Latitude and Longitude as url params.

## Installation

-   Clone the repository
-   Run `composer install`
-   Copy .env.example to .env
-   Run `php artisan migrate --seed`
-   Run `php artisan serve`

#### Use this credential if seeded using default seeder while migration

```bash
  "email":"test@example.com",
  "password":"password"
```

## Routes

| Method | Route      | Controller                  |
| ------ | ---------- | --------------------------- |
| GET    | api/places | Api\PlaceController         |
| GET    | api/user   | Api\AuthController@user     |
| POST   | api/signup | Api\AuthController@register |
| POST   | api/login  | Api\AuthController@login    |
| POST   | api/logout | Api\AuthController@logout   |

For simplicity sqlite is used as database, if needed change it to mysql from .env


## Testing

-   Run `php artisan test`

<br/>
<br/>


# API Documentation

### Get Places

Retrieves a list of places based on latitude and longitude coordinates.

#### Request

`GET /api/places?lat=51.5074&long=-0.1278&radius=5000`

#### Query Parameters

| Parameter | Type   | Description                                 |
| --------- | ------ | ------------------------------------------- |
| lat       | number | Latitude coordinate of the location         |
| long      | number | Longitude coordinate of the location        |
| radius    | number | (Optional) Radius in meters (default: 5000) |

### Response

-   Status Code: `200 OK`

#### Example Response Body

```json
{
    "results": ["Place 1", "Place 2", "Place 3"]
}
```
<br/>

### Login
#### Request

`POST /api/login`

#### Request Body
`email, password`

### Response

-   Status Code: `200 OK`

#### Example Response Body

```json
{
    "token": "1|okamKQ4M8Nb9bTL2jC218HxTdbArip30k4SL5Xal"
}
```

-   Status Code: `401 Unauthorized` if the email or password is incorrect.
<br/>

### Register
#### Request

`POST /api/signup`

#### Request Body

`name,email,password`

#### Example Response Body

```json
{
    "token": "1|okamKQ4M8Nb9bTL2jC218HxTdbArip30k4SL5Xal"
}
```
