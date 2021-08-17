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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{

    /**
     * Inicializando Service
     */
    protected $addressService;

    public function __construct(
        AddressServices $addressService
    ) {
        $this->addressService = $addressService;
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

        $addressId = $this->addressService->checkAddress($addressParams);
        var_dump($addressId);

        $categoryParams = new CreateCategoryServiceParams(
            $request->category
        );

        if (Category::where('description', $categoryParams->description)->get()->count() > 0) {
            echo 'categoria já cadastrada ';
        } else {
            Category::make($categoryParams);
            echo "nova categoria criada ";
        }

        $categoryId = Category::where('description', $categoryParams->description)->get('id')->toArray()[0]['id'];
        var_dump($categoryId);

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

        if (Contact::where('phone', $contactParams->phone)->get()->count() > 0) {
            echo 'contato já cadastrado ';
        } else {
            Contact::make($contactParams);
            echo 'novo contato cadastrado ';
        }
    }

    public function edit(Request $request, $id)
    {
        // preciso pegar o id no url e filtrar o contato com aquele id
        $contact = Contact::find($id);

        return view('contacts.edit', compact('contact'));
    }
}
