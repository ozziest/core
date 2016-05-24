<?php namespace Ozziest\Core\Libraries;

use App\Core\Exceptions\UserException;

class Session {

    private $user = false;
    private $id;
    private $name;
    private $email;

    public function __construct($user)
    {
        $this->user = $user;
        $this->id = $this->id();
        $this->name = $this->name();
        $this->email = $this->email();
    }
        
    public function id()
    {
        $this->isMustBeSet();
        return $this->user->id;
    }
    
    public function name()
    {
        $this->isMustBeSet();
        $name = trim($this->user->first_name.' '.$this->user->last_name);
        if (strlen($name) === 0) {
            $name = self::email();
        }
        return $name;
    }
    
    public function email()
    {
        $this->isMustBeSet();
        return $this->user->email;
    }
    
    public function get()
    {
        $this->isMustBeSet();
        return $this->user;
    }
    
    private function isMustBeSet()
    {
        if ($this->user === false)
        {
            throw new UserException("Oturum geçerli değil.", 401);
        }
    }

}