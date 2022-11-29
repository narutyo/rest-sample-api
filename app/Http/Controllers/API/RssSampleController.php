<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RssSample;
use FeedReader;

class RssSampleController extends Controller
{
  public function index()
  {
    $tmp = FeedReader::read('https://www.gizmodo.jp/index.xml');
    #$tmp = FeedReader::read('https://corp.itmedia.co.jp/media/rss_list/#_ga=2.15718966.1099176590.1669703540-1965403279.1669703540');

    $ret = array();
    foreach($tmp->get_items() as $feed) {
      $ret[] = array(
        'title' => $feed->get_title(),
        'content' => $feed->get_content(),

      );
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
