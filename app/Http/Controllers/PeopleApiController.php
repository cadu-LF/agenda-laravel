<?php

namespace App\Http\Controllers;

use App\Services\People\PeopleApiServices;
use Illuminate\Http\Request;

class PeopleApiController
{
    protected $peopleService;
    protected $contactService;

    public function __construct(
        PeopleApiServices $peopleApiService
    ) {
        $this->peopleService = $peopleApiService;
    }

    public function import()
    {
        $client = $this->peopleService->getClient();

        $tokenPath = 'token.json';

        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        $authUrl = $client->createAuthUrl();

        return redirect($authUrl);
    }

    public function importCode(Request $request)
    {
        $authCode = $request->input('code');

        $service = $this->peopleService->getService($authCode);

        $optParams = array(
            'pageSize' => 1000,
            'resourceName' => 'people/me',
            'personFields' => 'names,emailAddresses,phoneNumbers',
        );

        $results = $service->people_connections->listPeopleConnections('people/me', $optParams);

        $this->peopleService->saveImpotedContacts(auth()->user()->id, $results);

        return redirect('/contatos');
    }
}
