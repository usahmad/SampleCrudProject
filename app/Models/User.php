<?php
declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $password
 * @property string $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @property-read Permission $permissions
 *
 */
class User extends Authenticatable
{

    use Notifiable, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'password',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function hasPermission($routeName): bool
    {
        return in_array($routeName, $this->permissions->pluck('route_name')->toArray());
    }

    public function getPermissions()
    {
        return $this->permissions->pluck('route_name')->toArray();
    }

    /**
     * @param array $request
     * @param int $paginate
     * @return LengthAwarePaginator
     */
    public function getItems(array $request, int $paginate = 15): LengthAwarePaginator
    {
        $items = self::query();
        if (isset($request['name'])) {
            $items = $items->where('name', 'like', '%' . $request['name'] . '%');
        }
        return $items->with('permissions')->paginate($paginate);
    }

    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getItem(int $id)
    {
        return self::query()->find($id);
    }

    /**
     * @param $params
     * @return array|int
     */
    public function storeItem(array $params)
    {
        DB::beginTransaction();
        try {
            $this->name = $params['name'];
            if (isset($params['password']))
                $this->password = Hash::make($params['password']);
            if ($this->save()){
                (new Permission())->storeRoles($params['permissions'], $this->id);
            }

            DB::commit();
            return $this->id;
        }catch (\Exception $exception){
            DB::rollBack();
            return [
                $exception->getMessage(),
                $exception->getLine()
            ];
        }
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at->format('d-m-Y');
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at->format('d-m-Y');
    }
}
