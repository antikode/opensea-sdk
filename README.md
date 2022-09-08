# OpenSea SDK

This package will help you to integrate Opensea API to your Laravel Project or PHP Project

## Features

- Get Collection
- Get Collection Statistic
- Validate NFT Owner by TokenID

## Installation

Install the package in your Laravel Project.

```sh
composer require antikode/opensea-sdk
```

## Usage

#### Publish configuration :
Before initializing the package, make sure you have publish the configuration file by typing the code below.
```sh
php artisan vendor:publish --tag=opensea-config
```

#### Environment:
You need to define the API at your .env file.
```env
OPENSEA_APIKEY=[opensea api key]
OPENSEA_COLLECTION=[the collection slug from opensea]
```

#### Get Collection
This function is used to retrieve more in-depth information about an individual collection, including real time statistics such as floor price.
```php
$collection = 'moondogz-official';
$opensea = Opensea::get_collection($collection);
return $opensea;
```
The variable collection was an optional if you have declare the OPENSEA_COLLECTION in the .env file. 

#### Get Collection Statistic
This function can be used to fetch stats for a specific collection, including real-time floor price data.
```php
$collection = 'moondogz-official';
$opensea = Opensea::get_collection_stat($collection);
return $opensea;
```
The variable collection was an optional if you have declare the OPENSEA_COLLECTION in the .env file. 

#### Get Collection Statistic
This function is used to fetch information about a single NFT, based on its contract address and token ID. The response will contain an Asset Object.
```php
$wallet = '0x4f14d3d1D3D95cd54Aa2812cAC3ce729dD8CDcf0';
$opensea = Opensea::validate_owner($wallet, null, 'moondogz-official');
return $opensea;
```
The variable collection was an optional if you have declare the OPENSEA_COLLECTION in the .env file. The second parameter was the field to put the tokenID of the NFT's.
