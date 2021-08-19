<?php

namespace App\Http\Controllers;

use App\Model\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Address\AddressServices;
use App\Services\Contact\ContactServices;
use App\Services\Category\CategoryServices;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\Http\Requests\Contact\CreateNewContactRequest;
use App\Services\Params\Address\CreateAddressServiceParams;
use App\Services\Params\Address\UpdateAddressServiceParams;
use App\Services\Params\Contact\CreateContactServiceParams;
use App\Services\Params\Category\CreateCategoryServiceParams;
use App\Services\Params\Category\UpdateCategoryServiceParams;
use App\Services\Params\Contact\UpdateContactServiceParams;

class ContactController extends Controller
{

    /**
     * Inicializando Services
     */
    protected $addressServices;
    protected $categoryServices;
    protected $contactServices;

    public function __construct(
        AddressServices $addressServices,
        CategoryServices $categoryServices,
        ContactServices $contactServices
    ) {
        $this->addressServices = $addressServices;
        $this->categoryServices = $categoryServices;
        $this->contactServices = $contactServices;
    }


    public function index(Request $request)
    {
        $search = $request->query('search');
        $user = Auth::user();
        $contacts = $this->contactServices->getContactByUser($user->id);
        $contacts = $contacts->data->toArray();

        if ($search != null) {
            $catId = $this->categoryServices->getCategoryId($search);
            $filtered = $this->contactServices->filter($catId, $user->id);
            $filtered = $filtered->data->toArray();
            $contacts = $filtered;
        }

        return view('contacts.index', compact('contacts', 'search'));
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

        $addressResponse = $this->addressServices->createAddress($addressParams);
        echo $addressResponse->message;
        var_dump($addressResponse->data->toArray());

        $categoryParams = new CreateCategoryServiceParams(
            $request->category
        );

        $categoryResponse = $this->categoryServices->createCategory($categoryParams);
        echo $categoryResponse->message;
        var_dump($categoryResponse->data->toArray());

        $contactParams = new CreateContactServiceParams(
            $request->fullName,
            $request->phone,
            $request->email,
            $request->note,
            $user->id,
            $addressResponse->data->toArray()[0]['id'],
            $categoryResponse->data->toArray()[0]['id']
        );

        #var_dump($contactParams);

        $contactResponse = $this->contactServices->createContact($contactParams);
        if ($contactResponse->success) {
            echo $contactResponse->message;
            return redirect('/contatos');
        } else {
            echo "Algo deu errado - Tente novamente";
        }
    }

    public function edit(Request $request, $id)
    {
        $contact = $this->contactServices->getFullContact($id);
        $address = $this->addressServices->getAddress($contact->data->toArray()['id_address']);
        $category = $this->categoryServices->getCategory($contact->data->toArray()['id_category']);
        return view('contacts.edit', compact('contact', 'address', 'category'));
    }

    public function update(
        UpdateContactRequest $request
    ) {
        $user = Auth::user();

        $categoryParams = new UpdateCategoryServiceParams(
            $request->id_category,
            $request->category
        );

        $this->categoryServices->updateCategory($categoryParams);

        $addressParams = new UpdateAddressServiceParams(
            $request->id_address,
            $request->cep,
            $request->number,
            $request->street,
            $request->neighborhood,
            $request->city,
            $request->state,
            $request->country
        );

        $this->addressServices->updateAddress($addressParams);

        $contactParams = new UpdateContactServiceParams(
            (int) $request->id_contact,
            $request->fullname,
            $request->phone,
            $request->email,
            $request->note,
            $user->id,
            (int) $request->id_address,
            (int) $request->id_category
        );

        $this->contactServices->updateContact($contactParams);
        return redirect('/contatos');
    }

    public function destroy($id)
    {
        $this->contactServices->deleteContact($id);
        return redirect('/contatos');
    }
}
