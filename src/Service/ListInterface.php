<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\Response;

interface ListInterface
{
    /**
     * Add some headers for response
     * @param Response $response
     * @return mixed
     */
    public function addHeaders(Response $response);

    /**
     * Add title to first line of table if possible
     * @param $data
     * @return string|null
     */
    public function addTitleRow($data): ?string;

    /**
     * Add data element
     * @param $data
     * @return string|null
     */
    public function addRow($data): ?string;

    /**
     * Add first part of response
     * @return string|null
     */
    public function addHead(): ?string;

    /**
     * Add last part of response
     * @return string|null
     */
    public function addTail(): ?string;
}