<?php

namespace LaravelACL\Repositories;

use LaravelACL\Criteria\CustomRequestCriteria;
use LaravelACL\Entities\Permission;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class PermissionRepositoryEloquent.
 *
 * @package namespace LaravelACL\Repositories;
 */
class PermissionRepositoryEloquent extends BaseRepository implements PermissionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }


    /**
     * Boot up the repository, pushing criteria
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(CustomRequestCriteria::class));
    }
    
}
