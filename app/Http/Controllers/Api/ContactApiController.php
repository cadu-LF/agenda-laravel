<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Address\AddressServices;
use App\Services\API\APIContactServices;
use App\Services\Contact\ContactServices;
use App\Services\Category\CategoryServices;
use App\Services\Params\Address\CreateAddressServiceParams;
use App\Services\Params\Address\UpdateAddressServiceParams;
use App\Services\Params\Contact\CreateContactServiceParams;
use App\Services\Params\Contact\UpdateContactServiceParams;
use App\Services\Params\Category\CreateCategoryServiceParams;
use App\Services\Params\Category\UpdateCategoryServiceParams;

class ContactApiController extends Controller
{

    protected $contactService;
    protected $addressService;
    protected $categoryService;

    public function __construct(
        APIContactServices $contactService,
        AddressServices $addressService,
        CategoryServices $categoryService
    ) {
        $this->contactService = $contactService;
        $this->addressService = $addressService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $contacts = $this->contactService->getAllContacts();
        return response()->json($contacts);
    }

    public function store(Request $request)
    {
        $addressParams = new CreateAddressServiceParams(
            $request->cep,
            $request->number,
            $request->street,
            $request->neighborhood,
            $request->city,
            $request->state,
            $request->country
        );

        $aResponse = $this->addressService->createAddress($addressParams);
        $aId = $aResponse->data->toArray()[0]['id'];

        $categoryParams = new CreateCategoryServiceParams(
            $request->description
        );

        $cResponse = $this->categoryService->createCategory($categoryParams);
        $cId = $cResponse->data->toArray()[0]['id'];

        $contactParams = new CreateContactServiceParams(
            $request->fullname,
            $request->phone,
            $request->email,
            $request->note,
            $request->id_user,
            (int) $aId,
            (int) $cId
        );

        $conResponse = $this->contactService->createContact($contactParams);
        return response()->json($conResponse);
    }

    public function destroy($id)
    {
        $resp = $this->contactService->deleteContact($id);
        return response()->json($resp);
    }

    public function update(
        Request $request,
        $id
    ) {
        $categoryId = '';
        if ($request->id_category == null) {
            $categoryParams = new CreateCategoryServiceParams(
                $request->category
            );

            $categoryResponse = $this->categoryService->createCategory($categoryParams);
            $categoryId = $categoryResponse->data->toArray()[0]['id'];
        } else {
            $categoryParams = new UpdateCategoryServiceParams(
                $request->id_category,
                $request->category
            );

            $categoryResponse = $this->categoryService->updateCategory($categoryParams);
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

            $addressResponse = $this-> addressService->createAddress($addressParams);
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

            $addressResponse = $this->addressService->updateAddress($addressParams);
            $addressId = $addressResponse->data->toArray()['id'];
        }

        $contactParams = new UpdateContactServiceParams(
            (int) $id,
            $request->fullname,
            $request->phone,
            $request->email,
            $request->note,
            $request->id_user,
            (int) $addressId,
            (int) $categoryId
        );

        $response = $this->contactService->updateContact($contactParams);
        return response()->json($response);
    }

    public function show($id)
    {
        $response = $this->contactService->getFullContact($id);

        return response()->json($response);
    }
}
