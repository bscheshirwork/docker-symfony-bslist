<?php


namespace App\Service;


use Symfony\Component\HttpKernel\Exception\HttpException;

class ListFactory
{
    public function getListFormatter($format): ListInterface
    {
        if (class_exists($className = ('App\Service\ListTo' . ucfirst($format)))) {
            return new $className;
        }
        throw new HttpException('400', 'Unacceptable format');
    }
}