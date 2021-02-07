<?php


namespace App\Functionality\Product;

use App\Interfaces\StoreInterface;
use App\Models\Logs;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ProductStore implements StoreInterface
{
    private $rules = [
        'title',
        'measurement'
    ];

    public static function getInstance(): ProductStore
    {
        return new self();
    }

    public function store(array $params): int
    {
        $validator = Validator::make($params, $this->rules);
        if ($validator->fails())
            return 422;

        (new Product())->storeItem($validator->getData());
        Cache::tags('product')->flush();
        (new Logs())->store(auth()->user()->id, 'product created', request()->ip());

        return 200;
    }

    public function update(array $params, $id)
    {
        $validator = Validator::make($params, $this->rules);

        if ($validator->fails())
            return 422;

        try {
            ProductList::getInstance()
                ->getListItem($id)
                ->storeItem($validator->getData());
            Cache::tags('product')->flush();
            (new Logs())->store(auth()->user()->id, 'product update', request()->ip());

        } catch (\Exception $exception) {
            return [
                $exception->getMessage(),
                $exception->getLine(),
            ];
        }

        return 200;
    }

    public function delete($id): int
    {
        try {
            ProductList::getInstance()->getListItem($id)->delete();
            (new Logs())->store(auth()->user()->id, 'product deleted', request()->ip());
            Cache::tags('product')->flush();
            return 200;
        } catch (\Exception $e) {
            return 500;
        }
    }
}
