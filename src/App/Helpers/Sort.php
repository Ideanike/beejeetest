<?php


namespace App\Helpers;


use Psr\Http\Message\ServerRequestInterface;
use ReflectionClass;
use ReflectionException;

class Sort
{
    /** @var ServerRequestInterface  */
    private $request;

    /** @var string  */
    private $paramFieldName = 'sort-field';
    /** @var string  */
    private $paramDirectionName = 'sort-direction';

    /** @var string  */
    private $currentField;
    /** @var string */
    private $currentDirection;

    /** @var string */
    private $entityClass;

    /**
     * Sort constructor.
     * @param ServerRequestInterface $request
     * @param string $entityClass
     */
    public function __construct(ServerRequestInterface $request, string $entityClass)
    {
        $this->request = $request;
        $this->entityClass = $entityClass;
        $params = $request->getQueryParams();
        $this->currentField = $params[$this->paramFieldName] ?? '';
        $this->currentDirection = $params[$this->paramDirectionName] ?? 'ASC';
    }

    /**
     * @return array|string[]|null
     * @throws ReflectionException
     */
    public function getSort(): ?array
    {
        if (empty($this->currentField)) {
            return null;
        }

        if (empty($this->currentDirection)) {
            return null;
        }

        if (!in_array(strtoupper($this->currentDirection), ['ASC', 'DESC'])) {
            return null;
        }

        if (!in_array($this->currentField, $this->getEntityProperties(), true)) {
            return null;
        }

        return [
            $this->currentField => $this->currentDirection
        ];
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    private function getEntityProperties(): array
    {
        $properties = [];
        $reflect = new ReflectionClass(new $this->entityClass);
        $reflectProperties = $reflect->getProperties();
        foreach ($reflectProperties as $reflectProperty) {
            $properties[] = $reflectProperty->getName();
        }

        return $properties;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getSortFieldUri(string $name): string
    {
        $params = $this->request->getQueryParams();
        $params[$this->paramFieldName] = $name;

        if (isset($params[$this->paramDirectionName]) && strtoupper($params[$this->paramDirectionName]) === 'ASC') {
            $params[$this->paramDirectionName] = 'DESC';
        } else {
            $params[$this->paramDirectionName] = 'ASC';
        }

        $query = [];
        foreach ($params as $key => $value) {
            $query[] = "{$key}={$value}";
        }

        return $this->request->getUri()->withQuery(implode('&', $query))->__toString();
    }
}