<?php

namespace libs\classes;

class FlashMessage
{

	public function __construct($message, $code = 0, Exception $previous = null) 
	{
		set_exception_handler(array("libs\classes\HttpException", "getStaticException"));
		parent::__construct($message, $code, $previous);
	}
	
	public function setFlashMessage($type, $message)
	{
		$_SESSION['flash_'.$type] = $message;
	}
	
	public function getFlashMessage($type)
	{
		if(isset($_SESSION['flash_'.$key])) {
			return $_SESSION['flash_'.$key];
		}
	}
	
	public function clearAllFlashMessage()
	{
		if(!empty($_SESSION)) {
			foreach ($_SESSION as $key => $value) {
				if(preg_match('/flash_(.*)/', $key)) {
					unset($_SESSION[$key]);
				}
			}
		}
	}
}
