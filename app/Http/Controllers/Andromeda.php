<?php
namespace App\Http\Controllers;

use App\Applicant\Applicant;
use Illuminate\Http\Request;

class Andromeda extends Controller {
    public function helpme(Request $request) {
        $token = (new \Lcobucci\JWT\Builder())->issuedBy(config('app.url'))// Configures the issuer (iss claim)
        ->canOnlyBeUsedBy(config('uiconfig.andromeda_url'))// Configures the audience (aud claim)
        ->issuedAt(time())// Configures the time that the token was issue (iat claim)
        ->canOnlyBeUsedAfter(time() - 50000)// Configures the time that the token can be used (nbf claim)
        ->expiresAt(time() + 50000); // Configures the expiration time of the token (nbf claim)
        
        $visitingApplicant = new Applicant();
        if ($visitingApplicant->isLoggedIn()) {
            $applicant = Applicant::current();
            $token->set('userdata', ['name' => $applicant->title . $applicant->fname . ' ' . $applicant->lname, 'id' => $applicant->citizen_id, 'email' => $applicant->email]);
        }
        
        $token = $token->sign((new \Lcobucci\JWT\Signer\Hmac\Sha256()), config('uiconfig.andromeda_key'))->getToken(); // Retrieves the generated token
        return redirect(config('uiconfig.andromeda_url') . '/helpme?attach=' . urlencode($token));
    }
    
}
