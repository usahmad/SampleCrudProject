<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property string $role
 *
 */
class Permission extends Model
{
    protected $fillable = [
        'route_name',
        'user_id'
    ];


    public function storeRoles(array $route_names,int $user_id): bool
    {
        $data = [];
        foreach ($route_names as $route_name){
            $data[] = compact('route_name', 'user_id');
        }
        self::query()->where('user_id', '=', $user_id)->delete();
        return self::query()->insert($data);
    }
}
