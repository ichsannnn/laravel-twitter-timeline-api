<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twitter;
use File;

class TwitterController extends Controller
{
    public function twitterTimeline()
    {
      $data = Twitter::getUserTimeline(['count' => 10, 'format' => 'array']);
      return view('twitter.index', compact('data'));
    }

    public function tweet(Request $r)
    {
      $this->validate($r, [
        'tweet' => 'required',
      ]);

      $newTweet = ['status' => $r->tweet];


      if (!empty($r->file('images'))) {
        foreach ($r->file('images') as $key => $value) {
          $uploadedMedia = Twitter::uploadMedia(['media' => File::get($value->getRealPath())]);

          if (!empty($uploadedMedia)) {
            $newTweet['media_ids'][$uploadedMedia->media_id_string] = $uploadedMedia->media_id_string;
          }
        }
      }

      $twitter = Twitter::postTweet($newTweet);
      return back();
    }
}
