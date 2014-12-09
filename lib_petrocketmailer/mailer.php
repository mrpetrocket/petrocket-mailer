<?php
defined( '_JEXEC' ) or die;
/**
 * Library that allows admin/site components to send petrocketmail
 *
 * Neat tutorial on Joomla libraries:
 * https://www.ostraining.com/blog/how-tos/development/how-to-package-joomla-libraries/
 */
class PetRocketMailer {
    /**
     * Sends an email message using a petrocketmailer template
     * @param $templateTitle The template title as specified in the admin panel.
     * @param $recipients Either a string containing one email address, or an array containing multiple email addresses
     * @param $variables An associative array containing all the variable/value mappings for the template. For example,
     * let's say that your template has the variables {sender} and {recipient}. You could pass array("sender"=>"me", "recipient"=>"you").
     * @throws Exception if something goes wrong
     */
    public function petRocketMail($templateTitle, $recipients, $variables) {
        // Load the template
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('subject, template');
        $query->from($db->quoteName('#__petrocketmailer_templates'));
        $query->where("title=" . $db->quote($templateTitle));
        $db->setQuery($query);
        $result = $db->loadObject();

        if ($template == null) {
            throw new Exception("Could not find template with title \"$templateTitle\"");
        }

        $template = $result->template;
        $subject = $result->subject;

        // Replace template variables with values specified by user
        $subject = template($subject);
        $template = template($template);

        // Send the email
        // https://docs.joomla.org/Sending_email_from_extensions
        $mailer = JFactory::getMailer();
        $config = JFactory::getConfig();
        $sender = array(
            $config->getValue( 'config.mailfrom' ),
            $config->getValue( 'config.fromname' ) );

        $mailer->setSender($sender);

        // Set recipients
        if (is_array($recipients)) {
            foreach($recipients as $recipient) {
                $mailer->addRecipient($recipient);
            }
        } else {
            $mailer->addRecipient($recipient);
        }

        $mailer->setSubject($subject);

        $mailer->isHTML(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($template);

        // TODO: what if user embeds an image into their template?

        // Send the message
        $send = $mailer->Send();
        if ($send !== true) {
            throw new Exception("Could not send mail because: " . $send->__toString());
        }

    }

    /**
     * @private
     * Replaces template variables in $str with user defined values from $variables.
     * See petRocketMail $variables for a description
     * @param $str
     * @param $variables
     */
    private function template($str, $variables) {
        $varNames = array_keys($variables);
        for($i=0;$i<count($varNames);$i++) {
            $varNames = "{" . $varname . "}";
        }
        return str_replace($varNames, $variables, $str);
    }
}
