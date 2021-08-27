<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use App\Services\Contact\ContactServices;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ContactsExport implements FromView, WithCustomStartCell
{

    protected $contactService;

    public function __construct(ContactServices $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $user = Auth::user();
        $contacts = $this->contactService->getContactByUser($user->id);
        $contacts = $contacts->data;
        return view('templates.excel', [
            'contacts' => $contacts
        ]);
    }

    public function startCell(): string
    {
        return 'B2';
    }
}
