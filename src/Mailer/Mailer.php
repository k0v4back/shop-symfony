<?php

namespace App\Mailer;

class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var string
     */
    private $mailerFrom;

    public function __construct(
        \Swift_Mailer $mailer,
        \Twig_Environment $twig,
        string $mailerFrom
    ) {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->mailerFrom = $mailerFrom;
    }

    public function sendEmail($theme, $email, $template, array $data = [])
    {
        $body = $this->twig->render($template, $data);

        \Swift_Preferences::getInstance()->setCharset('utf-8');
        $message = (new \Swift_Message())
            ->setSubject($theme)
            ->setFrom(trim($this->mailerFrom))
            ->setTo(trim($email))
            ->setBody($body, 'text/html');
        $this->mailer->send($message);
    }
}
