<?php

namespace App\Exports;

use App\Model\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ContactsExport implements FromCollection, WithCustomStartCell
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Contact::all();
    }

    public function startCell(): string
    {
        return 'B2';
    }
}
