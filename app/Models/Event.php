<?php

namespace App\Models;

use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'status',
        'created_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
            'status' => EventStatus::class,
        ];
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // Note: Auto status update is now disabled to allow manual status changes.
        // Use Event::updateAllStatuses() via scheduled command if needed.
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the user (admin) who created this event.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ==================== SCOPES ====================

    /**
     * Scope a query to only include upcoming events.
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('status', EventStatus::UPCOMING);
    }

    /**
     * Scope a query to only include completed events.
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', EventStatus::COMPLETED);
    }

    /**
     * Scope a query to only include past events (alias for completed).
     */
    public function scopePast(Builder $query): Builder
    {
        return $query->where('event_date', '<', now()->toDateString());
    }

    /**
     * Scope a query to only include ongoing events.
     */
    public function scopeOngoing(Builder $query): Builder
    {
        return $query->where('status', EventStatus::ONGOING);
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeByStatus(Builder $query, EventStatus $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to search by title or description.
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%");
        });
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeByDateRange(Builder $query, ?string $from, ?string $to): Builder
    {
        if ($from) {
            $query->where('event_date', '>=', $from);
        }
        if ($to) {
            $query->where('event_date', '<=', $to);
        }
        return $query;
    }

    /**
     * Scope a query to filter events this month.
     */
    public function scopeThisMonth(Builder $query): Builder
    {
        return $query->whereMonth('event_date', now()->month)
            ->whereYear('event_date', now()->year);
    }

    // ==================== ACCESSORS ====================

    /**
     * Get formatted event date.
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->event_date->translatedFormat('d F Y');
    }

    /**
     * Get formatted time range.
     */
    public function getFormattedTimeAttribute(): string
    {
        $start = $this->start_time->format('H:i');
        $end = $this->end_time->format('H:i');
        return "{$start} - {$end}";
    }

    /**
     * Get full formatted datetime.
     */
    public function getFullDateTimeAttribute(): string
    {
        return $this->formatted_date . ' • ' . $this->formatted_time;
    }

    /**
     * Get status badge HTML.
     */
    public function getStatusBadgeAttribute(): string
    {
        return sprintf(
            '<span class="%s">%s</span>',
            $this->status->badgeClass(),
            $this->status->label()
        );
    }

    /**
     * Check if event is upcoming.
     */
    public function getIsUpcomingAttribute(): bool
    {
        return $this->event_date->isFuture() || $this->event_date->isToday();
    }

    /**
     * Check if event is in the past.
     */
    public function getIsPastAttribute(): bool
    {
        return $this->event_date->isPast() && !$this->event_date->isToday();
    }

    // ==================== METHODS ====================

    /**
     * Update event status based on current date/time.
     */
    public function updateStatusIfNeeded(): void
    {
        $today = now()->toDateString();
        $eventDate = $this->event_date->toDateString();

        // Skip if already completed
        if ($this->status === EventStatus::COMPLETED) {
            return;
        }

        $newStatus = null;

        if ($eventDate < $today) {
            $newStatus = EventStatus::COMPLETED;
        } elseif ($eventDate === $today) {
            $newStatus = EventStatus::ONGOING;
        } else {
            $newStatus = EventStatus::UPCOMING;
        }

        if ($newStatus && $this->status !== $newStatus) {
            $this->status = $newStatus;
            $this->saveQuietly();
        }
    }

    /**
     * Manually mark event as completed.
     */
    public function markAsCompleted(): void
    {
        $this->status = EventStatus::COMPLETED;
        $this->save();
    }

    /**
     * Static method to update all event statuses.
     */
    public static function updateAllStatuses(): int
    {
        $count = 0;

        // Mark past events as completed
        $count += self::where('event_date', '<', now()->toDateString())
            ->where('status', '!=', EventStatus::COMPLETED)
            ->update(['status' => EventStatus::COMPLETED]);

        // Mark today's events as ongoing
        $count += self::where('event_date', now()->toDateString())
            ->where('status', EventStatus::UPCOMING)
            ->update(['status' => EventStatus::ONGOING]);

        return $count;
    }
}
