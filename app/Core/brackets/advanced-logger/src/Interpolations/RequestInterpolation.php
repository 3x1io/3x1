<?php

namespace Brackets\AdvancedLogger\Interpolations;

use Carbon\Carbon;
use Illuminate\Support\Str;

/**
 * Class RequestInterpolation
 */
class RequestInterpolation extends BaseInterpolation
{
    /**
     * @param string $text
     * @return string
     */
    public function interpolate(string $text): string
    {
        $variables = explode(' ', $text);
        foreach ($variables as $variable) {
            $matches = [];
            preg_match("/{\s*(.+?)\s*}(\r?\n)?/", $variable, $matches);
            if (isset($matches[1])) {
                $value = $this->escape($this->resolveVariable($matches[0], $matches[1]));
                $text = str_replace($matches[0], $value, $text);
            }
        }
        return $text;
    }

    /**
     * @param string $raw
     * @param string $variable
     * @return string
     */
    protected function resolveVariable(string $raw, string $variable): string
    {
        $method = str_replace([
            'remoteAddr',
            'scheme',
            'port',
            'queryString',
            'remoteUser',
            'referrer',
            'body',
            'query',
            'user',
        ], [
            'ip',
            'getScheme',
            'getPort',
            'getQueryString',
            'getUser',
            'referer',
            'getContent',
            'getQuery',
            'getUser',
        ], Str::camel($variable));

        $serverVariable = str_replace([
            'ACCEPT',
            'ACCEPT_CHARSET',
            'ACCEPT_ENCODING',
            'ACCEPT_LANGUAGE',
            'HOST',
            'REFERER',
            'USER_AGENT',
        ], [
            'HTTP_ACCEPT',
            'HTTP_ACCEPT_CHARSET',
            'HTTP_ACCEPT_ENCODING',
            'HTTP_ACCEPT_LANGUAGE',
            'HTTP_HOST',
            'HTTP_REFERER',
            'HTTP_USER_AGENT'
        ], strtoupper(str_replace('-', '_', $variable)));

        if (method_exists($this, $method)) {
            return $this->convertToString($this->$method());
        }

        if (method_exists($this->request, $method)) {
            return $this->convertToString($this->request->$method());
        }

        if (isset($_SERVER[$serverVariable])) {
            return $this->convertToString($this->request->server($serverVariable));
        }

        $matches = [];
        preg_match("/([-\w]{2,})(?:\[([^\]]+)\])?/", $variable, $matches);
        if (count($matches) === 2) {
            switch ($matches[0]) {
                case 'date':
                    $matches[] = 'clf';
                    break;
            }
        }
        if (is_array($matches) && count($matches) === 3) {
            [$line, $var, $option] = $matches;
            switch (strtolower($var)) {
                case 'date':
                    $formats = [
                        'clf' => Carbon::now()->format('d/M/Y:H:i:s O'),
                        'iso' => Carbon::now()->toIso8601String(),
                        'web' => Carbon::now()->toRfc1123String()
                    ];
                    return $formats[$option] ?? Carbon::now()->format($option);
                case 'req':
                case 'header':
                    return $this->convertToString($this->request->header(strtolower($option)));
                case 'server':
                    return $this->convertToString($this->request->server($option));
                default:
                    return $raw;
            }
        }
        return $raw;
    }

    /**
     * @return string
     */
    protected function getQuery(): string
    {
        $query = $this->request->query();
        $queryString = '[';
        foreach ($query as $key => $value) {
            if (is_array($value)) {
                $queryString .= $key . '=>[],';
            } else {
                $queryString .= $key . '=>' . $value . ',';
            }
        }
        $queryString = trim($queryString, ',');
        $queryString .= ']';
        return $queryString;
    }

    /**
     * @return mixed
     */
    protected function getUser(): ?string
    {
        if (!is_null($this->request->user()) && !is_null($this->request->user()->email)) {
            return $this->request->user()->email;
        } else {
            return null;
        }
    }
}
