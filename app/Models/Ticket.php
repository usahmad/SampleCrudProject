<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Ticket
 * @package App\Models
 *
 * @property int $id
 * @property int $priority
 * @property int $department_id
 * @property string $assignment
 * @property string $initiator
 * @property string $theme
 * @property string $executedBy
 * @property string $markingComment
 * @property Carbon $execution_period
 * @property Carbon $execution_actual
 * @property Carbon $delay
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $delete_at
 */
class Ticket extends Model
{

    use SoftDeletes;


    protected $fillable = [
        'priority',
        'department_id',
        'assignment',
        'initiator',
        'theme',
        'executedBy',
        'markingComment',
        'execution_period',
        'execution_actual',
        'delay',
    ];

    /**
     * @param array $params
     * @param int $paginate
     * @return LengthAwarePaginator
     */
    public function getItems(array $params, int $paginate = 50): LengthAwarePaginator
    {
        $items = self::query();

        if (isset($params['priority']))
            $items = $items->where('priority', '=', $params['priority']);

        if (isset($params['department_id']))
            $items = $items->where('department_id', '=', $params['department_id']);

        if (isset($params['assignment']))
            $items = $items->where('assignment', 'like', '%' . $params['assignment'] . '%');

        if (isset($params['initiator']))
            $items = $items->where('initiator', 'like', '%' . $params['initiator'] . '%');

        if (isset($params['theme']))
            $items = $items->where('theme', 'like', '%' . $params['theme'] . '%');

        if (isset($params['executedBy']))
            $items = $items->where('executedBy', 'like', '%' . $params['executedBy'] . '%');

        if (isset($params['execution_period_from']))
            $items = $items->where('execution_period', '<=', Carbon::make($params['execution_period_from']));

        if (isset($params['execution_period_to']))
            $items = $items->where('execution_period', '>=', Carbon::make($params['execution_period_to']));

        if (isset($params['execution_actual_from']))
            $items = $items->where('execution_actual', '<=', Carbon::make($params['execution_actual_from']));

        if (isset($params['execution_actual_to']))
            $items = $items->where('execution_actual', '>=', Carbon::make($params['execution_actual_to']));

        if (isset($params['delay_from']))
            $items = $items->where('delay', '<=', Carbon::make($params['delay_from']));

        if (isset($params['delay_to']))
            $items = $items->where('delay', '>=', Carbon::make($params['delay_to']));

        if (isset($params['created_from']))
            $items = $items->where('created_at', '<=', Carbon::make($params['created_from']));

        if (isset($paramsp['created_to']))
            $items = $items->where('created_at', '>=', Carbon::make($params['created_to']));

        if (isset($params['isTrashed']))
            $items = $items->withTrashed();

        return $items->with('department')->paginate($paginate);

    }

    public function getItem(int $id)
    {
        return self::query()->find($id);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function storeItem(array $data): bool
    {
        return $this->fill($data)->save();
    }

    /**
     * Relations
     *
     * @return BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Getters
     *
     *
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPriority(): string
    {
        return $this->priority;
    }

    /**
     * @return int
     */
    public function getDepartmentId(): int
    {
        return $this->department_id;
    }

    /**
     * @return string
     */
    public function getAssignment(): string
    {
        return $this->assignment;
    }

    /**
     * @return string
     */
    public function getInitiator(): string
    {
        return $this->initiator;
    }

    /**
     * @return string
     */
    public function getTheme(): string
    {
        return $this->theme;
    }

    /**
     * @return string
     */
    public function getExecutedBy(): string
    {
        return $this->executedBy;
    }

    /**
     * @return string
     */
    public function getMarkingComment(): string
    {
        return $this->markingComment;
    }

    /**
     * @return Carbon
     */
    public function getExecutionPeriod(): Carbon
    {
        return $this->execution_period;
    }

    /**
     * @return Carbon
     */
    public function getExecutionActual(): Carbon
    {
        return $this->execution_actual;
    }

    /**
     * @return Carbon
     */
    public function getDelay(): Carbon
    {
        return $this->delay;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }


}
