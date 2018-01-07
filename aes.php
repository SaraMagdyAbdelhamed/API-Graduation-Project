<?php

	





function pkcs5_pad($text, $blocksize) 

{

    $pad = $blocksize - (strlen($text) % $blocksize);

    return $text . str_repeat(chr($pad), $pad);

}



$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');

	

	$block_size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128,MCRYPT_MODE_ECB);



	$iv_size = mcrypt_enc_get_iv_size($cipher);

	

	

$key ='Thats my Kung Fu';

	

	// Here's our 128-bit IV which is used for both 256-bit and 128-bit keys.

	$iv =  '1234567890123456';

	

	



	

	// This is the plain-text to be encrypted:

	//$cleartext = 'The quick brown fox jumped over the lazy dog';

//$cleartext = 'Two One Nine Two';

$cleartext ='Two One Nine Two';

// text padding 

$input = pkcs5_pad($cleartext, $block_size);



	printf("plainText: %s\n\n",$cleartext);

    echo "<br/>";



	// The mcrypt_generic_init function initializes the cipher by specifying both

	// the key and the IV.  The length of the key determines whether we're doing  

	//  256-bit encryption :

	if (mcrypt_generic_init($cipher, $key, $iv) != -1)

	{

		// PHP pads with NULL bytes if $cleartext is not a multiple of the block size..

		$cipherText = mcrypt_generic($cipher,$input );

		mcrypt_generic_deinit($cipher);

     

       

        $originalData = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,$cipherText,MCRYPT_MODE_ECB);

          

		

		// Display the result in hex.

		printf("encrypted result:\n%s\n\n",bin2hex($cipherText));

        echo "<br/>";

        

      

    $hex = bin2hex($originalData);    	

    $string='';

    for ($i=0; $i < strlen($hex)-1; $i+=2)

    {

        $string .= chr(hexdec($hex[$i].$hex[$i+1]));

    }

          //remove padding 

        

        $pad = ord($string[($len=strlen($string))-1]);

        

        $out= substr($string,0,strlen($string)-$pad);

        printf("decrypted result:\n%s\n\n",$out);

	}

	





	

?>