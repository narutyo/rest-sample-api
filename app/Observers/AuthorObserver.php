<?php
namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserCompanyRelation;

class AuthorObserver
{
    public function creating(Model $model)
    {
      if (!is_object(\Auth::user())) return;
      $model->created_by = \Auth::user()->id;
    }

    public function updating(Model $model)
    {
      if (!is_object(\Auth::user())) return;
      $model->updated_by = \Auth::user()->id;
    }

    public function saving(Model $model)
    {
      if (!is_object(\Auth::user())) return;
      $model->updated_by = \Auth::user()->id;
    }
}
