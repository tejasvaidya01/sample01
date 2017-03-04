<?php
// widgets.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);

class Widgets
{
    public function a(
        string $href,
        string $label = '',
        string $class = '',
        string $extra = '') : string
    {
        $v = 'veto_a';
        if (method_exists($this, $v))
            extract($this->$v($href, $label, $class, $extra));

        $label = $label ?? $href;
        $class = $class ? ' class="'.$class.'"' : '';
        return '
        <a'.$class.' href="'.$href.'"'.$extra.'>'.$label.'</a>';
    }

    public function button(
        string $label,
        string $type = '',
        string $class = '',
        string $name = '',
        string $value = '',
        string $extra = '') : string
    {
        $v = 'veto_button';
        if (method_exists($this, $v))
            extract($this->$v($label, $type, $class, $name, $value, $extra));

        $class = $class ? ' class="'.$class.'"' : '';
        $type  = $type  ? ' type="'.$type.'"'   : '';
        $name  = $type  ? ' name="'.$name.'"'   : '';
        $value = $value ? ' value="'.$value.'"' : '';
        $extra = $extra ?? '';
        return '
          <button'.$class.$type.$name.$value.$extra.'>'.$label.'</button>';
    }

    public function email_contact_form() : string
    {
        $v = 'veto_email_contact_form';
        if (method_exists($this, $v)) return $this->$v();
        return '
      <form action="" method="post" onsubmit="return mailform(this);">
        <p>
          <label for="subject">Your Subject</label>
          <input type="text" id="subject" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,40}$">
        </p>
        <p>
          <label for="message">Your Message</label>
          <textarea type="text" rows= "5" id="message" maxlength="1024" minlength="5"></textarea>
        </p>
        <p>'.$this->button('Send', 'submit', 'primary').'
        </p>
      </form>';
    }
}
