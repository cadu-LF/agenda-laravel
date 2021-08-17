<?php

namespace App\Services\Contact;

use App\Model\Contact;

class ContactServices
{
    public static function getContactId($phone)
    {
        $contacts = Contact::all();

        foreach ($contacts as $contact) {
            if ($contact['phone'] === $phone) {
                return $contact['id'];
            }
        }
        return -1;
    }
}
