<?php

namespace ArqAdmin\Services;


use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

abstract class BaseService
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @var ValidatorInterface
     */
    protected $validator;


    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeRepository();
        $this->makeValidator();
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    abstract public function repository();

    /**
     * Specify Model class name
     *
     * @return string
     */
    abstract public function validator();

    /**
     * @return Repository
     * @throws RepositoryException
     */
    public function makeRepository()
    {
        $repository = $this->app->make($this->repository());

        if (!$repository instanceof RepositoryInterface) {
            throw new RepositoryException("Class {$this->repository()} must be an instance of Prettus\\Repository\\Contracts\\RepositoryInterface");

        }

        return $this->repository = $repository;
    }

    /**
     * @param null $validator
     * @return null|ValidatorInterface
     * @throws RepositoryException
     */
    public function makeValidator($validator = null)
    {
        $validator = !is_null($validator) ? $validator : $this->validator();

        if (!is_null($validator)) {
            $this->validator = is_string($validator) ? $this->app->make($validator) : $validator;

            if (!$this->validator instanceof ValidatorInterface) {
                throw new RepositoryException("Class {$validator} must be an instance of Prettus\\Validator\\Contracts\\ValidatorInterface");
            }

            return $this->validator;
        }

        return null;
    }

    public function validate($data, $id = null)
    {
        try {
//            if ($id) {
//                $this->validator->with($data)->setId($id)->passesOrFail(ValidatorInterface::RULE_UPDATE);
//            } else {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
//            }
//            dd('$data');

            return true;

        } catch (ValidatorException $e) {

            abort('400', $e->getMessageBag());
        }
    }

    public function create($data)
    {
        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            return $this->repository->create($data);

        } catch (ValidatorException $e) {

            abort('401', $e->getMessageBag());
        }
    }

    public function update($data, $id)
    {
        try {

            if ($this->repository->find($id)) {

                try {
                    $this->validator->with($data)->setId($id)->passesOrFail(ValidatorInterface::RULE_UPDATE);

                    return $this->repository->update($data, $id);

                } catch (ValidatorException $e) {

                    abort('401', $e->getMessageBag());
                }
            }

        } catch (ModelNotFoundException $e) {

            abort('404', 'Registro não encontrado');
        }
    }

    public function delete($id)
    {
        try {

            if ($this->repository->find($id)) {

                try {

                    $this->repository->delete($id);

                    return [
                        'success' => true,
                        'error' => false,
                        'message' => 'Registro removido com sucesso'
                    ];

                } catch (ValidatorException $e) {

                    abort('401', $e->getMessageBag());
                }
            }

        } catch (ModelNotFoundException $e) {

            abort('401', 'Registro não encontrado');
        }
    }

    public function getRevisionHistory($id)
    {
        $model = $this->repository->find($id);
        $revisionHistory = $model->revisionHistory;

        return $this->formatRevisions($revisionHistory);
    }

    public function getAllRevisionHistory($limit = 100, $order = 'desc')
    {
        $model = $this->repository->model();
        $revisionHistory = $model::classRevisionHistory($limit = 100, $order = 'desc');
        
        return $this->formatRevisions($revisionHistory);
    }

    public function formatRevisions($revisionHistory)
    {
        $history = [];
//dd($revisionHistory);
        foreach ($revisionHistory as $row) {
            $action = 'Atualizado';

            if ($row->key == 'created_at' && !$row->old_value) {
                $action = 'Adicionado';
            } elseif ($row->key == 'updated_at' && !$row->old_value) {
                $action = 'Removido';
            }

            array_push($history, [
                'id' => $row->id,
                'action' => $action,
                'revisionable_type' => $row->revisionable_type,
                'revisionable_id' => $row->revisionable_id,
                'user_name' => $row->userResponsible() ? $row->userResponsible()->name : null,
                'key' => $action === 'Adicionado' ? 'Registro novo' : $row->fieldName(),
                'old_value' => $row->oldValue(),
                'new_value' => $row->newValue(),
                'action_date' => $row->created_at->format('Y-m-d H:i:s'),
//                'action_date' => $row->created_at->format('d/m/Y H:i:s'),
//                'updated_at' => $row->updated_at->format('d/m/Y H:i:s'),
            ]);
        }

        return $history;
    }
}
