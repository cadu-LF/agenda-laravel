<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\CreateNewContactRequest;
use App\Model\Address;
use App\Model\Category;
use App\Model\Contact;
use App\Services\Address\AddressServices;
use App\Services\Category\CategoryServices;
use App\Services\Contact\ContactServices;
use App\Services\Params\Address\CreateAddressServiceParams;
use App\Services\Params\Category\CreateCategoryServiceParams;
use App\Services\Params\Contact\CreateContactServiceParams;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = [
            'Cadu Lourenco',
            'Leonardo'
        ];

        return view('contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function store(CreateNewContactRequest $request)
    {
        $user = Auth::user();

        $addressParams = new CreateAddressServiceParams(
            $request->cep,
            $request->number,
            $request->street,
            $request->neighborhood,
            $request->city,
            $request->state,
            $request->country
        );

        if (Address::where('cep', $addressParams->cep)->get()->toArray()[0]['cep'] === $addressParams->cep) {
            echo 'endereço já cadastrado ';
        } else {
            Address::make($addressParams);
        }

        $addressId = Address::where('cep', $addressParams->cep)->get('id')->toArray()[0]['id'];
        var_dump($addressId);

        $categoryParams = new CreateCategoryServiceParams(
            $request->category
        );

        $categoryId = CategoryServices::getCategoryId($categoryParams->description);
        if ($categoryId < 0) {
            Category::make($categoryParams);
            echo "nova categoria criada";
        } else {
            echo 'categoria já cadastrada';
        }

        $contactParams = new CreateContactServiceParams(
            $request->fullName,
            $request->phone,
            $request->email,
            $request->note,
            $user->id,
            $addressId,
            $categoryId
        );

        #var_dump($contactParams);
        $contactId = ContactServices::getContactId($contactParams->phone);
/*
        if ($contactId < 0) {
            Contact::make($contactParams);
        } else {
            echo 'contato já cadastrado';
        }*/
    }

    public function edit()
    {
        return view('contacts.edit');
    }
}
