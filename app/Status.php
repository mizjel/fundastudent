<?php

namespace App;

use App\Services\StatusServiceClass;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $timestamps = false;

    protected $fillable = ['status'];

    public static $statuses = [
        'in_progress' => 'in behandeling',
        'cancelled' => 'geannuleerd',
        'processed' => 'verwerkt',
        'verified' => 'geverifieerd',
        'unverified' => 'niet geverifieerd',
    ];

    const in_progress = 'in_progress';
    const cancelled = 'cancelled';
    const processed = 'processed';
    const verified = 'verified';
    const unverified = 'unverified';

    /**
     * @param $status
     * @return mixed
     * Get status->id for given status
     */
    public static function getStatusID($status){
        return Status::where('status', self::$statuses[$status])->firstOrFail()->id;
    }

    /**
     * @param $status
     * @return bool
     * return bool, has given status
     */
    public function hasStatus($status){
        return $this->status == self::$statuses[$status];
    }

}
