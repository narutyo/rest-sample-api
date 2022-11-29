<?php

namespace App\Models;

class Sample extends BaseModel
{
    protected $fillable = [
      'name',
      
      '_driveId',
      '_documentId',
      '_objectType',
      '_objectId',
      '_pageId',    
    ];
}
