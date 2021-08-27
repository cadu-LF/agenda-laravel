<?php

namespace App\Exports;

use App\Model\Contact;
use App\Services\Contact\ContactServices;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ContactsExport implements FromCollection, WithCustomStartCell
{

    protected $contactService;

    public function __construct(ContactServices $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $user = Auth::user();
        $contacts = $this->contactService->getContactByUser($user->id);
        return $contacts->data;
    }

    public function startCell(): string
    {
        return 'B2';
    }
}
