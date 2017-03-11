<?php
// lib/php/plugins/auth.php 20150101 - 20170307
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

class Plugins_Auth extends Plugin
{
    protected
    $tbl = 'users',
    $in = [
        'id'        => 0,
        'userid'    => '',
        'webpw'     => '',
        'remember'  => '',
        'otp'       => '',
        'passwd1'   => '',
        'passwd2'   => '',
    ];

    public function create() : string
    {
error_log(__METHOD__);

        $u = $this->in['userid'];

        if ($_POST) {
            if (filter_var($u, FILTER_VALIDATE_EMAIL)) {
                if ($usr = db::read('id,acl', 'userid', $u, '', 'one')) {
                    if ($usr['acl']) {
                        $newpass = util::genpw();
                        if ($this->mail_forgotpw($u, $newpass, 'From: ' . $this->g->email)) {
                            db::update([
                                'otp' => $newpass,
                                'otpttl' => time()
                            ], [['id', '=', $usr['id']]]);
                            util::log('Sent reset password key for "' . $u . '" so please check your mailbox and click on the supplied link.', 'success');
                        } else util::log('Problem sending message to ' . $u, 'danger');
                        return $this->t->read(['userid' => $u]);
                    } else util::log('Account is disabled, contact your System Administrator');
                } else util::log('User does not exist');
            } else util::log('You must provide a valid email address');
        }
        return $this->t->create(['userid' => $u]);
    }

    public function read() : string
    {
error_log(__METHOD__);

        $u = $this->in['userid'];
        $p = $this->in['webpw'];
        $c = $this->in['remember'];

        if ($u) {
            if ($usr = db::read('id,userid,acl,grp,fname,lname,webpw,cookie', 'userid', $u, '', 'one')) {
                extract($usr);
                if ($acl) {
//                    if ($p === $usr['webpw']) { // for testing a clear text password
                    if (password_verify(html_entity_decode($p), $webpw)) {
                        $uniq = md5(uniqid());
                        if ($c) {
                            db::update(['cookie' => $uniq], [['userid', '=', $u]]);
                            util::cookie_put('remember', $uniq, 60*60*24*7);
                            $tmp = $uniq;
                        } else $tmp = '';
                        $_SESSION['usr'] = [$id, $acl, $u, $fname, $lname, $tmp]; // add $grp
                        $_SESSION['usr2'] = $usr;
                        util::log($userid.' is now logged in', 'success');
                        if ((int) $acl === 1) $_SESSION['adm'] = $id;
                        $_SESSION['m'] = 'read';
                        header('Location: ' . $_SERVER['PHP_SELF']);
                        exit();
                    } else util::log('Incorrect password');
                } else util::log('Account is disabled, contact your System Administrator');
            } else util::log('Username does not exist');
        }
        return $this->t->read(['userid' => $u]);
    }

    public function update() : string
    {
error_log(__METHOD__);

        $i = $this->in['id'];
        $u = $this->in['userid'];

        if ($_POST) {
            if ($usr = db::read('userid,acl,otpttl', 'id', $i, '', 'one')) {
                $p1 = html_entity_decode($this->in['passwd1']);
                $p2 = html_entity_decode($this->in['passwd2']);
                if (util::chkpw($p1, $p2)) {
                    if ($usr['otpttl'] && (($usr['otpttl'] + 3600) > time())) {
                        if ($usr['acl']) {
                            if (db::update([
                                    'webpw'   => password_hash($p1, PASSWORD_DEFAULT),
                                    'otp'     => '',
                                    'otpttl'  => '',
                                    'updated' => date('Y-m-d H:i:s'),
                                ], [['id', '=', $i]])) {
                                util::log('Password reset for ' . $usr['userid'], 'success');
                                return $this->t->read(['userid' => $usr['userid']]);
                            } else util::log('Problem updating database');
                        } else util::log($usr['userid'] . ' is not allowed access');
                    } else util::log('Your one time password key has expired');
                }
            } else util::log('User does not exist');
        }
        return $this->t->update(['id' => $i, 'userid' => $u]);
    }

    public function delete() : string
    {
error_log(__METHOD__);

        $u = $_SESSION['usr'][2];
        if (isset($_SESSION['adm']) and $_SESSION['usr'][0] === $_SESSION['adm'])
            unset($_SESSION['adm']);
        unset($_SESSION['usr']);
        util::cookie_del('remember');
        util::log($u . ' is now logged out', 'success');
        header('Location: ' . $this->g->self);
        exit();
    }

    // Utilities

    public function resetpw() : string
    {
error_log(__METHOD__);

        $otp = html_entity_decode($this->in['otp']);
        if (strlen($otp) === 10) {
            if ($usr = db::read('id,userid,acl,otp,otpttl', 'otp', $otp, '', 'one')) {
                extract($usr);
                if ($otpttl && (($otpttl + 3600) > time())) {
                    if ($acl) {
                        return $this->t->update(['id' => $id, 'userid' => $userid]);
                    } else util::log($userid . ' is not allowed access');
                } else util::log('Your one time password key has expired');
            } else util::log('Your one time password key no longer exists');
        } else util::log('Incorrect one time password key');
        header('Location: ' . $this->g->self);
        exit();
    }

    private function mail_forgotpw(string $email, string $newpass, string $headers = '') : bool
    {
error_log(__METHOD__);

        $host = $_SERVER['REQUEST_SCHEME'] . '://'
            . $_SERVER['HTTP_HOST']
            . $_SERVER['PHP_SELF'];
        return mail(
            "$email",
            'Reset password for ' . $_SERVER['HTTP_HOST'],
'Here is your new OTP (one time password) key that is valid for one hour.

Please click on the link below and continue with reseting your password.

If you did not request this action then please ignore this message.

' . $host . '?o=auth&m=resetpw&otp=' . $newpass,
            $headers
        );
    }
}

?>
