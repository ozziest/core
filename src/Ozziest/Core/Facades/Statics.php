<?php namespace Ozziest\Core\Facades;

use Ozziest\Core\Exceptions\UserException;

class Statics {

    private $list = [
    
        "Period" => [1, 2, 5, 10, 15, 30, 45, 60, 90, 120],
        "Action Type" => ['follow', 'unfollow', 'follow.unfollow', 'like', 'retweet'],
        "Account Type" => ["twitter", "foursquare"]

    ];
    
    public function check($key, $value)
    {
        if (in_array($value, $this->list[$key]) === false)
        {
            throw new UserException("The {$key} is invalid!");
        }
    }
   
}