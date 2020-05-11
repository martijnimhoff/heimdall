<?php

namespace App\Models;

use Goutte\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\Crawler;

/**
 * App\Models\Watcher
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $url
 * @property string|null $css_selector
 * @property bool $is_enabled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Scan[] $scans
 * @property-read int|null $scans_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Trigger[] $triggers
 * @property-read int|null $triggers_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Watcher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Watcher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Watcher query()
 * @mixin \Eloquent
 */
class Watcher extends Model
{
    const COL_ID = 'id';
    const COL_USER_ID = 'user_id';
    const COL_NAME = 'name';
    const COL_URL = 'url';
    const COL_CSS_SELECTOR = 'css_selector';
    const COL_IS_ENABLED = 'is_enabled';
    const COL_CREATED_AT = 'created_at';
    const COL_UPDATED_AT = 'updated_at';

    const REL_TRIGGERS = 'triggers';
    const REL_SCANS = 'scans';
    const REL_USER = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::COL_USER_ID,
        self::COL_NAME,
        self::COL_URL,
        self::COL_CSS_SELECTOR,
        self::COL_IS_ENABLED,
    ];

    /*******************************
     * Relationships
     *******************************/

    public function triggers(): HasMany
    {
        return $this->hasMany(Trigger::class);
    }

    public function scans(): HasMany
    {
        return $this->hasMany(Scan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*******************************
     * public utility methods
     *******************************/

    public function makeScan(): Scan
    {
        $client = new Client();

        /**
         * Get the page
         */
        $crawler = $client->request('GET', $this->{self::COL_URL});

        /**
         * Build the scan
         */
        $value = '';
        $crawler->filter($this->{self::COL_CSS_SELECTOR})
            ->each(function (Crawler $node) use (&$value) {
                $value .= $node->text();
            });

        /**
         * Create and return the scan
         */
        return Scan::create([
            Scan::COL_WATCHER_ID => $this->{self::COL_ID},
            Scan::COL_VALUE      => $value,
        ]);
    }

    /**
     * @param Scan $scan
     * @return Collection|Hit[]
     */
    public function checkTriggers(Scan $scan): Collection
    {
        /** @var Collection|Trigger[] $triggers */
        $triggers = $this->{self::REL_TRIGGERS}
            ->where(Trigger::COL_IS_ENABLED, true);

        $hits = collect([]);
        foreach ($triggers as $trigger) {
            if ($hit = $trigger->checkHit($scan)) {
                $hits[] = $hit;
            }
        }

        return $hits;
    }
}
