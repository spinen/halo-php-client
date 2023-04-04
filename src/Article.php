<?php

namespace Spinen\Halo;

use Carbon\Carbon;
use Spinen\Halo\Support\Model;

/**
 * Class Article
 *
 * @property Carbon $date_created
 * @property Carbon $date_edited
 * @property Carbon $next_review_date
 * @property int $id
 * @property int $inactive
 * @property int $notuseful_count
 * @property int $type
 * @property int $useful_count
 * @property int $view_count
 * @property string $description
 * @property string $kb_tags
 * @property string $name
 * @property string $tag_string
 * @property string $use
 */
class Article extends Model
{
    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'date_created';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'date_edited';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_created' => 'datetime',
        'date_edited' => 'datetime',
        'next_review_date' => 'datetime',
    ];

    /**
     * Path to API endpoint.
     */
    protected string $path = '/kbarticle';
}
