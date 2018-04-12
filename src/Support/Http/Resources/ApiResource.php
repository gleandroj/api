<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/01/2018
 * Time: 14:46
 */
namespace Gleandroj\Api\Support\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;

class ApiResource extends Resource
{
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
     * Create new anonymous resource collection.
     *
     * @param  mixed $resource
     * @return ApiResourceCollection
     */
    public static function collection($resource)
    {
        return new ApiResourceCollection($resource, get_called_class());
    }

    /**
     * @param Carbon $carbon
     * @return string
     */
    public function formatCarbonDate(Carbon $carbon)
    {
        return $carbon->format(Model::DATE_FORMAT);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        $value = parent::__get($key);
        if ($value instanceof Carbon) {
            return $this->formatCarbonDate($value);
        } else {
            return $value;
        }
    }
}