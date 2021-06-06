<?php

namespace Modules\Jobs\DataTables;

use Modules\Jobs\Entities\Task;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Illuminate\Support\Facades\Auth;

class TaskDataTable extends DataTable
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
                ->editColumn('status', function($item) { 
                switch ($item->status) {
                    case '0':
                        return "Not Done";
                    case '1':
                        return "Done";
                }
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Task $model)
    {
        return $model->newQuery()->whereIn('job_id',$this->upcomingJobIdArray)->where('status',0);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $builder = $this->builder()
                    ->setTableId('task-table')
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
            Column::make('task'),
            Column::make('status'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Task_' . date('YmdHis');
    }
}
