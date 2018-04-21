<?php

use Illuminate\Database\Seeder;
use App\Models\Permissions;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * User Permissions
         */
        
        $createUser = new Permissions;
        $createUser->display_name = 'Tạo người dùng';
        $createUser->name = 'user-create';
        $createUser->description = 'Permission to create user';
        $createUser->save();

        $updateUser = new Permissions;
        $updateUser->display_name = 'Sửa người dùng';
        $updateUser->name = 'user-update';
        $updateUser->description = 'Permission to update user';
        $updateUser->save();

        $deleteUser = new Permissions;
        $deleteUser->display_name = 'Xóa người dùng';
        $deleteUser->name = 'user-delete';
        $deleteUser->description = 'Permission to update delete';
        $deleteUser->save();


         /**
         * Client Permissions
         */
        
        $createClient = new Permissions;
        $createClient->display_name = 'Tạo khách hàng';
        $createClient->name = 'client-create';
        $createClient->description = 'Permission to create client';
        $createClient->save();

        $updateClient = new Permissions;
        $updateClient->display_name = 'Sửa khách hàng';
        $updateClient->name = 'client-update';
        $updateClient->description = 'Permission to update client';
        $updateClient->save();

        $deleteClient = new Permissions;
        $deleteClient->display_name = 'Xóa khách hàng';
        $deleteClient->name = 'client-delete';
        $deleteClient->description = 'Permission to delete client';
        $deleteClient->save();

         /**
         * Tasks Permissions
         */
        
        $createTask = new Permissions;
        $createTask->display_name = 'Tạo công việc';
        $createTask->name = 'task-create';
        $createTask->description = 'Permission to create task';
        $createTask->save();

        $updateTask = new Permissions;
        $updateTask->display_name = 'Sửa công việc';
        $updateTask->name = 'task-update';
        $updateTask->description = 'Permission to update task';
        $updateTask->save();

         /**
         * Leads Permissions
         */
        
        $createLead = new Permissions;
        $createLead->display_name = 'Tạo chỉ đạo';
        $createLead->name = 'lead-create';
        $createLead->description = 'Permission to create lead';
        $createLead->save();

        $updateLead = new Permissions;
        $updateLead->display_name = 'Sửa chỉ đạo';
        $updateLead->name = 'lead-update';
        $updateLead->description = 'Permission to update lead';
        $updateLead->save();
    }
}
