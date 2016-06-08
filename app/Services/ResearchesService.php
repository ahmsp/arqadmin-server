<?php

namespace ArqAdmin\Services;


use ArqAdmin\Entities\Parameters;
use ArqAdmin\Entities\Researches;
use ArqAdmin\Repositories\ResearchesRepository;
use ArqAdmin\Validators\ResearchesValidator;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ResearchesService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return ResearchesRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return ResearchesValidator::class;
    }

    public function saveResearch(Request $request, $collection)
    {
        $requestParams = $request->all();
        $paramsCollection = [];

        if (isset($requestParams['search_all'])) {
            array_push($paramsCollection, new Parameters([
                'property' => 'search_all',
                'value' => $requestParams['search_all'],
                'operator' => 'like'
            ]));
        }

        if (isset($requestParams['filter'])) {
            $filters = $requestParams['filter'];

            if (is_string($filters)) {
                $filters = json_decode($filters, true);
            }

            foreach ($filters as $filter) {
                if (is_array($filter['value'])) {
                    foreach ($filter['value'] as $value) {
                        $filter['value'] = $value;
                        array_push($paramsCollection, new Parameters($filter));
                    }
                } else {
                    array_push($paramsCollection, new Parameters($filter));
                }
            }
        }

        if (count($paramsCollection) > 0) {

            $research = $this->repository->create([
                'collection' => $collection,
                'route' => $request->path(),
                'query_string' => str_replace($request->url(), '', $request->fullUrl()),
                'date' => Carbon::now(),
                'users_id' => $request->user()->id
            ]);

            return $research->parameters()->saveMany($paramsCollection);
        }

        return null;
    }

}