<?php 
	class Emailer {
		
		//this class will process a php email and send it
		
		//properties declaration
		//access identifier property name
		private $message = "";
		private $recieverEmail = ""; //private means you cannot access the property outside the object
		private $senderEmail = "";
		private $subject = "";
		
		//constructor methods
		//1. DOES NOT make a new object
		//2. initializes the new object default values
		public function __construct(){
			
		}
		
		//methods
			//setter methods - used to set property values into the object
			
			public function set_message($inValue){
				$this->message = $inValue;
			}
		
			public function set_recieverEmail($inValue){
				$this->recieverEmail = $inValue;
			}
		
			public function set_senderEmail($inValue){
				$this->senderEmail = $inValue;
			}
		
			public function set_subject($inValue){
				$this->subject = $inValue;
			}
		
		
			//getters methods - return the property value from the object
			//	one method per property
			public function get_message(){
				return $this->message;
			}	
		
			public function get_recieverEmail(){
				return $this->recieverEmail;
			}
		
			public function get_senderEmail(){
				return $this->senderEmail;
			}
		
			public function get_subject(){
				return $this->subject;
			}
		
			//processing methods - everything else
			public function sendEmail(){
				//this will format and send an email to the SMTP server
				//it will use the PHP mail()
				$to = $this->get_recieverEmail();
				$subject = $this->get_subject();
				$message = $this->get_message();
				$headers = "From: " . $this->get_senderEmail();
				
				return mail($to, $subject, $message, $headers);
				
			}
		
		
	}





?>