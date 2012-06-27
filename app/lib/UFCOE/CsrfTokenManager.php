<?php

namespace UFCOE;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;

class CsrfTokenManager
{
    protected $sess;
    protected $maxAge = 0;

    /**
     * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $sess
     */
    public function __construct(SessionInterface $sess)
    {
        $this->sess = $sess;
    }

    /**
     * @param int $maxAge in seconds
     * @return CsrfTokenManager
     */
    public function setMaxAge($maxAge = 0)
    {
        $this->maxAge = (int) $maxAge;
        return $this;
    }

    /**
     * @return string
     */
    protected function getSessionSecret()
    {
        $this->sess->start();
        $secret = $this->sess->get(get_class($this) . 'secret');
        if (! $secret) {
            $secret = hash('sha256', $this->sess->getId() . microtime(true) . rand());
            $this->sess->set(get_class($this) . 'secret', $secret);
        }
        return $secret;
    }

    /**
     * @return array [time, hash]
     */
    public function generatePair()
    {
        $time = time();
        $hash = hash_hmac('sha256', $time, $this->getSessionSecret());
        return array($time, $hash);
    }

    /**
     * @param int $time
     * @param string $hash
     * @param int $currentTime
     * @return bool
     */
    public function verifyPair($time, $hash, $currentTime = null)
    {
        if (! $currentTime) {
            $currentTime = time();
        }
        if ($hash === hash_hmac('sha256', (int) $time, $this->getSessionSecret())) {
            if ($this->maxAge) {
                return ($currentTime - $time < $this->maxAge);
            } else {
                return true;
            }
        }
        return false;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $req
     * @param int $currentTime
     * @return bool
     */
    public function requestHasValidToken(Request $req, $currentTime = null)
    {
        if (! $currentTime) {
            $currentTime = time();
        }
        $submitted = (string) $req->get('_csrf');
        if (strpos($submitted, '.')) {
            list ($time, $hash) = explode('.', $submitted);
            return $this->verifyPair($time, $hash, $currentTime);
        }
        return false;
    }

    /**
     * @return string
     */
    public function generateHiddenInput()
    {
        list ($time, $hash) = $this->generatePair();
        return "<input type=\"hidden\" name=\"_csrf\" value=\"{$time}.{$hash}\" />";
    }
}
