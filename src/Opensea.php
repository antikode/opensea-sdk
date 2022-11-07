<?php

namespace Antikode\Opensea;

use Illuminate\Support\Facades\Http;

class Opensea extends ResponseMessage
{
    protected static function get_request($parameter, $isV2 = false)
    {
        try {
            if ($isV2) {
                $version = 'v2';
            } else {
                $version = 'api/v1';
            }
            $url = 'https://api.opensea.io/'.$version;
            $client = Http::withHeaders([
                'X-API-KEY' => config('opensea.key'),
            ])->baseUrl($url)->get($parameter);
            return $client->json();
        } catch (\Exception $e) {
            return self::error_response($e->getMessage(), $e->getCode());
        }
    }

    public static function getListings($tokenId, $contractAddr = null)
    {

        if ($contractAddr == null) {
            $contractAddr = config('opensea.contract_address');
        }
        $array = [
            'asset_contract_address' => $contractAddr,
            'token_ids' => $tokenId,
            'order_by' => 'created_date',
            'order_direction' => 'desc',
        ];
        $query = http_build_query($array);
        $get = self::get_request('/orders/ethereum/seaport/listings?'.$query, true);
        return $get;
    }

    public static function getOffers($tokenId, $contractAddr = null)
    {

        if ($contractAddr == null) {
            $contractAddr = config('opensea.contract_address');
        }
        $array = [
            'asset_contract_address' => $contractAddr,
            'token_ids' => $tokenId,
            'order_by' => 'created_date',
            'order_direction' => 'desc',
        ];
        $query = http_build_query($array);
        $get = self::get_request('/orders/ethereum/seaport/offers?'.$query, true);
        return $get;
    }

    public static function get_collection($collection = null)
    {
        if ($collection == null) {
            $collection = config('opensea.collection');
        }
        $get = self::get_request('/collection/'.$collection);
        return $get;
    }

    public static function get_collection_stat($collection = null)
    {
        if ($collection == null) {
            $collection = config('opensea.collection');
        }
        $get = self::get_request('/collection/'.$collection.'/stats');
        return $get;
    }

    public static function validate_owner($wallet, $token_id = null, $collection = null)
    {
        if ($collection == null) {
            $collection = config('opensea.collection');
        }

        $array = [
            'owner' => $wallet,
            'token_ids' => $token_id,
            'collection' => $collection,
            'order_direction' => 'desc',
            'limit' => 20,
            'include_orders' => 'false'
        ];
        $query = http_build_query($array);
        $get = self::get_request('/assets?'.$query);
        if (count($get['assets']) > 0) {
            if ($token_id != null) {
                $asset = $get['assets'][0];
                $valid = [
                    'token_exist' => true,
                    'token_id' => $asset['token_id'],
                    'total_token' => count($get['assets']),
                    'metadata' => [
                        'img' => $asset['image_url'],
                        'name' => $asset['name'],
                        'description' => $asset['description'],
                        'owner' => $asset['owner'],
                        'traits' => $asset['traits']
                    ]
                ];
            } else {
                $valid = [
                    'token_exist' => true,
                    'total_token' => count($get['assets']),
                ];
            }
        } else {
            $valid = [
                'token_exist' => false,
                'token_id' => null,
                'metadata' => null
            ];
        }
        return self::success_response($valid, 200);
    }
}
