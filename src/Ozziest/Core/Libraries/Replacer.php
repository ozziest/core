<?php namespace Ozziest\Core\Libraries;

class Replacer {
    
    private $content;
    
    public function __construct($content)
    {
        $this->content = $content;
    }
    
    public function replace($old, $new)
    {
        $this->content = str_replace($old, $new, $this->content);
        return $this;
    }
    
    public function toString()
    {
        return $this->content;
    }
    
}