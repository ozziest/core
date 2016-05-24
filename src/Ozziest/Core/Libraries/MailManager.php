<?php namespace Ozziest\Core\Libraries;

use Nette\Mail\SmtpMailer;
use Nette\Mail\Message;
use Ozziest\Core\Exceptions\UserException;
use Exception;

class MailManager {
    
    private $mailer;
    private $mail;
    
    public function __construct(SmtpMailer $mailer, Message $message)
    {
        $this->mailer = $mailer;
        $this->mail = $message;
        $this->mail->setFrom(getenv("smtp_title"));
    }
    
    public static function getOptions()
    {
        return array(
            'host'     => 'smtp.gmail.com',
            'port'     => 587,
            'username' => getenv("smtp_mail"),
            'password' => getenv("smtp_password"),
            'secure'   => 'tls'
        );
    }
    
    public function welcome($email, $name, $subject = "Welcome")
    {
        $content = $this->loadContent('welcome');
        $content->replace("{NAME}", $name);

        $this->mail->addTo($email)
                   ->setSubject($subject)
                   ->setHTMLBody($content->toString());
        $this->send();
    }
    
    private function send()
    {
        try {
            $this->mailer->send($this->mail);
        }
        catch (Exception $exception)
        {
            throw new UserException("E-posta gönderiminde hata gerçekleşti.");
        }
    }
    
    private function loadContent($fileName)
    {
        if (getenv('APP_ENV') === 'testing')
        {
            return new Replacer("testing");
        }
        return new Replacer(file_get_contents(ROOT.'resource/emails/'.$fileName.'.html'));
    }
    
}