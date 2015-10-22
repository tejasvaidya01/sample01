<?php
// notes.php 20151018 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);

class Notes
{
    const TABLE = 'notes';

    private $g = null;
    private $t = null;
    private $b = '
    <h2>Notes</h3>
    <p>
This is a simple note system, you can
<a href="?p=notes&a=create" title="Create">create</a> a new note or
<a href="?p=notes&a=read" title="Read">read</a> them at your leisure.
    </p>';
    private $in = [
        'title'     => '',
        'author'    => '',
        'content'   => '',
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
            $this->b .= $this->t->notes_form($this->in);
        }
    }

    public function read()
    {
        if ($this->g->in['i']) {
            $note = db::read('*', 'id', $this->g->in['i'], '', 'one');
            $this->b .= $this->t->notes_item($note);
        } else {
            $notes = db::read('*', '', '', 'ORDER BY `updated` DESC');
            foreach ($notes as $note) $this->b .= $this->t->notes_item($note);
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
            $this->b .= $this->t->notes_form($note);
        } else util::msg('Error updating notes');
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
