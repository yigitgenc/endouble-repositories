<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Vacancy Model
 *
 * @package App
 */
class Vacancy extends Model
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
     * The id of the vacancy
     *
     * @var integer $id
     */
    public $id;

    /**
     * The vacancy title
     *
     * @var string $title
     */
    public $title;

    /**
     * The vacancy content/description
     *
     * @var string $content
     */
    public $content;

    /**
     * The vacancy description
     *
     * @var string $description
     */
    public $description;
}
