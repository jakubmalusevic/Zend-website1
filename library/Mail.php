<?php 
	
	class Mail {
		
		/**
		 * @return Zend_Mail
		 */
		public static function factory(){
			$mail = new Zend_Mail('UTF-8');            
			$mail->setFrom(Constants::SMTP_FROM_EMAIL, Constants::SMTP_FROM_NAME);
			$transport = self::transportFactory();
			if( $transport ){
				$mail->setDefaultTransport($transport);
			}
			return $mail;
		}
				
		public static function transportFactory($config=null){
			$conf['smtp']       = Constants::SMTP_ACTIVATE;
            $conf['host']       = Constants::SMTP_HOST;
            $conf['port']       = Constants::SMTP_PORT;
			$conf['auth']       = Constants::SMTP_AUTH;
			$conf['username']   = Constants::SMTP_USERNAME;
			$conf['password']   = Constants::SMTP_PASSWORD;
			$conf['ssl']        = Constants::SMTP_SSL;
			
			if( is_array($config) ){
				foreach( $conf as $key => $value ){
					if( array_key_exists($key, $config) ){
						$conf[$key] = $config[$key];
					}
				}
			}
			
			$transport = null;
			
			if( $conf['smtp'] ){
				$host = $conf['host'];
				unset($conf['smtp']);
				unset($conf['host']);
				$transport = new Zend_Mail_Transport_Smtp($host, $conf);
			}
			
			return $transport;
		}
	}