<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\Contracts\DocumentosRepositoryInterface;

class DocumentosService
{
    private $repo;

    public function __construct(DocumentosRepositoryInterface $DocumentosRepository)
    {
        $this->repo = $DocumentosRepository;
    }

    public function findAll(array $params = null)
    {
//        // remove extra spaces and empty elements in array $params
//        $params = array_filter(array_map('trim', preg_replace("/\s+/", ' ', $params)), 'strlen');

        $result = $this->repo->findAll($params);

        return $result;
    }

    public function findFilter(array $params = null)
    {
        $result = $this->repo->findFilter($params);
        return $result;
    }

    public function fetchAuxiliarTable($modelName, array $params = null)
    {
        $result = $this->repo->fetchAuxiliarTable($modelName, $params);
        return $result;
    }

    public function pregReplaceArray($pattern, $replacement, $subject, $limit=-1)
    {
        if (is_array($subject)) {
            foreach ($subject as &$value){
                $value = $this->pregReplaceArray($pattern, $replacement, $value, $limit);
            }
            return $subject;
        } else {
            return preg_replace($pattern, $replacement, $subject, $limit);
        }
    }

}