<?php
namespace view;

class HTMLPage {

	//funktion som tar in titel och body
	//returnerar sträng med HTML
	public function getPage($title, $body){
		if ($body === NULL) {
			throw new \Exception("HTMLView::echoHTML does not allow body to be NULL");
		}
		return
			"<!DOCTYPE html>
			<html>
				<head>
					<title> " . $title . " </title>
					<meta http-equiv='content-type' content='text/html' charset=utf-8>
				</head>
				<body>
					" . $body . "
				</body>
			</html>";
	}
}