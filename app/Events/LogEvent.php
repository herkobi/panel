<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class LogEvent
{
    use Dispatchable;

    public $type;
    public $model;
    public $method;
    public $status;
    public $data;
    public $error;

    public function __construct($attributes)
    {
        $this->type = $attributes['type'];
        $this->model = $attributes['model'];
        $this->method = $attributes['method'];
        $this->status = $attributes['status'];
        $this->data = $attributes['data'] ? $attributes['data'] : '';
        $this->error = $attributes['error'] ? $attributes['error'] : '';
    }
}
