<?php
// lib/php/plugin.php 20150101 - 20170305
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

class Plugin
{
    protected
    $buf = '',
    $tbl = '',
    $in  = [];

    public function __construct(Theme $t)
    {
error_log(__METHOD__);

        $this->t    = $t;
        $this->g    = $t->g;
        $this->in = util::esc($this->in);
        if ($this->tbl) {
            if (is_null(db::$dbh))
                db::$dbh = new db($t->g->db);
            db::$tbl  = $this->tbl;
        }
        $this->buf .= $this->{$t->g->in['m']}();
    }

    public function __toString() : string
    {
error_log(__METHOD__);

        return $this->buf;
    }

    protected function create() : string
    {
error_log(__METHOD__);

        if ($_POST) {
            $this->in['updated'] = date('Y-m-d H:i:s');
            $this->in['created'] = date('Y-m-d H:i:s');
            $lid = db::create($this->in);
            util::log('Item number ' . $lid . ' created', 'success');
            return $this->read();
        } else return $this->t->create($this->in);
    }

    protected function read() : string
    {
error_log(__METHOD__);

        return $this->g->in['i']
            ? $this->t->read_one($this->read_one())
            : $this->t->read($this->read_all());
    }

    protected function read_one() : array
    {
error_log(__METHOD__);

        return db::read('*', 'id', $this->g->in['i'], '', 'one');
    }

    protected function read_all() : array
    {
error_log(__METHOD__);

        return db::read('*', '', '', 'ORDER BY `updated` DESC');
    }

    protected function update() : string
    {
error_log(__METHOD__);

        if ($_POST) {
            $this->in['updated'] = date('Y-m-d H:i:s');
            db::update($this->in, [['id', '=', $this->g->in['i']]]);
            util::log('Item number ' . $this->g->in['i'] . ' updated', 'success');
            $this->g->in['i'] = 0;
            return $this->read();
        } elseif ($this->g->in['i']) {
            return $this->t->update(db::read('*', 'id', $this->g->in['i'], '', 'one'));
        } else return 'Error updating item';
    }

    protected function delete() : string
    {
error_log(__METHOD__);

        if ($this->g->in['i']) {
            $res = db::delete([['id', '=', $this->g->in['i']]]);
            util::log('Item number ' . $this->g->in['i'] . ' removed', 'success');
            $this->g->in['i'] = 0;
            return $this->read();
        } else return 'Error deleting item';
    }
}

?>
