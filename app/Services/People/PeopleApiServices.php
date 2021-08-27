<?php

namespace App\Services\People;

use Google_Client;
use Google_Service_PeopleService;
use App\Repositories\ContactRepositoryEloquent;

class PeopleApiServices
{
    protected $contactRepository;

    public function __construct(ContactRepositoryEloquent $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }


    public function getClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('agenda');
        $client->setScopes(Google_Service_PeopleService::CONTACTS_READONLY);
        // 'client_secret_400231053657-ag0104d67t80smp2diiq4kmgp7gfpbdh.apps.googleusercontent.com.json'
        $client->setAuthConfig(storage_path() . '/credentials.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        return $client;
    }

    public function getService($authCode)
    {
        $client = $this->getClient();

        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

        $client->setAccessToken($accessToken);

        // Check to see if there was an error.
        if (array_key_exists('error', $accessToken)) {
            throw new Exception(join(', ', $accessToken));
        }

        $service = new Google_Service_PeopleService($client);

        return $service;
    }

    public function saveImpotedContacts($userId, $results)
    {
        if (count($results->getConnections()) == 0) {
            print "No connections found.\n";
            return;
        }
        foreach ($results->getConnections() as $person) {
            $contact = [];

            if (count($person->getNames()) != 0 && count($person->getEmailAddresses()) != 0) {
                $names = $person['names']; //$names = $person->getNames();
                $name = $names[0]['displayName'];

                $emails = $person['emailAddresses'];
                $email = $emails[0]['value'];

                $phone = null;
                if (count($person->getPhoneNumbers()) != 0) {
                    $phones = $person['phoneNumbers'];
                    $phone = $phones[0]['value'];
                }

                $contact = [
                    'fullname' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'id_user' => $userId,
                    'id_address' => null,
                    'id_category' => null
                ];

                $this->contactRepository->create($contact);
            }
        }
    }
}
