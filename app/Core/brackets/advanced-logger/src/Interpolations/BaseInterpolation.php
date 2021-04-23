<?php

namespace Brackets\AdvancedLogger\Interpolations;

use Brackets\AdvancedLogger\Contracts\InterpolationContract;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BaseInterpolation
 */
abstract class BaseInterpolation implements InterpolationContract
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Response
     */
    protected $response;

    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response): void
    {
        $this->response = $response;
    }

    /**
     * Escape string
     *
     * @param string $text
     * @return string
     */
    protected function escape(string $text): string
    {
        return preg_replace('/\s/', "\\s", $text);
    }

    /**
     * Convert array or null to string
     *
     * @param $value
     * @return string
     */
    protected function convertToString($value): string
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        if (is_null($value)) {
            $value = 'null';
        }
        return $value;
    }

    /**
     * @param int $bytes
     * @return string
     */
    protected function formatSizeUnits(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . 'GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . 'MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . 'KB';
        } elseif ($bytes > 1) {
            $bytes .= 'B';
        } elseif ($bytes === 1) {
            $bytes .= ' byte';
        } else {
            $bytes = '0B';
        }

        return $bytes;
    }
}
