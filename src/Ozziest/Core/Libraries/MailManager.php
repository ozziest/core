<?php namespace Ozziest\Core\Libraries;

use Nette\Mail\SmtpMailer;
use Nette\Mail\Message;
use Ozziest\Core\Exceptions\UserException;
use Exception;

class MailManager {
    
    private static $mailer;
    private static $mail;
    
    public static function welcome($email, $name)
    {
        self::init();
        
        $content = self::loadContent('welcome');
        $content->replace("{NAME}", $name);

        self::$mail->addTo($email)
                   ->setSubject('Welcome to sociaman!')
                   ->setHTMLBody($content->toString());
        self::send();
    }

    public static function invitation($email, $inviter, $code)
    {
        self::init();
        
        $content = self::loadContent('invitation');
        $content->replace("{INVITER}", $inviter)
                ->replace("{CODE}", $code)
                ->replace("{DOMAIN}", getenv('domain'));
        
        self::$mail->addTo($email)
                   ->setSubject('Yazarlık Davetiyesi')
                   ->setHTMLBody($content->toString());
        self::send();
    }
    
    private function send()
    {
            self::$mailer->send(self::$mail);
        try {
        }
        catch (Exception $exception)
        {
            // throw new UserException("E-posta gönderiminde hata gerçekleşti.");
        }
    }
    
    private static function init()
    {
        self::$mailer = new SmtpMailer(array(
            'host'     => 'smtp.gmail.com',
            'port'     => 587,
            'username' => getenv("smtp_mail"),
            'password' => getenv("smtp_password"),
            'secure'   => 'tls',
        ));

        self::$mail = new Message;
        self::$mail->setFrom(getenv("smtp_title"));
    }
    
    private static function loadContent($fileName)
    {
        return new Replacer(file_get_contents(ROOT.'resource/emails/'.$fileName.'.html'));
    }
    
}