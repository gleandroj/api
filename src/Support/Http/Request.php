<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/01/2018
 * Time: 10:26
 */
namespace Gleandroj\Api\Support\Http;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public abstract function authorize();

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public abstract function rules();
}