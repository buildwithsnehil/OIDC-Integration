<?php

namespace OIDCIntegration\Models;

use OIDCIntegration\Model;
use OIDCIntegration\Users\Models\HasCreatorAndUpdater;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int      $id
 * @property string   $name
 * @property string   $endpoint
 * @property string   $events
 * @property boolean  $active
 * @property int      $timeout
 */
class Webhook extends Model implements Loggable
{
    use HasFactory;
    use HasCreatorAndUpdater;

    protected $fillable = ['texnamet', 'endpoint'];
    protected $appends = ['created', 'updated'];

    /**
     * Get the entity that this webhook belongs to.
     */
    public function entity(): MorphTo
    {
        return $this->morphTo('entity');
    }

    /**
     * Check if a webhook has been updated since creation.
     */
    public function isUpdated(): bool
    {
        return $this->updated_at->timestamp > $this->created_at->timestamp;
    }

    /**
     * Get created date as a relative diff.
     */
    public function getCreatedAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get updated date as a relative diff.
     */
    public function getUpdatedAttribute(): string
    {
        return $this->updated_at->diffForHumans();
    }
}
