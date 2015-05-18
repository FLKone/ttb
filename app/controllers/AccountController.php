<?php
include_once 'app/vendor/functions.php';

class AccountController extends Controller
{
    public function index()
    {
        sec_session_start();

        if (null === $this->f3->get('SESSION.username')) {
            $this->f3->reroute('@auth');
        } else {
            echo($this->f3->get('SESSION.username'));
            $this->f3->set('view', 'error.html');
        }
    }

    public function auth()
    {
        $this->f3->set('view', 'account/auth.html');
    }

    public function login()
    {
        $user = new User($this->db, $this->f3);

        $username = $this->f3->get('POST.username');
        $password = $this->f3->get('POST.password');

        error_log($username . ' ' . $password);

        $response = $user->login($username, $password);

        if ($response)
        {
            echo($this->f3->get('SESSION.username'));
            $this->f3->set('view', 'account/auth.html');
        } else
        {
            echo("cancel");
            $this->f3->set('view', 'account/auth.html');
        }

        $this->f3->set('view', 'error.html');
    }

    public function reset()
    {
        $user = new User($this->db);
        $user->reset();

        $this->f3->set('view', 'error.html');
    }
}
