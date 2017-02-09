<?php
// users.php 20151018 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);
error_log(__FILE__);


class Users
{
    const TABLE = 'users';

    private $g = null;
    private $t = null;
    private $b = '
    <p>
This is a simple users system, you can
<a href="?o=users&m=create" title="Create">create</a> a new user or
<a href="?o=users&m=read" title="List">list</a> them at your leisure.
    </p>';
    private $in = [
        'uid'       => '',
        'fname'     => '',
        'lname'     => '',
        'altemail'  => '',
        'webpw'     => '',
        'otp'       => '',
        'anote'     => '',
        'updated'   => '',
        'created'   => '',
    ];

    public function __construct(View $t, $g)
    {
error_log(__METHOD__);

        $this->t  = $t;
        $this->g  = $g;
        db::$tbl  = self::TABLE;
        $this->in = util::esc($this->in);
        $this->b .= $this->{$g->in['m']}();
    }

    public function __toString() : string
    {
error_log(__METHOD__);

        return $this->b;
    }

    public function create()
    {
error_log(__METHOD__);

        if (count($_POST)) {
            $this->in['updated'] = date('Y-m-d H:i:s');
            $this->in['created'] = date('Y-m-d H:i:s');
            $this->in['otpttl'] = 0;
            $this->in['cookie'] = '';
            db::create($this->in);
            return $this->read();
        } else {
            $this->in['submit']  = 'Add new user';
            return $this->t->users_form($this->in);
        }
    }

    public function read()
    {
error_log(__METHOD__);

        if ($this->g->in['i']) {
            $note = db::read('*', 'id', $this->g->in['i'], '', 'one');
            return $this->t->users_item($note);
        } else {
            return $this->t->users_list([
                'users' => db::read('*', '', '', 'ORDER BY `updated` DESC')
            ]);
        }
    }

    public function update()
    {
error_log(__METHOD__);

        if (count($_POST)) {
            $this->in['updated'] = date('Y-m-d H:i:s');
            $this->in['created'] = db::read('created', 'id', $this->g->in['i'], '', 'col');
            db::update($this->in, [['id', '=', $this->g->in['i']]]);
            $this->g->in['i'] = 0;
            return $this->read();
        } elseif ($this->g->in['i']) {
            return $this->t->users_form(array_merge(
                db::read('*', 'id', $this->g->in['i'], '', 'one'),
                ['submit' => 'Update user']
            ));
        } else return 'Error updating user';
    }

    public function delete()
    {
error_log(__METHOD__);

        if ($this->g->in['i']) {
            $res = db::delete([['id', '=', $this->g->in['i']]]);
            $this->g->in['i'] = 0;
            return $this->read();
        } else return 'Error deleting user';
    }
}
