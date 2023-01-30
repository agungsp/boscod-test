<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateContactRequest;
use App\Http\Requests\Api\UpdateContactRequest;
use App\Http\Resources\ApiResource;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::thisAuth()->cursorPaginate(10)->toArray();
        return new ApiResource($contacts, true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateContactRequest $request, User $user)
    {
        $contact = Contact::create(
            array_merge($request->validated(), ['user_id' => $user->id])
        );

        if (!$contact) {
            return response(
                new ApiResource(resource: [], success: false, message: "Something went wrong!"),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return response(
            new ApiResource(resource: $contact, message: "Data has been created!")
        );
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @param integer $contactId
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, int $contactId)
    {
        $contact = Contact::thisAuth()->where('id', $contactId)->first();
        return new ApiResource($contact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @param integer $contactId
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactRequest $request, User $user, int $contactId)
    {
        $contact = Contact::thisAuth()->where('id', $contactId)->update(
            $request->validated()
        );

        if (!$contact) {
            return response(
                new ApiResource(resource: [], success: false, message: "Something went wrong!"),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $contact = Contact::find($contactId);

        return response(
            new ApiResource(resource: $contact, message: "Data has been updated!")
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, int $contactId)
    {
        $contact = Contact::thisAuth()->where('id', $contactId)->delete();

        if (!$contact) {
            return response(
                new ApiResource(resource: [], success: false, message: "Something went wrong!"),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return response(
            new ApiResource(resource: [], message: "Data has been deleted!")
        );
    }
}
