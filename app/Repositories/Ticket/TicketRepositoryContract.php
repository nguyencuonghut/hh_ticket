<?php
namespace App\Repositories\Ticket;

interface TicketRepositoryContract
{
    
    public function find($id);

    public function create($requestData);

    public function update($id, $requestData);

    public function destroy($request, $id);
}
