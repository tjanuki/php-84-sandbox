<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use DateTime;
use InvalidArgumentException;

class Document extends Model
{
    use SoftDeletes;

    protected $casts = [
        'metadata' => 'array',
        'change_history' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'last_viewed_at' => 'datetime',
    ];

    protected $fillable = [
        'title',
        'content',
        'metadata',
        'change_history',
        'version',
        'is_published',
        'published_at',
        'last_viewed_at',
    ];

    // Custom accessor for formatted title
    public string $displayTitle {
        get => ucfirst($this->title);
        set {
            if (empty($value)) {
                throw new InvalidArgumentException("Title cannot be empty");
            }

            if (strlen($value) > 255) {
                throw new InvalidArgumentException("Title cannot exceed 255 characters");
            }

            $this->trackChange('title', $this->title, $value);
            $this->title = $value;
        }
    }

    // Custom accessor for formatted content
    public string $displayContent {
        get => $this->content;
        set {
            if (empty($value)) {
                throw new InvalidArgumentException("Content cannot be empty");
            }

            $this->trackChange('content', $this->content, $value);
            $this->content = $value;
            $this->version = ($this->version ?? 0) + 1;
        }
    }

    // Computed word count property
    public int $wordCount {
        get => str_word_count(strip_tags($this->content ?? ''));
    }

    // Read time estimate in minutes
    public int $estimatedReadTime {
        get => (int) ceil($this->wordCount / 200);
    }

    // Document status property
    public string $documentStatus {
        get => $this->is_published ? 'published' : 'draft';
        set {
            if (!in_array($value, ['draft', 'published'])) {
                throw new InvalidArgumentException("Invalid status. Must be 'draft' or 'published'");
            }

            $this->is_published = ($value === 'published');
            if ($this->is_published && !$this->published_at) {
                $this->published_at = now();
            }
        }
    }

    /**
     * Track changes to the document
     */
    private function trackChange(string $field, $oldValue, $newValue): void
    {
        $history = $this->change_history ?? [];
        $history[] = [
            'field' => $field,
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'user_id' => Auth::id(),
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'version' => $this->version ?? 1
        ];
        $this->change_history = $history;
    }

    /**
     * Record a view of the document
     */
    public function recordView(): void
    {
        $this->last_viewed_at = now();
        $this->save();
    }

    /**
     * Get the change history
     */
    public function getChangeHistory(): array
    {
        return $this->change_history ?? [];
    }
}
