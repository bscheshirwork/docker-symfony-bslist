<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\Response;

/**
 * Add simple plain structure
 * Class ListToXml
 * @package App\Service
 */
class ListToXml implements ListInterface
{
    public function addHeaders(Response $response)
    {
        $response->headers->set('Content-Type', 'text/xml');
    }

    public function addHead(): ?string
    {
        return '<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE list><list>';
    }

    public function addTail(): ?string
    {
        return '</list>';
    }

    public function addRow($data): ?string
    {
        //plain data representation for place
        $result = '<place>';
        foreach ($data as $key => $value) {
            $result .= '<' . $key . '>' . $value . '</' . $key . '>';
        }
        $result .= '</place>';

        return $result;
    }

    public function addTitleRow($data): ?string
    {
        return null;
    }
}