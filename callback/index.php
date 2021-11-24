<?php
if (!function_exists("callback_redirect"))
{
	function callback_redirect($url, $time = 0)
	{
		if ($time > 0)
		{
			@header("refresh:{$time};url={$url}");
			echo "<meta http-equiv='refresh' content='{$time}; url={$url}' />";
			exit;
		} else {
			@header('Location: '. $url);
			echo "<meta http-equiv='refresh' content='0; url={$url}' />";
			exit;
		}
	}
}

$id 	= (isset($_POST['InvoiceID']) && $_POST['InvoiceID'] != "") 			? $_POST['InvoiceID'] 	: "";
$token 	= (isset($_POST['Authority']) && $_POST['Authority'] != "") 			? $_POST['Authority'] 	: "";
$status = (isset($_POST['PaymentStatus']) && $_POST['PaymentStatus'] == "OK") 	? 1 					: 0;

callback_redirect("../pg/callback?id={$id}&status={$status}&token={$token}");
?>