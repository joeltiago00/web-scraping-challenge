<?php

namespace App\Repositories;

use App\Exceptions\Generic\NotFoundException;
use App\Exceptions\Generic\NotGetedException;
use App\Exceptions\User\UserNotDeletedException;
use App\Exceptions\User\UserNotGetedException;
use App\Exceptions\UserCar\UserCarNotExcludedException;
use Illuminate\Database\Eloquent\Model;
use Throwable;

abstract class Repository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @param string $model
     * @return void
     */
    protected function setModel(string $model): void
    {
        $this->model = new $model();
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param int $id
     * @return Model
     * @throws NotGetedException
     * @throws Throwable
     */
    public function getById(int $id): Model
    {
        try {
            $model = $this->getModel()::find($id);
        } catch (\Exception $exception) {
            throw new NotGetedException($exception);
        }

        throw_if(empty($model), new NotFoundException());

        return $model;
    }
}
