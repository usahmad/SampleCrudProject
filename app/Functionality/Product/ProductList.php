<?php


namespace App\Functionality\Product;


use App\Interfaces\ListInterface;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ProductList implements ListInterface
{
    const PRODUCT_LIST = 'product@title={key}@page={key}';
    const PRODUCT = 'product@id={key}';

    public static $measurements = array('liter', 'kg', 'gr', 'piece');

    public static function getInstance(): ProductList
    {
        return new self();
    }

    public function getList($request)
    {
        $cacheKey = Str::replaceArray(
            '{key}',
            [
                $request->input('title'),
                (0 === (int)$request->query('page')) ? 1 : (int)$request->query('page')
            ],
            self::PRODUCT_LIST
        );
        $cache = Cache::tags('product')->get($cacheKey);
        if (is_null($cache)){
            $cache = (new Product())->getItems($request->all());
            Cache::tags('product')->put($cacheKey, $cache, now()->addDay());
        }
        return $cache;
    }

    public function getListItem($id) : Product
    {
        $cacheKey = Str::replaceArray(
            '{key}',
            [
                $id
            ],
            self::PRODUCT
        );
        $cache = Cache::tags('product')->get($cacheKey);
        if (is_null($cache)){
            $cache = (new Product())->getItem($id);
            Cache::tags('product')->put($cacheKey, $cache, now()->addDay());
        }

        return $cache;
    }
}
