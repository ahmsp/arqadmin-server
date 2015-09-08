<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\DocumentoRepository;
use ArqAdmin\Validators\DocumentoValidator;

class DocumentoService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return DocumentoRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return DocumentoValidator::class;
    }


    public function findAll($params = []) {

        $result = $this->repository->findAllWhere($params);

        return $result;

    }

//    public function pregReplaceArray($pattern, $replacement, $subject, $limit=-1)
//    {
//        if (is_array($subject)) {
//            foreach ($subject as &$value){
//                $value = $this->pregReplaceArray($pattern, $replacement, $value, $limit);
//            }
//            return $subject;
//        } else {
//            return preg_replace($pattern, $replacement, $subject, $limit);
//        }
//    }

}