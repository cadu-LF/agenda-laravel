<?php

namespace App\Http\Controllers;

use App\Exports\ContactsExport;
use PDF;
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
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;

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
        // exemplo de pdf -> adminController -> relatorioUsuariosPadrao
        // exemplo excel
        $search = $request->query('search');
        $user = Auth::user();
        $contacts = $this->contactServices->getContactByUser($user->id);
        $contacts = $contacts->data->toArray();

        $categories = $this->categoryServices->getAllCategories();

        if ($search != null) {
            $catId = $this->categoryServices->getCategoryId($search);
            $filtered = $this->contactServices->filter($catId, $user->id);
            $filtered = $filtered->data->toArray();
            $contacts = $filtered;
        }

        return view('contacts.index', compact('contacts', 'search', 'categories'));
    }


    public function create()
    {
        return view('contacts.create');
    }

    public function store(CreateNewContactRequest $request)
    {
        $user = Auth::user();
        dump($request->description);
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

        $categoryParams = new CreateCategoryServiceParams(
            $request->description
        );

        $categoryResponse = $this->categoryServices->createCategory($categoryParams);

        $contactParams = new CreateContactServiceParams(
            $request->fullName,
            $request->phone,
            $request->email,
            $request->note,
            $user->id,
            $addressResponse->data->toArray()[0]['id'],
            $categoryResponse->data->toArray()[0]['id']
        );


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
        $contact = $contact->data->toArray();

        $address = null;
        $category = null;

        if ($contact['id_address'] != null) {
            $address = $this->addressServices->getAddress($contact['id_address']);
            $address = $address->data->toArray();
        }

        if ($contact['id_category'] != null) {
            $category = $this->categoryServices->getCategory($contact['id_category']);
            $category = $category->data->toArray();
        }
        return view('contacts.edit', compact('contact', 'address', 'category'));
    }

    public function update(
        UpdateContactRequest $request
    ) {

        $user = Auth::user();

        $categoryId = '';
        if ($request->id_category == null) {
            $categoryParams = new CreateCategoryServiceParams(
                $request->category
            );

            $categoryResponse = $this->categoryServices->createCategory($categoryParams);
            $categoryId = $categoryResponse->data->toArray()[0]['id'];
        } else {
            $categoryParams = new UpdateCategoryServiceParams(
                $request->id_category,
                $request->category
            );

            $categoryResponse = $this->categoryServices->updateCategory($categoryParams);
            $categoryId = $categoryResponse->data->toArray()['id'];
        }

        $addressId = '';
        if ($request->id_address == null) {
            $addressParams = new CreateAddressServiceParams(
                $request->cep,
                $request->number,
                $request->street,
                $request->neighborhood,
                $request->city,
                $request->state,
                $request->country
            );

            $addressResponse = $this-> addressServices->createAddress($addressParams);
            $addressId = $addressResponse->data->toArray()[0]['id'];
        } else {
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

            $addressResponse = $this->addressServices->updateAddress($addressParams);
            $addressId = $addressResponse->data->toArray()['id'];
        }

        $contactParams = new UpdateContactServiceParams(
            (int) $request->id_contact,
            $request->fullname,
            $request->phone,
            $request->email,
            $request->note,
            $user->id,
            (int) $categoryId,
            (int) $addressId
        );

        $this->contactServices->updateContact($contactParams);
        return redirect('/contatos');
    }

    public function destroy($id)
    {
        $this->contactServices->deleteContact($id);
        return redirect('/contatos');
    }

    public function mostraPdf()
    {
        $user = Auth::user();
        $contacts = $this->contactServices->getContactByUser($user->id);
        $contacts = $contacts->data->toArray();

        $pdf = App::make('snappy.pdf.wrapper');
        $view = view('templates.pdf', compact('contacts'));
        $pdf->loadHTML($view);
        return $pdf->inline();
    }

    public function downExcel()
    {
        return Excel::download(new ContactsExport(), 'contacts.xls');
    }
}
