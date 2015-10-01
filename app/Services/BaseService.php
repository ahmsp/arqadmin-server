<?php

namespace ArqAdmin\Services;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Container\Container as Application;

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

        if ( !is_null($validator) ) {
            $this->validator = is_string($validator) ? $this->app->make($validator) : $validator;

            if (!$this->validator instanceof ValidatorInterface ) {
                throw new RepositoryException("Class {$validator} must be an instance of Prettus\\Validator\\Contracts\\ValidatorInterface");
            }

            return $this->validator;
        }

        return null;
    }

    public function create($data)
    {
        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            return $this->repository->create($data);

        } catch (ValidatorException $e) {

            return [
                'success' => false,
                'error' => true,
                'message' => $e->getMessageBag()
            ];
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

                    return [
                        'success' => false,
                        'error' => true,
                        'message' => $e->getMessageBag()
                    ];
                }
            }

        } catch (ModelNotFoundException $e) {

            return [
                'success' => false,
                'error' => true,
                'message' => 'Registro não encontrado'
            ];
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

                    return [
                        'success' => false,
                        'error' => true,
                        'message' => $e->getMessageBag()
                    ];
                }
            }

        } catch (ModelNotFoundException $e) {

            return [
                'success' => false,
                'error' => true,
                'message' => 'Registro não encontrado'
            ];
        }
    }

}