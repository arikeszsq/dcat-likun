<?php

namespace App\Admin\Repositories;

use App\Models\JfTalkLog as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class JfTalkLog extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
