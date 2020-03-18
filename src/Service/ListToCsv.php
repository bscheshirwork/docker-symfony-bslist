<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\Response;


/**
 * simple write csv-friendly lines
 * Class ListToCsv
 * @package App\Service
 */
class ListToCsv implements ListInterface
{
    public function addHeaders(Response $response)
    {
        $response->headers->set('Content-Type', 'text/csv');
    }

    public function addHead(): ?string
    {
        return null;
    }

    public function addTail(): ?string
    {
        return null;
    }

    public function addRow($data): ?string
    {
        $result = '';
        foreach ($data as $key => $value) {
            $result .= '"' . str_replace('"', '""', $value) . '";';
        }
        $result .= PHP_EOL;

        return $result;
    }

    public function addTitleRow($data): ?string
    {
        $result = '';
        foreach ($data as $key => $value) {
            $result .= '"' . $value . '";';
        }
        $result .= PHP_EOL;

        return $result;
    }
}