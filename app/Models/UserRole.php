<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserRole
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property string $role
 *
 */
class UserRole extends Model
{
    protected $fillable = [
        'role',
        'user_id'
    ];


    public function storeRoles(array $roles,int $user_id): bool
    {
        $data = [];
        foreach ($roles as $role){
            $data[] = compact('role', 'user_id');
        }
        self::query()->where('user_id', '=', $user_id)->delete();
        return self::query()->insert($data);
    }
}
