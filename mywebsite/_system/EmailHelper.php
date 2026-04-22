<?php
/**
 * Email Helper using PHPMailer
 * 
 * This class wraps PHPMailer for easy sending of emails via SMTP
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailHelper {
    private $config;
    private $mailer;
    
    public function __construct() {
        // Load configuration
        $this->config = require_once __DIR__ . '/email_config.php';
        
        // Initialize PHPMailer
        $this->mailer = new PHPMailer(true);
        
        // SMTP Configuration
        $this->mailer->isSMTP();
        $this->mailer->Host = $this->config['smtp_host'];
        $this->mailer->Port = $this->config['smtp_port'];
        $this->mailer->SMTPSecure = $this->config['smtp_secure'];
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $this->config['smtp_username'];
        $this->mailer->Password = $this->config['smtp_password'];
        
        // Default From address
        $this->mailer->setFrom($this->config['from_email'], $this->config['from_name']);
        
        // Character encoding
        $this->mailer->CharSet = 'UTF-8';
    }
    
    /**
     * Send an email
     * 
     * @param string|array $to Email address(es)
     * @param string $subject Email subject
     * @param string $body Email body (HTML or plain text)
     * @param string|null $replyTo Reply-to email address
     * @param bool $isHtml Whether body is HTML (default: false)
     * @return bool Success status
     */
    public function send($to, $subject, $body, $replyTo = null, $isHtml = false) {
        try {
            // Clear previous recipients
            $this->mailer->clearAddresses();
            $this->mailer->clearReplyTos();
            
            // Add recipient(s)
            if (is_array($to)) {
                foreach ($to as $email) {
                    $this->mailer->addAddress($email);
                }
            } else {
                $this->mailer->addAddress($to);
            }
            
            // Set reply-to
            if ($replyTo) {
                $this->mailer->addReplyTo($replyTo);
            } else {
                $this->mailer->addReplyTo($this->config['reply_to']);
            }
            
            // Set content
            $this->mailer->isHTML($isHtml);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            
            // Send
            return $this->mailer->send();
            
        } catch (Exception $e) {
            // Log error
            error_log("Email sending failed: " . $this->mailer->ErrorInfo);
            return false;
        }
    }
    
    /**
     * Send email to multiple recipients
     */
    public function sendToMultiple($recipients, $subject, $body, $replyTo = null, $isHtml = false) {
        return $this->send($recipients, $subject, $body, $replyTo, $isHtml);
    }
}
?>
