<?php
// auth.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);

class auth
{
    const TABLE = 'users';

    private $g = null;
    private $t = null;
    private $b = '';
    private $in = [
        'uid'           => '',
        'webpw'         => '',
        'remember'      => '',
        'otp'           => '',
        'passwd1'       => '',
        'passwd2'       => '',
    ];

    public function __construct(View $t, $g)
    {
        $this->t = $t;
        $this->g = $g;
        db::$tbl = self::TABLE;
        $this->in = util::esc($this->in);
        $this->{$g->in['a']}();
    }

    public function __toString() : string
    {
        return $this->b;
    }

    public function signin()
    {
        $u = $this->in['uid'];
        $p = $this->in['webpw'];
        $c = $this->in['remember'];

        if ($u) {
            if ($usr = db::read('id,acl,uid,webpw,cookie', 'uid', $u, '', 'one')) {
                if ($usr['acl']) {
//                    if ($p === $usr['webpw']) { // for testing a clear text password
                    if (password_verify(html_entity_decode($p), $usr['webpw'])) {
                        $uniq = md5(uniqid());
                        if ($c) {
                            db::update(['cookie' => $uniq], [['uid', '=', $u]]);
                            util::cookie_put('remember', $uniq, 60*60*24*7);
                            $tmp = $uniq;
                        } else $tmp = '';
                        $_SESSION['usr'] = [$usr['id'], $usr['acl'], $u, $tmp];
                        util::msg($usr['uid'].' is now logged in', 'success');
                        if ($usr['acl'] == 1) $_SESSION['adm'] = $usr['id'];
                        header('Location: '.$_SERVER['PHP_SELF']);
                        exit();
                    } else util::msg('Incorrect password');
                } else util::msg('Account is disabled, contact your System Administrator');
            } else util::msg('Username does not exist');
        }
        $this->b = $this->t->auth_signin($u);
    }

    public static function signout()
    {
        $u = $_SESSION['usr'][2];
        if (isset($_SESSION['adm']) and $_SESSION['usr'][0] === $_SESSION['adm'])
            unset($_SESSION['adm']);
        unset($_SESSION['usr']);
        util::cookie_del('remember');
        util::msg($u.' is now logged out', 'success');
        header('Location: '.$_SERVER['PHP_SELF']);
        exit();
    }

    public function forgotpw()
    {
        $u = $this->in['uid'];

        if ($_POST) {
            if (filter_var($u, FILTER_VALIDATE_EMAIL)) {
                if ($usr = db::read('id,acl', 'uid', $u, '', 'one')) {
                    if ($usr['acl']) {
                        $newpass = util::genpw();
                        if ($this->mail_forgotpw($u, $newpass, $this->g->cfg['email'])) {
                            db::update([
                                'otp' => $newpass,
                                'otpttl' => time()
                            ], [['id', '=', $usr['id']]]);
                            util::msg('Sent reset password key for '.$u.' so please check your mailbox and click on the supplied link.', 'success');
                        } else util::msg('Problem sending message to '.$u, 'danger');
                        $this->b = $this->t->auth_signin($u);
                        return;
                    } else util::msg('Account is disabled, contact your System Administrator');
                } else util::msg('User does not exist');
            } else util::msg('You must provide a valid email address');
        }
        $this->b = $this->t->auth_forgotpw($u);
    }

    public function newpw()
    {
        $otp = html_entity_decode($this->in['otp']);
        if (strlen($otp) === 10) {
            if ($usr = db::read('id,uid,acl,otp,otpttl', 'otp', $otp, '', 'one')) {
                if ($usr['otpttl'] && (($usr['otpttl'] + 3600) > time())) {
                    if ($usr['acl']) {
                        $this->b = $this->t->auth_newpw($usr['id'], $usr['uid']);
                        return;
                    } else util::msg('Error: '.$usr['uid'].' is not allowed access');
                } else util::msg('Error: your one time password key has expired');
            } else util::msg('Error: your one time password key no longer exists');
        } else util::msg('Error: incorrect one time password key');
        $this->b = $this->t->auth_forgotpw();
    }

    public function resetpw()
    {
        if (count($_POST)) {
            $id = $this->g->in['i'];
            if ($usr = db::read('uid,acl,otpttl', 'id', $id, '', 'one')) {
                $p1 = html_entity_decode($this->in['passwd1']);
                $p2 = html_entity_decode($this->in['passwd2']);
                if (util::chkpw($p1, $p2)) {
                    if ($usr['otpttl'] && (($usr['otpttl'] + 3600) > time())) {
                        if ($usr['acl']) {
                            if (db::update([
                                    'webpw'     => password_hash($p1, PASSWORD_DEFAULT),
                                    'otp'       => '',
                                    'otpttl'    => '',
                                    'updated'   => date('Y-m-d H:i:s'),
                                ], [['id', '=', $id]])) {
                                util::msg('Password reset for '.$usr['uid'], 'success');
                                $this->b = $this->t->auth_signin($usr['uid']);
                                return;
                            } else util::msg('Error: problem updating database');
                        } else util::msg('Error: '.$usr['uid'].' is not allowed access');
                    } else util::msg('Error: your one time password key has expired');
                }
            } else util::msg('Error: user does not exist');
        }
        $this->b = $this->t->auth_newpw($id, $usr['uid']);
    }

    private function mail_forgotpw($email, $newpass, $headers = '')
    {
        return mail(
            $email,
            'Reset password for '.$_SERVER['HTTP_HOST'],
'Here is your new one-time password key that is valid for one hour.

Please click on the link below and continue with reseting your password.

If you did not request this action then ignore this email message.

https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?p=auth&a=newpw&otp='.$newpass,
            $headers
        );
    }
}
