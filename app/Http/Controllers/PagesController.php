<?php
namespace App\Http\Controllers;

use App\Models\Department;
use DB;
use Carbon;
use App\Http\Requests;
use App\Repositories\Task\TaskRepositoryContract;
use App\Repositories\Lead\LeadRepositoryContract;
use App\Repositories\User\UserRepositoryContract;
use App\Repositories\Client\ClientRepositoryContract;
use App\Repositories\Setting\SettingRepositoryContract;
use App\Repositories\Ticket\TicketRepositoryContract;

class PagesController extends Controller
{

    protected $users;
    protected $clients;
    protected $settings;
    protected $tasks;
    protected $leads;
    protected $tickets;

    public function __construct(
        UserRepositoryContract $users,
        ClientRepositoryContract $clients,
        SettingRepositoryContract $settings,
        TaskRepositoryContract $tasks,
        LeadRepositoryContract $leads,
        TicketRepositoryContract $tickets
    ) {
        $this->users = $users;
        $this->clients = $clients;
        $this->settings = $settings;
        $this->tasks = $tasks;
        $this->leads = $leads;
        $this->tickets = $tickets;
    }

    /**
     * Dashobard view
     * @return mixed
     */
    public function dashboard()
    {

      /**
         * Other Statistics
         *
         */
        $companyname = $this->settings->getCompanyName();
        $users = $this->users->getAllUsers();
        $totalClients = $this->clients->getAllClientsCount();
        $totalTimeSpent = $this->tasks->totalTimeSpent();

     /**
      * Statistics for all-time tasks.
      *
      */
        $alltasks = $this->tasks->tasks();
        $allCompletedTasks = $this->tasks->allCompletedTasks();
        $totalPercentageTasks = $this->tasks->percantageCompleted();

     /**
      * Statistics for today tasks.
      *
      */
        $completedTasksToday =  $this->tasks->completedTasksToday();
        $createdTasksToday = $this->tasks->createdTasksToday();

     /**
      * Statistics for tasks this month.
      *
      */
         $taskCompletedThisMonth = $this->tasks->completedTasksThisMonth();
    

     /**
      * Statistics for tasks each month(For Charts).
      *
      */
        $createdTasksMonthly = $this->tasks->createdTasksMothly();
        $completedTasksMonthly = $this->tasks->completedTasksMothly();

     /**
      * Statistics for all-time Leads.
      *
      */
     
        $allleads = $this->leads->leads();
        $allCompletedLeads = $this->leads->allCompletedLeads();
        $totalPercentageLeads = $this->leads->percantageCompleted();
     /**
      * Statistics for today leads.
      *
      */
        $completedLeadsToday = $this->leads->completedLeadsToday();
        $createdLeadsToday = $this->leads->completedLeadsToday();

     /**
      * Statistics for leads this month.
      *
      */
        $leadCompletedThisMonth = $this->leads->completedLeadsThisMonth();

     /**
      * Statistics for leads each month(For Charts).
      *
      */
        $completedLeadsMonthly = $this->leads->createdLeadsMonthly();
        $createdLeadsMonthly = $this->leads->completedLeadsMonthly();
        $allDepartmentTickets = $this->tickets->allDepartmentStatistic();
        $allReasonTickets = $this->tickets->allReasonStatistic();
        $allDepartmentStateTickets = $this->tickets->allDepartmentStateStatistic();
        $allDepartmentReasonTickets = $this->tickets->allDepartmentReasonStatistic();
        $allEffectivenessTickets = $this->tickets->allEffectivenessStatistic();
        $createdTicketsMonthly = $this->tickets->createdTicketsMothly();
        $completedTicketsMonthly = $this->tickets->completedTicketsMothly();
        $departments = Department::all()->pluck('name', 'id');
        $department_name = 'Tất cả';
       
        return view('pages.dashboard', compact(
            'completedTasksToday',
            'completedLeadsToday',
            'createdTasksToday',
            'createdLeadsToday',
            'createdTasksMonthly',
            'completedTasksMonthly',
            'completedLeadsMonthly',
            'createdLeadsMonthly',
            'taskCompletedThisMonth',
            'leadCompletedThisMonth',
            'totalTimeSpent',
            'totalClients',
            'users',
            'companyname',
            'alltasks',
            'allCompletedTasks',
            'totalPercentageTasks',
            'allleads',
            'allCompletedLeads',
            'totalPercentageLeads',
            'allDepartmentTickets',
            'allReasonTickets',
            'allDepartmentStateTickets',
            'allDepartmentReasonTickets',
            'allEffectivenessTickets',
            'createdTicketsMonthly',
            'completedTicketsMonthly',
            'departments',
            'department_name'
        ));
    }
}
