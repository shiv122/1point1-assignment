<?php

namespace App\Http\Livewire\Tables;

use App\Models\User;
use App\Exports\EmployeeExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class EmployeeTable extends DataTableComponent
{
  protected $model = User::class;

  public function configure(): void
  {
    $this->setPrimaryKey('id');
    $this->setConfigurableAreas([
      'toolbar-right-start' => 'content.table-helper.refresh',
    ]);
  }

  public function builder(): Builder
  {
    $query = User::query();
    $query->where('role', 'employee')->select();
    return $query;
  }


  public function columns(): array
  {
    return [
      Column::make("Id", "id")
        ->sortable(),
      Column::make("Name", "name")
        ->sortable(),
      Column::make("Email", "email")
        ->sortable(),
      Column::make("Dob", "dob")
        ->sortable(),
      Column::make("Image", "image")
        ->format(function ($val, $row) {
          return view('components.helper.table.avatar', [
            'image' => $val
          ]);
        })
        ->html(),
      Column::make("Gender", "gender")
        ->sortable(),
      BooleanColumn::make('is_manager')
        ->sortable(),
      Column::make('Action', 'action')
        ->label(function ($value, $row) {
          $edit = route('admin.employees.edit', $value->id);
          $delete = route('admin.employees.delete', $value->id);
          return <<<HTML
                 <div  class="text-nowrap">
                    <button class="btn btn-label-primary btn-icon  waves-effect" data-modal="#edit-employee-modal" data-callback="setVal" data-edit="$edit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M8 20l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4h4z"></path>
                      <path d="M13.5 6.5l4 4"></path>
                      <path d="M16 18h4"></path>
                    </svg>
                    </button>
                    <button data-delete="$delete" class="btn btn-icon btn-label-danger  waves-effect">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M4 7h16"></path>
                      <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                      <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                      <path d="M10 12l4 4m0 -4l-4 4"></path>
                    </svg>
                    </button>
                 </div>
          HTML;
        })
        ->html(),
      Column::make("Created at", "created_at")
        ->sortable(),
      Column::make("Updated at", "updated_at")
        ->sortable(),
    ];
  }

  public function filters(): array
  {
    return [
      SelectFilter::make('gender')
        ->options([
          '' => 'All',
          'male' => 'Male',
          'female' => 'Female',
          'other' => 'Other',
        ])
        ->filter(function ($query, $value) {
          if ($value !== "") {
            $query->where('gender', $value);
          }
        }),
      DateFilter::make('Created At', 'created_at')
        ->filter(function ($query, $value) {
          $query->whereDate('created_at', $value);
        }),

    ];
  }


  public function refresh()
  {
  }


  public function export()
  {
    $data = $this->getBuilder()->get();

    return Excel::download(new EmployeeExport($data),  'employees-' . now()->format('Y-m-d_H:i') . '.xlsx');
  }
}
