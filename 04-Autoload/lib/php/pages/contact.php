<?php

return '
      <h2>Email Contact Form</h2>
      <form id="contact-send" method="post" onsubmit="return mailform(this);">
        <p>
          <label for="subject">Subject</label>
          <input id="subject" placeholder="Your Subject" required="" type="text">
        </p>
        <p>
          <label for="message">Message</label>
          <textarea id="message" rows="9" placeholder="Your Message" required=""></textarea>
        </p>
        <p>
          <input class="btn" type="submit" id="send" value="Send">
        </p>
      </form>
      <script>
function mailform(form) {
    location.href = "mailto:'.$g->cfg['email'].'"
        + "?subject=" + encodeURIComponent(form.subject.value)
        + "&body=" + encodeURIComponent(form.message.value);
    form.subject.value = "";
    form.message.value = "";
    alert("Thank you for your message. We will get back to you as soon as possible.");
    return false;
}
      </script>';
