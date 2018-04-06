<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/01/2018
 * Time: 14:47
 */
namespace Gleandroj\Api\Support\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ApiResourceCollection extends ResourceCollection
{
    /**
     * The name of the resource being collected.
     *
     * @var string
     */
    public $collects;

    /**
     * The additional meta data that should be added to the resource response.
     *
     * Added during response construction by the developer.
     *
     * @var array
     */
    public $additional = [
        'success' => true
    ];

    /**
     * Create a new anonymous resource collection.
     *
     * @param  mixed $resource
     * @param  string $collects
     */
    public function __construct($resource, $collects)
    {
        $this->collects = $collects;

        parent::__construct($resource);
    }
}