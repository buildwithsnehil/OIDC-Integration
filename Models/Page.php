<?php

namespace OIDCIntegration\Models;

use OIDCIntegration\Model;
use OIDCIntegration\Users\Models\HasCreatorAndUpdater;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int      $id
 * @property string   $pageview
 * @property string   $text
 * @property int|null $parent_id  - Relates to local_id, not id
 * @property int      $created_by
 * @property int      $updated_by
 */
class Page extends Model implements Loggable
{
    use HasFactory;
    use HasCreatorAndUpdater;

    protected $fillable = ['text', 'endpoint'];
    protected $appends = ['created', 'updated'];

    /**
     * Get the entity that this page belongs to.
     */
    public function entity(): MorphTo
    {
        return $this->morphTo('entity');
    }

    /**
     * Check if a page has been updated since creation.
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
