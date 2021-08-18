<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\CreateNewContactRequest;
use App\Model\Contact;
use App\Services\Address\AddressServices;
use App\Services\Category\CategoryServices;
use App\Services\Contact\ContactServices;
use App\Services\Params\Address\CreateAddressServiceParams;
use App\Services\Params\Category\CreateCategoryServiceParams;
use App\Services\Params\Contact\CreateContactServiceParams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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


    public function index()
    {
        $user = Auth::user();
        $contacts = Contact::where('id_user', $user->id)->get();


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

        return view('contacts.edit', compact('contact'));
    }
}
