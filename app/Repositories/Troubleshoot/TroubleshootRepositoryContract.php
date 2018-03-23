<?php
namespace App\Repositories\Troubleshoot;

interface TroubleshootRepositoryContract
{
    
    public function find($id);

    public function create($ticket_id, $requestData);

    public function update($id, $requestData);

    public function destroy($request, $id);
}
