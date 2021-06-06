<?php

namespace Modules\Jobs\DataTables;

use Modules\Jobs\Entities\Job;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Illuminate\Support\Facades\Auth;

class DashboardJobDataTable extends DataTable
{   
    protected $sourceRoute;

    protected $tableId;

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function setAjaxSource($route)
    {
        $this->sourceRoute = $route;
    }

    public function setTableId($tableId)
    {
        $this->tableId = $tableId;
    }

    public function dataTable($query)
    { 
        return datatables()
            ->eloquent($query)
            ->editColumn('priority', function($item) { 
            	switch ($item->priority) {
            		case '1':
            			return "Low";
            		case '2':
            			return "Normal";
            		case '3':
            			return "High";
            		case '4':
            			return "Emergency";
            	}
            });
            
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Job $model)
    {
        //return $model->newQuery();

        $query = $model->newQuery();
        $newQuery = $query->select([
                'jobs.id as id',
                'jobs.job_number as excel_job_number',
                'jobs.client_order_number as client_order_number',
                'jobs.due_date as due_date',
                'clients.client_name as client_name',
                'jobs.status as status',
                'jobtypes.job_type as job_type',
                'jobs.priority as priority',
                'contractors.company_name as contractor',
            ])
            ->leftJoin('jobtypes', 'jobtypes.id', '=', 'jobs.job_type')
            ->leftJoin('clients', 'clients.id', '=', 'jobs.client_id')
            ->leftjoin('contractors', 'contractors.id', '=', 'jobs.contractor_id');

            if($this->type == 'upcomming')
                $query->whereBetween('status',[1,4]);
            elseif($this->type == 'completed')
                $query->where('status',5);

            /*if($this->fromdate != ''){
               if($this->todate != ''){
                $query->whereBetween('due_date',[$this->todate,$this->fromdate]);
               }else{
                $query->where('due_date',$this->todate);
               }
            }*/
            /*if($this->todate != ''){
               if($this->fromdate != ''){
                $query->whereBetween('due_date',[$this->todate,$this->fromdate]);
               }else{
                $query->where('due_date',$this->todate);
               }
            }*/
            if($this->todate != ''){
                if($this->fromdate != ''){
                $query->whereBetween('due_date',[$this->fromdate,$this->todate]);
               }else{
                $query->where('due_date',$this->todate);
               }
            }
            
        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $builder = $this->builder()
                    ->setTableId('dashboard-job-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('reload')
                    );

        if ($this->tableId != '') {
            $builder = $builder->setTableId($this->tableId);
        }
        if ($this->sourceRoute != '') {
            $builder = $builder->ajax($this->sourceRoute);
        }

        return $builder;

    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('excel_job_number'),
            Column::make('client_order_number'),
            Column::make('due_date'),
            Column::make('priority')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'DashboardJob_' . date('YmdHis');
    }
}
