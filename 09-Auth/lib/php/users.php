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
    <h2>Users</h3>
    <p>
This is a simple users system, you can
<a href="?p=users&a=create" title="Create">create</a> a new user or
<a href="?p=users&a=read" title="List">list</a> them at your leisure.
    </p>';
    private $in = [
        'uid'       => '',
        'fname'     => '',
        'lname'     => '',
        'email'     => '',
        'webpw'     => '',
        'otp'       => '',
        'anote'     => '',
        'updated'   => '',
        'created'   => '',
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

    public function create()
    {
        if (count($_POST)) {
            $this->in['updated'] = date('Y-m-d H:i:s');
            $this->in['created'] = date('Y-m-d H:i:s');
            db::create($this->in);
            $this->b .= $this->read();
        } else {
            $this->b .= $this->t->users_form($this->in);
        }
    }

    public function list()
    {
        $buf = '';
        $users = db::read('*', '', '', 'ORDER BY `updated` DESC');
        foreach ($users as $note) $buf .= $this->t->users_list_row($note);
        $this->b .= $this->t->users_list($buf);
    }

    public function read()
    {
        if ($this->g->in['i']) {
            $note = db::read('*', 'id', $this->g->in['i'], '', 'one');
            $this->b .= $this->t->users_item($note);
        } else {
            $this->list();
        }
    }

    public function update()
    {
        if (count($_POST)) {
            $this->in['updated'] = date('Y-m-d H:i:s');
            $this->in['created'] = db::read('created', 'id', $this->g->in['i'], '', 'col');
            db::update($this->in, [['id', '=', $this->g->in['i']]]);
            $this->g->in['i'] = 0;
            $this->b .= $this->read();
        } elseif ($this->g->in['i']) {
            $note = db::read('*', 'id', $this->g->in['i'], '', 'one');
            $this->b .= $this->t->users_form($note);
        } else util::msg('Error updating users');
    }

    public function delete()
    {
        if ($this->g->in['i']) {
            $res = db::delete([['id', '=', $this->g->in['i']]]);
            $this->g->in['i'] = 0;
            $this->b .= $this->read();
        } else util::msg('Error deleting note');
    }
}
