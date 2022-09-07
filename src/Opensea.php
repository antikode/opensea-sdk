<?php

namespace Masitings\Opensea;

use Illuminate\Support\Facades\Http;

class Opensea extends ResponseMessage
{
    public static function get_request($parameter)
    {
        try {
            $client = Http::withHeaders([
                'X-API-KEY' => config('opensea.key'),
            ])->baseUrl('https://api.opensea.io/api/v1')->get($parameter);
            return self::success_response($client->json(), $client->status());
        } catch (\Exception $e) {
            return self::error_response($e->getMessage(), $e->getCode());
        }

    }

    public static function get_collection_by_slug($collection, $others = '')
    {
        $get = self::get_request('/collection/'.$collection.$others);
        return $get;
    }

    public static function get_collection_stat_by_slug($collection)
    {
        $get = self::get_collection_by_slug($collection, '/stats');
        return $get;
    }
}
