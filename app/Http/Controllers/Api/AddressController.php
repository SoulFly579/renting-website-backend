<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Address\CreateRequest;
use App\Http\Requests\Address\UpdateRequest;
use App\Models\Address;

class AddressController extends ApiController
{
    public function index()
    {
        return $this->successResponse(Address::auth()->get());
    }

    public function store(CreateRequest $request)
    {
        $address = Address::create($request->validated());
        return $this->successResponse($address,"Başarılı bir şekilde adress eklenmiştir.",201);
    }

    public function edit(Address $address)
    {
        return $this->successResponse($address);
    }

    public function update(Address $address,UpdateRequest $request)
    {
        $address->update($request->validated());
        return $this->successResponse($address,"Başarılı bir şekilde address güncellenmiştir.",201);
    }

    public function destroy(Address $address)
    {
        $address->delete();
        return $this->successResponse(null,"Adres başarılı bir şekilde silinmiştir.");
    }
}
