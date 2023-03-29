<?php

use allejo\VCR\VCRCleaner;
use VCR\VCR;
use VCRAccessories\CassetteScrubber;
use VCRAccessories\CassetteSetup;

const CASSETTE_DIR = 'tests/cassettes';
CassetteSetup::setupCassetteDirectory(CASSETTE_DIR);

VCR::configure()->setCassettePath(CASSETTE_DIR)
    ->setStorage('yaml')
    ->setMode('once')
    ->setWhiteList(['vendor/guzzle']);

$scrubbedString = '<REDACTED>';
$scrubbedArray = []; // In PHP, this could be either an array or object

define('RESPONSE_BODY_SCRUBBERS', [
    ['client_ip', $scrubbedString],
    ['credentials', $scrubbedArray],
    ['email', $scrubbedString],
    ['fields', $scrubbedArray],
    ['key', $scrubbedString],
    ['phone_number', $scrubbedString],
    ['phone', $scrubbedString],
    ['test_credentials', $scrubbedArray],
]);

VCRCleaner::enable([
    'request' => [
        'ignoreHeaders' => [
            'Authorization',
            'User-Agent',
        ],
        'ignoreQueryFields' => [
            'card',
        ]
    ],
    'response' => [
        'bodyScrubbers' => [
            function ($responseBody) {
                $responseBodyJson = json_decode($responseBody, true);
                $responseBodyEncoded = CassetteScrubber::scrubCassette(RESPONSE_BODY_SCRUBBERS, $responseBodyJson);

                // Re-encode the data so we can properly store it in the cassette
                return json_encode($responseBodyEncoded);
            }
        ],
    ],
]);

VCR::turnOn();
