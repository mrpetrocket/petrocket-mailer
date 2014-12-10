petrocket-mailer
================

An attempt to create a simple, free email template system for Joomla.

Getting Started
---------------
1. Install petrocket-mailer via the Joomla package file pkg_petrocketmailer.zip. You can find this file in the pkg_petrocketmailer/ folder.
2. Access the backend from Components/PetRocket Mailer.
3. Create a new email template. Enter "My Template" as the title. Enter "Hey {recipient}!" as the subject. For the template, enter:

        <p>{sender} has just sent you an email!</p>

    {recipient} and {sender} are examples of template variables. When you send an email using this template, you can customize the values of these variables.

4. Save the template.
5. Now find a good place in your Joomla component to send an email. At the top of the file, add the following code:

        jimport('petrocket.mailer');

6. To send the email, use this snippet:

        $mailer = new PetRocketMailer();
        $mailer->send("My Template", "you@wherever.com", array("sender"=>"the sender", "recipient"=>"you"));

    The last parameter for send() allows you to customize the template variables.
7. You should receive an email with the subject "Hey you!" and body "the sender has just sent you an email!"

Development Status
------------------
The component works, but it's still showing a lot of boilerplate code from the Joomla component tutorial I used. You can find that tutorial here:
[https://docs.joomla.org/J3.2:Developing_a_MVC_Component/Developing_a_Basic_Component](https://docs.joomla.org/J3.2:Developing_a_MVC_Component/Developing_a_Basic_Component)
