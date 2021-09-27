<?php
namespace App\Controllers;


abstract class BaseApiController implements ApiControllerInterface
{
    protected array $request_params;

    /**
     * @param array $request_params
     */
    public function setRequestParams(array $request_params): void
    {
        $this->request_params = $request_params;
    }
}