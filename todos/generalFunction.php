<?php
    function getEncryptedText($plainText)
    {
        error_reporting(E_ERROR | E_PARSE);
        $key = hex2bin(openssl_random_pseudo_bytes(4));
		$cipher = "AES-256-CBC";
		$ivlen = openssl_cipher_iv_length($cipher);
		$iv = openssl_random_pseudo_bytes($ivlen);
		$ciphertext = openssl_encrypt($plainText, $cipher, $key, 0, $iv);
		return (base64_encode($ciphertext . '::' . $iv. '::' .$key));
    }

    function getDecryptedText($cipherText)
    {
        $cipher = "AES-256-CBC";
		list($encrypted_data, $iv,$key) = explode('::', base64_decode($cipherText));
		return openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);
    }
?>