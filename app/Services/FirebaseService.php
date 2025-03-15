<?php
   
   namespace App\Services;
use GuzzleHttp\Client;
use Google\Auth\OAuth2;

   
   
    class FirebaseService{
        protected $client;
        protected $projectId;
        protected $auth;
        
        public function __construct()
        {
            $this->projectId = 'herody-bf512'; // Your project ID
            $this->client = new Client();
            $this->auth = $this->getOAuthToken();
        }
        
        protected function getOAuthToken()
        {
            $keyFile = base_path('service-account-file.json');
          //  var_dump($this->auth);exit;
            $oauth = new OAuth2([
                'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
                'signingAlgorithm' => 'HS256',
                'keyFile' => $keyFile,
            ]);
             //var_dump($oauth);exit;
            return $oauth->fetchAuthToken()['access_token'];
        }
        
        public function sendMessage($message)
        {
            $response = $this->client->post("https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->auth,
                    'Content-Type' => 'application/json',
                ],
                'json' => $message,
            ]);
            return json_decode($response->getBody(), true);
        }
    }
   
   ?>