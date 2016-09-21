<?php

namespace ClienteUp\Lib;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class JWT {

	private static $token;
	
	public function __construct(string $issuer = '', string $audience = '', array $claims = [])
	{

		$signer = new Sha256();

		$token = (new Builder())->setIssuer($issuer)
		                        ->setAudience($audience)
		                        ->setIssuedAt(time())
		                        ->setNotBefore(time() + 60)
		                        ->setExpiration(time() + 3600);
		

		foreach($claims as $key => $claim)
			$token->set($key, $claim);

		$token = $token->sign($signer, 'acessoToken')->getToken();

		self::$token = $token;

	}

	public static function getToken(string $token = '')
	{
		if(!empty($token)) {
			self::$token = (new Parser())->parse($token);
			return self::$token;
		}

		return (string)self::$token;

	}

	public function getClaim(string $claim)
	{
		return self::$token->getClaim($claim);
	}

}