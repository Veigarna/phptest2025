<?php
require 'vendor/autoload.php';

// Include Google Cloud dependencies using Composer
use Google\Cloud\RecaptchaEnterprise\V1\Client\RecaptchaEnterpriseServiceClient;
use Google\Cloud\RecaptchaEnterprise\V1\Event;
use Google\Cloud\RecaptchaEnterprise\V1\Assessment;
use Google\Cloud\RecaptchaEnterprise\V1\CreateAssessmentRequest;
use Google\Cloud\RecaptchaEnterprise\V1\TokenProperties\InvalidReason;

/**
  * Create an assessment to analyze the risk of a UI action.
  * @param string $recaptchaKey The reCAPTCHA key associated with the site/app
  * @param string $token The generated token obtained from the client.
  * @param string $project Your Google Cloud Project ID.
  * @param string $action Action name corresponding to the token.
  */
function create_assessment(string $recaptchaKey, string $token, string $project, string $action): bool {
    $client = new RecaptchaEnterpriseServiceClient([
        'credentials' => __DIR__ . '/service-account.json'
    ]);

    $projectName = $client->projectName($project);
    $event = (new Event())->setSiteKey($recaptchaKey)->setToken($token);
    $assessment = (new Assessment())->setEvent($event);
    $request = (new CreateAssessmentRequest())->setParent($projectName)->setAssessment($assessment);

    try {
        $response = $client->createAssessment($request);

        if (!$response->getTokenProperties()->getValid()) {
            return false;
        }

        if ($response->getTokenProperties()->getAction() !== $action) {
            return false;
        }
        if ($response->getRiskAnalysis()->getScore() < 0.5) {
            error_log('reCAPTCHA score is too low: ' . $response->getRiskAnalysis()->getScore());
            return false;
        }

        return true; // token is valid and action matches
    } catch (Exception $e) {
        error_log('reCAPTCHA error: ' . $e->getMessage());
        return false;
    }
}


?>