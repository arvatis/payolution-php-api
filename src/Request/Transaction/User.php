<?php



namespace ArvPayolutionApi\Request\Transaction;

/**
 * Class User
 */
class User
{
    /**
     * @var  string
     */
    protected $pwd;

    /**
     * @var  string
     */
    protected $login;

    /**
     * User constructor.
     *
     * @param $pwd
     * @param $login
     */
    public function __construct($pwd, $login)
    {
        $this->pwd = $pwd;
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function _getPwd()
    {
        return $this->pwd;
    }

    /**
     * @return string
     */
    public function _getLogin()
    {
        return $this->login;
    }
}
