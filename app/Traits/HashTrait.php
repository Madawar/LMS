<?php


namespace App\Traits;


use Vinkla\Hashids\Facades\Hashids;

trait HashTrait
{
    public function generateSlug($model)
    {
        $model->slug = Hashids::encode($model->id);
        $model->save();
    }
}
