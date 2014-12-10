<?php
defined( '_JEXEC' ) or die;
/**
 * Library that allows admin or site components to send petrocketmail
 *
 * Neat tutorial on creating Joomla libraries:
 * https://www.ostraining.com/blog/how-tos/development/how-to-package-joomla-libraries/
 */
class PetRocketMailer {
    
    private $sender = array();
    
    function __construct() {
        // By default, email will be sent from the site address as configured by Joomla
        $config = JFactory::getConfig();
        $this->sender = array( 
            $config->get( 'config.mailfrom' ),
            $config->get( 'config.fromname' ) );
    }
    
    /**
     * Sends an email message using a petrocketmailer template
     * 
     * @param $templateTitle The template title as specified in the admin panel.
     * 
     * @param $recipients Either a string containing one email address, or an array containing multiple email addresses
     * 
     * @param $variables An associative array containing all the variable/value mappings for the template. For example,
     * let's say that your template has the variables {sender} and {recipient}. You could pass array("sender"=>"me", "recipient"=>"you").
     * 
     * $param [$options] Optional associative array of optional parameters. Valid options are as follows:
     * "sender" =  An array of two elements. First element = sender name. Second element = sender email.
     *      If sender is not specified, email will be sent from the global site address. 
     * 
     * @throws Exception if something goes wrong
     */
    public function send($templateTitle, $recipients, $variables, $options=array()) {
        // Load the template
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('subject, template');
        $query->from($db->quoteName('#__petrocketmailer_templates'));
        $query->where("title=" . $db->quote($templateTitle));
        $db->setQuery($query);
        $result = $db->loadObject();

        if ($result == null) {
            throw new Exception("PetRocketMail->Send Could not find email template with title \"$templateTitle\"");
        }

        $template = $result->template;
        $subject = $result->subject;

        // Replace template variables with values specified by user
        $subject = $this->template($subject, $variables);
        $template = $this->template($template, $variables);

        // Setup the email
        // https://docs.joomla.org/Sending_email_from_extensions
        $mailer = JFactory::getMailer();
        
        // Sender
        if (array_key_exists("sender", $options)) {
            $sender = $options["sender"];
        } else {
            $sender = $this->sender;
        }
        $mailer->setSender($sender);

        // Set recipients
        if (is_array($recipients)) {
            foreach($recipients as $recipient) {
                $mailer->addRecipient($recipient);
            }
        } else {
            $mailer->addRecipient($recipients);
        }

        $mailer->setSubject($subject);

        $mailer->isHTML(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($template);

        // Send the message
        $send = $mailer->Send();
        if ($send !== true) {
            throw new Exception("PetRocketMail->Send Could not send mail because: " . $send->__toString());
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
            $varNames[$i] = "{" . $varNames[$i] . "}";
        }
        return str_replace($varNames, $variables, $str);
    }
}
