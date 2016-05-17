<?php


namespace ArqAdmin\Traits;


use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * Class OverrideRevisionableTrait
 * @package Venturecraft\Revisionable
 */
trait OverrideRevisionableTrait
{
    use RevisionableTrait;

    /**
     * Override getUserId method
     * @return mixed User ID
     */
    public function getUserId()
    {
        return Authorizer::getResourceOwnerId();
    }
}