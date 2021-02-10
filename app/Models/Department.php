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
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class Department extends Model
{
    use SoftDeletes;
    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
    ];

    /**
     * @param array $params
     * @return bool
     */
    public function storeItem(array $params): bool
    {
        return $this->fill($params)->save();
    }

    public function getItems(array $params, int $perPage = 15): LengthAwarePaginator
    {
        $items = self::query();
        if (isset($params['title']))
            $items = $items->where('title', 'like', '%'.$params['title'].'%');

        return $items->paginate($perPage);
    }

    public function getItem(int $id)
    {
        return self::query()->find($id);
    }

    public function getCreatedAt(): string
    {
        return $this->created_at->format('d-m-Y');
    }


}
