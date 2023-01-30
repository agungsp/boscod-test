<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransferMappingRequest;
use App\Http\Requests\UpdateTransferMappingRequest;
use App\Http\Resources\ApiResource;
use App\Models\AdminTransferMapping;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransferMappingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transferMappings = AdminTransferMapping::cursorPaginate(10)->toArray();
        return new ApiResource($transferMappings, true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTransferMappingRequest $request)
    {
        $transferMapping = AdminTransferMapping::create(
            $request->validated()
        );

        if (!$transferMapping) {
            return response(
                new ApiResource(resource: [], success: false, message: "Something went wrong!"),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return response(
            new ApiResource(resource: $transferMapping, message: "Data has been created!")
        );
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @param integer $transferMappingId
     * @return \Illuminate\Http\Response
     */
    public function show(AdminTransferMapping $transferMapping)
    {
        return new ApiResource($transferMapping);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @param integer $transferMappingId
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransferMappingRequest $request, AdminTransferMapping $transferMapping)
    {
        $transferMappingId = $transferMapping->id;
        $transferMapping = $transferMapping->update(
            $request->validated()
        );

        if (!$transferMapping) {
            return response(
                new ApiResource(resource: [], success: false, message: "Something went wrong!"),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $transferMapping = AdminTransferMapping::find($transferMappingId);

        return response(
            new ApiResource(resource: $transferMapping, message: "Data has been updated!")
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminTransferMapping $transferMapping)
    {
        $transferMapping = $transferMapping->delete();

        if (!$transferMapping) {
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
