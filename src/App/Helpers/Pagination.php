<?php

namespace App\Helpers;

use Psr\Http\Message\ServerRequestInterface;

class Pagination
{
    /** @var ServerRequestInterface  */
    private $request;

    /** @var string  */
    private $paramName= 'page';

    /** @var int */
    private $currentPage = 1;

    /** @var int  */
    private $pageSize = 3;

    /** @var int  */
    private $countItems = 0;

    /**
     * Pagination constructor.
     * @param ServerRequestInterface $request
     * @param int $countItems
     */
    public function __construct(ServerRequestInterface $request, int $countItems = 0)
    {
        $this->request = $request;

        $params = $request->getQueryParams();
        $this->setCurrentPage(isset($params[$this->paramName]) ? (int) $params[$this->paramName] : 1);
        $this->setCount($countItems);
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @param int $value
     */
    public function setCurrentPage(int $value): void
    {
        $this->currentPage = $value;
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return ($this->currentPage - 1) * $this->pageSize;
    }

    /**
     * @param int $value
     */
    public function setCount(int $value): void
    {
        $this->countItems = $value;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->countItems;
    }

    /**
     * @return int
     */
    public function getCountPages(): int
    {
        return ceil($this->countItems / $this->pageSize);
    }

    /**
     * @param int $number
     * @return string
     */
    public function getCurrentPageUri(int $number): string
    {
        $params = $this->request->getQueryParams();
        $params[$this->paramName] = $number;

        $query = [];
        foreach ($params as $key => $value) {
            $query[] = "{$key}={$value}";
        }

        return $this->request->getUri()->withQuery(implode('&', $query))->__toString();
    }
}