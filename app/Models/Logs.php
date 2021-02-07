<?php
declare(strict_types=1);

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property string $message
 * @property int $ip
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read User $user
 */
class Logs extends Model
{
    public function getItems(array $params): LengthAwarePaginator
    {
        $items = self::query();
        if (isset($params['user_id']))
            $items = $items->where('user_id', '=', $params['user_id']);
        if (isset($params['message']))
            $items = $items->where('message', 'like','%'.$params['message'].'%');
        if (isset($params['ip']))
            $items = $items->where('ip', '=', ip2long($params['ip']));

        return $items->with('user')->orderByDesc('id')->paginate(50);
    }

    public function store($user_id,$message,$ip)
    {
        try {
            $logs = new self();
            $logs->user_id = $user_id;
            $logs->message = $message;
            $logs->ip = ip2long($ip);
            $logs->save();
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function storeItem(array $params): bool
    {
        return self::query()->insert($params);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
    public function getUser(): string
    {
        return $this->user->name;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return long2ip($this->ip);
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at->format('d-m-Y H:i:s');
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at->format('d-m-Y H:i:s');
    }

}
