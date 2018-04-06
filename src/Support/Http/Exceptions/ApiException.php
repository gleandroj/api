<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23/10/2017
 * Time: 10:53
 */
namespace Gleandroj\Api\Support\Http\Exceptions;

class ApiException extends \Exception
{
    /**
     * @var int
     */
    private $httpCode;

    /**
     * @var string
     */
    private $error;
    
    /**
     * @var array
     */
    private $errors;

    /**
     * ApiException constructor.
     * @param string $error
     * @param string $message
     * @param int $httpCode
     * @param array $errors
     */
    public function __construct($error = '', $message = "", $httpCode = 400, $errors = [])
    {
        parent::__construct($message);
        $this->httpCode = $httpCode;
        $this->error = $error;
        $this->errors = $errors;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return int
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getJsonResponse(){
        return response()->json([
            'success' => false,
            'error' => $this->getError(),
            'message' => $this->getMessage(),
            'errors' => $this->errors
        ], $this->getHttpCode());
    }
}