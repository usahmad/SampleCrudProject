<?php
declare(strict_types=1);

namespace App\Models;
use Carbon\Carbon,
    Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @package App\Models
 *
 * @property int $id
 * @property string $title
 * @property string $measurement
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class Product extends Model
{
    use SoftDeletes;
    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'measurement'
    ];

    /**
     * @param array $params
     * @return bool
     */
    public function storeItem(array $params): bool
    {
        return $this->fill($params)->save();
    }

    public function getItems(array $params, $perPage = 15): LengthAwarePaginator
    {
        $items = self::query();
        if (isset($params['title']))
            $items = $items->where('title', 'like', '%'.$params['title'].'%');

        return $items->paginate($perPage);
    }

    public function getItem($id)
    {
        return self::query()->find($id);
    }

    public function getCreatedAt(): string
    {
        return $this->created_at->format('d-m-Y');
    }


}
