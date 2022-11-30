<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RssSample;
use FeedReader;

class RssSampleController extends Controller
{
  public function index(Request $request)
  {
    $url = $request->input('url');
    $ret = array();
    if ($url) {
      $tmp = FeedReader::read($url);
      foreach($tmp->get_items() as $feed) {
        $ret[] = array(
          'title' => $feed->get_title(),
          'content' => $feed->get_content(),
  
        );
      }  
    }
    return array(
      'keys'  => ['title', 'content'],
      'records' => $ret,
    );
  }

  public function store(Request $request)
  {
    $obj = new RssSample;
    $obj->store($request->all());
    return;
  }
}
