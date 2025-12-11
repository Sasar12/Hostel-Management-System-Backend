<?php

class Auth
{



    public function __construct(private UserGateway $user_gateway, private Jwt $JwtCtrl)
    {
    }



    public function authenticateJWTToken(): bool
    {
        $headers = apache_request_headers();
        
        // echo $headers['authorization'];
        if (!preg_match("/^Bearer\s+(.*)$/", $headers["authorization"], $matches)) {
            http_response_code(400);
            echo json_encode(["message" => "incomplete authorization header"]);
            return false;
        }

        try {
            $data = $this->JwtCtrl->decode($matches[1]);
        } catch (InvalidSignatureException) {

            http_response_code(401);
            echo json_encode(["message" => "invalid signature"]);
            return false;
        } catch (Exception $e) {

            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
            return false;
        }



        return true;
    }
}