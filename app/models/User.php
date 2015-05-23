<?php
include_once 'app/vendor/functions.php';

class User extends DB\SQL\Mapper {

    private $f3;

	public function __construct(DB\SQL $db) {
		parent::__construct($db,'user');
        $this->f3 = \Base::instance();
	}

    public function login($email, $password)
    {
        $request = 'SELECT *'.
            ' FROM user '.
            ' WHERE email = :email';

        $result = $this->db->exec($request, array(':email' => $email));

        if (is_array($result) && count($result) == 1)
        {
            $verifyPwd = password_verify($password, $result[0]['password']);

            if ($verifyPwd == true)
            {
                sec_session_start();

                $user_browser = $_SERVER['HTTP_USER_AGENT'];
                $this->f3->set('SESSION.username', html_entity_decode($result[0]['username']));
                $this->f3->set('SESSION.hfr_user_id', $result[0]['hfr_user_id']);
                $this->f3->set('SESSION.login_string', hash('sha512', $password . $user_browser));

                return "OK";
            } else {
                return "incorrect";
            }
        } else {
            return "problem";
        }


    }

    public function resetLogin()
    {
        $password='azerty';
        $password_hash = hash('sha512', $password);

        $hash_pwd = password_hash($password_hash, PASSWORD_DEFAULT);

        $request = 'UPDATE user SET password= :password WHERE hfr_user_id=929138';

        return $this->db->exec($request, array(':password' => $hash_pwd));

/*        $smtp=new SMTP ($this->f3->get('smtp_server'), $this->f3->get('smtp_port'), false, $this->f3->get('smtp_account'), $this->f3->get('smtp_pwd'));
        $smtp->set('To', '"plop" <plop@plop.com>');
        $smtp->set('From', '"The Tartuffe Bay" <no-reply@thetartuffebay.org>');
        $smtp->set('Subject', 'Sent with the F3 SMTP plug-in');
        $smtp->send("Plop");*/
    }
}
