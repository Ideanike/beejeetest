<?php

namespace App\Http;

use Doctrine\ORM\EntityManager;
use Laminas\Session\SessionManager;
use Psr\Http\Server\RequestHandlerInterface;
use Twig\Environment;

abstract class AbstractAction implements RequestHandlerInterface
{
    /** @var Environment */
    protected $template;
    /** @var EntityManager */
    protected $em;
    /** @var SessionManager */
    protected $sessionManager;

    /**
     * AbstractAction constructor.
     * @param Environment $template
     * @param EntityManager $em
     * @param SessionManager $sessionManager
     */
    public function __construct(Environment $template, EntityManager $em, SessionManager $sessionManager)
    {
        $this->template = $template;
        $this->em = $em;
        $this->sessionManager = $sessionManager;
    }
}