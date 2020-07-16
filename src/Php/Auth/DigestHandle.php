<?php

declare(strict_types=1);

namespace Auth;

class DigestHandle
{
    private $h;

    public function getDigestHeader()
    {
        if (!isset($this->h)) {
            $this->h = 'WWW-Authenticate: Digest realm="Soap",' .
                'domain="/soap/server/digest",' .
                'nonce=' . base64_encode(uniqId('soap', true)) . ','  .
                'opaque="' . md5('Soap') . '",' . #retournée telle quelle
                'algorithm="MD5",' .
                'qop="auth"';
        }

        return $this->h;
    }

    public function digestParse(string $response): array
    {
        #deuxieme reponse
        $response_parts = explode(', ', $response);
       
        array_map(function ($value) use (&$response_parts) {
            $v = explode('=', $value);
            $response_parts[$v[0]] = trim($v[1], '" ');
        }, $response_parts);
        $response_parts = array_diff_key($response_parts, range(0, 15)); //enleve les cle num
        
        return $response_parts;
    }

    /**
     *  H(data) = MD5(data)
     *  KD(secret, data) = H(secret:data)
     *
     * response = KD( H(A1), nonce:nc:cnonce:qop:H(A2) ) si qop
     * response = KD( H(A1), nonce:H(A2) ) sinon
     *
     * A1 = username:realm:password si md5 ou null
     * A1 = H(username:realm:password):nonce:cnonce si md5-sess
     *
     * A2 = http-method:uri si qop = auth ou null
     * A2 = http-method:uri:H(entity) si auth-int
     *
     * si identification ok retour server:
     *      nextnonce: Valeur à utiliser pour les prochaines identifications dans ce domaine de protection.
     *      qop: (Optionnel) quality of protection appliquée à cette réponse. Ce paramètre doit avoir la même valeur que dans la requête du client.
     *      rspauth: (Si qop spécifié) Ce paramètre d'identification mutuel sert à prouver que le serveur connaît également l'utilisateur et son mot de passe.
     *              Il est calculé de la même manière que le paramètre response excepté pour la valeur de A2 où http-method est une chaîne vide.
     *      cnonce: (Si qop spécifié) Même valeur que dans la requête du client.
     *      nc: (Si qop spécifié) Même valeur que dans la requête du client.
     */
    public function digestValidate(array $user, array $data): bool
    {
        //$A1 = md5($data['username'] . ':' . $data['realm'] . ':' . $users[$data['username']]); //user:real:pass
        $A1 = $data['username'] . ':' . $data['realm'] . ':' . $user[$data['username']]; //user:real:pass
        $A2 = $_SERVER['REQUEST_METHOD'] . ':' . $data['uri'];
        $valid_response = md5(md5($A1) . ':' . $data['nonce'] . ':' . $data['nc'] . ':' . $data['cnonce'] . ':' . $data['qop'] . ':' . md5($A2));

        if ($valid_response === $data['response']) {
            return true;
        }
        return false;
    }
}
