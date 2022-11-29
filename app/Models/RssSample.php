<?php

namespace App\Models;

class RssSample extends BaseModel
{
    protected $fillable = [
      'title',
      'attention',
      'importance',
      '_driveId',
      '_documentId',
      '_objectType',
      '_objectId',
      '_pageId',    
    ];
}
