<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseService
{
    /** @var bool */
    private $success;

    private $content;

    /** @var int */
    private $status;

    public function __construct(bool $success, $content, int $status = Response::HTTP_OK)
    {
        $this->success = $success;
        $this->content = $content;
        $this->status = $status;
    }

    public function getResponse(): JsonResponse
    {
        $response = [
            'success' => $this->success,
            'content' => $this->content
        ];

        return new JsonResponse($response, $this->status);
    }
}