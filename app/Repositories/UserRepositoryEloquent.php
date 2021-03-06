<?php

namespace LaravelACL\Repositories;

use LaravelACL\Criteria\CustomRequestCriteria;
use LaravelACL\Entities\User;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace LaravelACL\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }


    /**
     * Boot up the repository, pushing criteria
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(CustomRequestCriteria::class));
    }


    /**
     * @param array $attributes
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(array $attributes)
    {
        $user = parent::create($attributes);

        if ($attributes['roles'])
            $user->roles()->sync($attributes['roles']);

        return $user;
    }
}
