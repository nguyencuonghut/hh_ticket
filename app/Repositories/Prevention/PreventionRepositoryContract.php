<?php
namespace App\Repositories\Prevention;

interface PreventionRepositoryContract
{
    
    public function find($id);

    public function create($ticket_id, $requestData);

    public function update($id, $requestData);

    public function destroy($request, $id);
}
