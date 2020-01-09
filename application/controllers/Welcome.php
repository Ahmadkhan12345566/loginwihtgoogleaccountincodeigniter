<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        require_once 'vendor/autoload.php';
        // init configuration
        $clientID = '269203207749-eevfqm900tdr13gepu430jkogpuor23i.apps.googleusercontent.com';
        $clientSecret = 'LQ1_uCK_MLI7vyeFFid9I7Lo';
        $redirectUri = 'http://localhost/youtubedemo/';

        // create Client Request to access Google API
        $client = new Google_Client();
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        //  Set the scopes required for the API you are going to call
        $client->addScope("email");
        $client->addScope("profile");

// authenticate code from Google OAuth Flow
        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token['access_token']);

            // get profile info
            $google_oauth = new Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();
            $email = $google_account_info->email;
            $name = $google_account_info->name;
            echo $name;
            echo $email;

            // now you can use this profile info to create account in your website and make user logged in.
        } else {
            echo "<a href='" . $client->createAuthUrl() . "'>Google Login</a>";
        }
	}
}
