<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\Response;

class ListToHtml implements ListInterface
{
    public function addHeaders(Response $response)
    {
        $response->headers->set('Content-Type', 'text/html');
    }

    public function addHead(): ?string
    {
        return '<!DOCTYPE HTML>
<html><head></head><body><table>';
    }

    public function addTail(): ?string
    {
        return '</table></body></html>';
    }

    public function addRow($data): ?string
    {
        $result = '<tr>';
        foreach ($data as $key => $value) {
            $result .= '<td>' . ($value ?? '&nbsp;') . '</td>';
        }
        $result .= '</tr>';

        return $result;
    }

    public function addTitleRow($data): ?string
    {
        $result = '<tr>';
        foreach ($data as $key => $value) {
            $result .= '<th>' . $value . '</th>';
        }
        $result .= '</tr>';

        return $result;
    }
}