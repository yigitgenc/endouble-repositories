<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Example Model
 *
 * @package App
 */
class Example extends Model
{
    /**
     * @var array $fillable
     */
    protected $fillable = ['title', 'content', 'description'];

    /**
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * The id of the example
     *
     * @var integer $id
     */
    public $id;

    /**
     * The example title
     *
     * @var string $title
     */
    public $title;

    /**
     * The example content/description
     *
     * @var string $content
     */
    public $content;

    /**
     * The example description
     *
     * @var string $description
     */
    public $description;
}
