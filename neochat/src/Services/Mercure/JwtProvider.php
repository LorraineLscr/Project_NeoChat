<?php

declare(strict_types=1);

namespace App\Service\Mercure;

use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Encoding\ChainedFormatter;

class JwtProvider
{
    private string $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function __invoke(): string 
    {
        $signer = new Sha256();
        $signingKey = InMemory::plainText($this->key);

        return (new Builder(new JoseEncoder(), ChainedFormatter::default()))
            ->withClaim('mercure', ['publish' => ['*']])
            ->getToken($signer, $signingKey)
            ->toString();
    }
}
