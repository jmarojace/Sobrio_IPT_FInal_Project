<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

abstract class CrudController extends Controller
{
    protected string $modelClass;

    protected string $resource;

    protected string $title;

    abstract protected function fields(): array;

    abstract protected function columns(): array;

    abstract protected function details(Model $record): array;

    abstract protected function rules(?int $recordId = null): array;

    protected function relations(): array
    {
        return [];
    }

    protected function countRelation(): ?string
    {
        return null;
    }

    protected function records(): Builder
    {
        $modelClass = $this->modelClass;

        return $modelClass::query()->with($this->relations())->latest();
    }

    public function index(): View
    {
        $query = $this->records();

        if ($this->countRelation() !== null) {
            $query->withCount($this->countRelation());
        }

        return view('records.index', [
            'title' => $this->title,
            'resource' => $this->resource,
            'columns' => $this->columns(),
            'records' => $query->paginate(10),
        ]);
    }

    public function create(): View
    {
        return $this->formView(new ($this->modelClass)());
    }

    public function store(Request $request): RedirectResponse
    {
        $modelClass = $this->modelClass;
        $modelClass::create($request->validate($this->rules()));

        return to_route($this->resource.'.index')->with('success', $this->title.' added successfully.');
    }

    public function show(int $id): View
    {
        $record = $this->records()->findOrFail($id);

        return view('records.show', ['title' => $this->title, 'resource' => $this->resource, 'record' => $record, 'details' => $this->details($record)]);
    }

    public function edit(int $id): View
    {
        return $this->formView($this->records()->findOrFail($id));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $record = $this->records()->findOrFail($id);
        $record->update($request->validate($this->rules($record->getKey())));

        return to_route($this->resource.'.index')->with('success', $this->title.' updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->records()->findOrFail($id)->delete();

        return to_route($this->resource.'.index')->with('success', $this->title.' deleted successfully.');
    }

    private function formView(Model $record): View
    {
        return view('records.form', ['title' => $this->title, 'resource' => $this->resource, 'record' => $record, 'fields' => $this->fields()]);
    }
}
