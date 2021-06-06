<?php

namespace App\Http\Controllers;

use Calendar;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Jobs\Entities\Job;
use Modules\Jobs\Entities\Task;
use Modules\Jobs\DataTables\DashboardJobDataTable;
use Modules\Jobs\DataTables\TaskDataTable;
use Intervention\Image\ImageManagerStatic as Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function image(){
        //dd(storage_path('app/public'));
        // open an image file
        $img = Image::make(storage_path('app/public').'/large11.jpg');

        // now you are able to resize the instance
        $img->resize(1092, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        // finally we save the image as a new file
        $img->save(storage_path('app/public').'/small11.jpg');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $request = new \stdClass();
        $request->filter = 'default';

        $dataArr = $this->getDashboard($request);
        return view('home',$dataArr);
    }
    public function filter(Request $request)
    {
        $dataArr = $this->getDashboard($request);
        return view('home',$dataArr);
    }

    private function getDashboard($request)
    {   
        if($request == null)
         session(['filter' => 'default']);
        else
         session(['filter' => $request->filter]);

        $date = Carbon::now();

        $events = [];

        switch ($request->filter) {
            case 'Day':
                $upcomingjobscollection = Job::whereBetween('status',[1,4])
                ->where('due_date',$date->toDateString());
                
                $completedjobscollection = Job::where('status',5)
                ->where('due_date',$date->toDateString());
                
                //$completedtasks = Task::whereIn('job_id',$completedJobIdArray)->where('status',1)->get();
                break;
            case 'Week':
                $upcomingjobscollection = Job::whereBetween('status',[1,4])
->whereBetween('due_date',[$date->startOfWeek()->toDateString(),$date->endOfWeek()->toDateString()]);

                $completedjobscollection = Job::where('status',5)
->whereBetween('due_date',[$date->startOfWeek()->toDateString(),$date->endOfWeek()->toDateString()]);
                break;
            case 'Month':
                $upcomingjobscollection = Job::whereBetween('status',[1,4])
->whereBetween('due_date',[$date->startOfWeek()->toDateString(),$date->endOfMonth()->toDateString()]);

                $completedjobscollection = Job::where('status',5)
->whereBetween('due_date',[$date->startOfWeek()->toDateString(),$date->endOfMonth()->toDateString()]);
                break;
            case 'Custom':
                session(['fromDate' => $request->fromDate]);
                session(['toDate' => $request->toDate]);
                $upcomingjobscollection = Job::whereBetween('status',[1,4])
                ->whereBetween('due_date',[$request->fromDate,$request->toDate]);

                $completedjobscollection = Job::where('status',5)
                ->whereBetween('due_date',[$request->fromDate,$request->toDate]);
                break;
            default:
                $upcomingjobscollection = Job::whereBetween('status',[1,4]);
                $completedjobscollection = Job::where('status',5);
                //$upcomingtasks = Task::where('status',0)->get();
        }

        $upcomingjobs =  $upcomingjobscollection->get();
        $upcomingJobIdArray = $upcomingjobscollection->pluck('id')->toArray();
        session(['upcomingJobIdArray' => $upcomingJobIdArray]);
        $upcomingtasks = Task::whereIn('job_id',$upcomingJobIdArray)->where('status',0)->get();
        $completedjobs =  $completedjobscollection->get();      
        //$completedJobIdArray = $completedjobscollection->pluck('id')->toArray();
        $completedtasks = Task::whereIn('job_id',$upcomingJobIdArray)->where('status',1)->get();
        

        //$completedtasks = Task::where('status',1)->get();
        

        $tableupcomingjobs = new DashboardJobDataTable();
        $tableupcomingjobs->setTableId('UpcomingjobsDatatable');
        $tableupcomingjobs->setAjaxSource(route('dashboard.upcomingjobs'));

        $tablecompletedjobs = new DashboardJobDataTable();
        $tablecompletedjobs->setTableId('CompletedjobsDatatable');
        $tablecompletedjobs->setAjaxSource(route('dashboard.completedjobs'));

        $tableupcomingtasks = new TaskDataTable();
        $tableupcomingtasks->setTableId('UpcomingtasksDatatable');
        $tableupcomingtasks->setAjaxSource(route('dashboard.upcomingtasks'));

        /*$tablecompletedtasks = new TaskDataTable();
        $tablecompletedtasks->setTableId('CompletedtasksDatatable');
        $tablecompletedtasks->setAjaxSource(route('dashboard.tablecompletedtasks'));*/

        if($upcomingjobs->count()) {
                    foreach ($upcomingjobs as $key => $value) {
                    $events[] = Calendar::event(
                    $value->excel_job_number,
                    true,
                    new \DateTime($value->due_date),
                    new \DateTime($value->due_date.' +1 day'),
                    null,

                    [
                        'color' => '#f44336',
                        'url' => route('jobs.show',$value->id),
                    ]
                );
            }
        }

        if($completedjobs->count()) {
                    foreach ($completedjobs as $key => $value) {
                    $events[] = Calendar::event(
                    $value->excel_job_number,
                    true,
                    new \DateTime($value->due_date),
                    new \DateTime($value->due_date.' +1 day'),
                    null,
                    // Add color and link on event
                    [
                        'color' => '#ff9900',
                        'url' => route('jobs.show',$value->id),
                    ]
                );
            }
        }

        /*if($upcomingtasks->count()) {
                    foreach ($upcomingtasks as $key => $value) {
                    $events[] = Calendar::event(
                    $value->task,
                    true,
                    new \DateTime($value->due_date),
                    new \DateTime($value->due_date.' +1 day'),
                    null,
                    // Add color and link on event
                    [
                        'color' => '#f05050',
                        'url' => 'https://www.google.com',
                    ]
                );
            }
        }*/

        $calendar = Calendar::addEvents($events);

        $dataArr = ['upcomingjobs' => $upcomingjobs, 
        'completedjobs' => $completedjobs,
        'upcomingtasks' => $upcomingtasks,
        'completedtasks' => $completedtasks, 
        'tableupcomingjobs' => $tableupcomingjobs->html(),
        'tablecompletedjobs' => $tablecompletedjobs->html(),
        'tableupcomingtasks' => $tableupcomingtasks->html(),
        'calendar' => $calendar
    ];
        return $dataArr;
    }
        private function getTableColumns($tableObj,$filter,$type){
        $date = Carbon::now();
        switch ($filter) {
            case 'Day':
                return $tableObj->with('type',$type)
                ->with('todate',$date->toDateString())->render('core::datatable');
            case 'Week':
                return $tableObj->with('type',$type)
                ->with('fromdate',$date->startOfWeek()->toDateString())
                ->with('todate',$date->endOfWeek()->toDateString())
                ->render('core::datatable');
            case 'Month':
                return $tableObj->with('type',$type)
                ->with('fromdate',$date->startOfMonth()->toDateString())
                ->with('todate',$date->endOfMonth()->toDateString())
                ->render('core::datatable');
            case 'Custom':
                $fromDate = session('fromDate');
                $toDate = session('toDate');
                return $tableObj->with('type',$type)
                ->with('fromdate',$fromDate)
                ->with('todate',$toDate)
                ->render('core::datatable');
            default:
                return $tableObj->with('type',$type)->render('core::datatable');
        }
    }
    public function getUpcomingJobs(DashboardJobDataTable $tableupcomingjobs)
    {   
        $filter = session('filter');

        return $this->getTableColumns($tableupcomingjobs,$filter,'upcoming');
        
    }
    public function getCompletedJobs(DashboardJobDataTable $tablecompletedjobs)
    {
        $filter = session('filter');

        return $this->getTableColumns($tablecompletedjobs,$filter,'completed');
    }
    public function getUpcomingTasks(TaskDataTable $tableupcomingtasks)
    {   
        $upcomingJobIdArray = session('upcomingJobIdArray');

        return $tableupcomingtasks->with('upcomingJobIdArray',$upcomingJobIdArray)->render('core::datatable');
    }
    /*public function index_()
    {
        $events = [];
        
        $upcomingjobs = Job::whereBetween('status',[1,4])->get();

        $completedjobs = Job::where('status',5)->get();

        $upcomingtasks = Task::where('status',0)->get();

        $completedtasks = Task::where('status',1)->get();

        $tableupcomingjobs = new DashboardJobDataTable();
        $tableupcomingjobs->setTableId('UpcomingjobsDatatable');
        $tableupcomingjobs->setAjaxSource(route('dashboard.upcomingjobs'));

        $tablecompletedjobs = new DashboardJobDataTable();
        $tablecompletedjobs->setTableId('CompletedjobsDatatable');
        $tablecompletedjobs->setAjaxSource(route('dashboard.completedjobs'));

        $tableupcomingtasks = new TaskDataTable();
        $tableupcomingtasks->setTableId('UpcomingtasksDatatable');
        $tableupcomingtasks->setAjaxSource(route('dashboard.upcomingtasks'));

        /*$tablecompletedtasks = new TaskDataTable();
        $tablecompletedtasks->setTableId('CompletedtasksDatatable');
        $tablecompletedtasks->setAjaxSource(route('dashboard.tablecompletedtasks'));*/

        /*if($upcomingjobs->count()) {
                    foreach ($upcomingjobs as $key => $value) {
                    $events[] = Calendar::event(
                    $value->excel_job_number,
                    true,
                    new \DateTime($value->due_date),
                    new \DateTime($value->due_date.' +1 day'),
                    null,
                    
                    [
                        'color' => '#f44336',
                        'url' => route('jobs.show',$value->id),
                    ]
                );
            }
        }

        if($completedjobs->count()) {
                    foreach ($completedjobs as $key => $value) {
                    $events[] = Calendar::event(
                    $value->excel_job_number,
                    true,
                    new \DateTime($value->due_date),
                    new \DateTime($value->due_date.' +1 day'),
                    null,
                    // Add color and link on event
                    [
                        'color' => '#ff9900',
                        'url' => route('jobs.show',$value->id),
                    ]
                );
            }
        }

        /*if($upcomingtasks->count()) {
                    foreach ($upcomingtasks as $key => $value) {
                    $events[] = Calendar::event(
                    $value->task,
                    true,
                    new \DateTime($value->due_date),
                    new \DateTime($value->due_date.' +1 day'),
                    null,
                    // Add color and link on event
                    [
                        'color' => '#f05050',
                        'url' => 'https://www.google.com',
                    ]
                );
            }
        }*/

        /*$calendar = Calendar::addEvents($events);

        $dataArr = ['upcomingjobs' => $upcomingjobs, 
        'completedjobs' => $completedjobs,
        'upcomingtasks' => $upcomingtasks,
        'completedtasks' => $completedtasks, 
        'tableupcomingjobs' => $tableupcomingjobs->html(),
        'tablecompletedjobs' => $tablecompletedjobs->html(),
        'tableupcomingtasks' => $tableupcomingtasks->html(),
        'calendar' => $calendar
    ];


        return view('home',$dataArr);
    }*/

}
