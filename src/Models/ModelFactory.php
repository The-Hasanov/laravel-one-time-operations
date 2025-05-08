<?php

namespace TimoKoerber\LaravelOneTimeOperations\Models;

use Illuminate\Foundation\Application;

class ModelFactory
{

    private $model;

    public function __construct(Application $app)
    {
        $this->model = $app['config']->get('one-time-operations.model', Operation::class);
    }

    /**
     * @return Operation
     */
    public function model()
    {
        return new $this->model;
    }

    /**
     * @return Operation
     */
    public static function instance()
    {
        return app(self::class)->model();
    }
}