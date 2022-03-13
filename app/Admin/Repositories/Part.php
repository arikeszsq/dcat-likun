<?php

namespace App\Admin\Repositories;

use App\Models\Part as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Part extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
