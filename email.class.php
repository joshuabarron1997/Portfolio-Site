<?php
class ContactForm {
	//properties
	var $name = "";
	var $email = "";
	var $reason = "";
	var $message = "";

	//functions
	function setName($name){
		$this->name = $name;
	}
	function setEmail($email){
		$this->email = $email;
	}
	function setMessage($message){
		$this->message = $message;
	}
	function setReason($reason){
		$this->reason = $reason;
	}
	function sendContact(){
		$to = "joshuabarron1997@gmail.com";
		$content = 
			"My name is " . $this->name."\n.
			My Email is ".$this->email."\n
			My Reason for Contact is " . $this->reason."\n
			My message for you is ".$this->message;
		
		$headers = "From:" . "portfolio@joshbarron.info";
		return mail($to, $this->reason, $content, $headers);
	}
	function sendConfirmation(){
		$to = $this->email;
		$content = 
			"Confirmation that your contact request with Josh Barron was successfully sent.\n
			Josh Will get back to you as soon as possible.\n
			The Following Information was sent...\n\n
			My name is " . $this->name."\n.
			My Email is ".$this->email."\n
			My Reason for Contact is " . $this->reason."\n
			My message for you is ".$this->message."\n\n
			This was an automated message sent from Josh Barrons Portfolio Server";
		
		$headers = "From:" . "portfolio@joshbarron.info";
		return mail($to, "Contact Success Confirmation", $content, $headers);
	}
}
?>