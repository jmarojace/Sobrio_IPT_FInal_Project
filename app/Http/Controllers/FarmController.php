<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class FarmController extends CrudController
{
    protected string $modelClass = Farm::class;

    protected string $resource = 'farms';

    protected string $title = 'Farm';

    protected function fields(): array
    {
        return [
            ['name' => 'name', 'label' => 'Farm name', 'required' => true],
            ['name' => 'location', 'label' => 'Location', 'required' => true],
            ['name' => 'manager_name', 'label' => 'Manager name'],
            ['name' => 'phone', 'label' => 'Phone'],
            ['name' => 'description', 'label' => 'Notes', 'type' => 'textarea'],
        ];
    }

    protected function columns(): array
    {
        return [
            'Farm' => fn (Farm $farm): string => $farm->name,
            'Location' => fn (Farm $farm): string => $farm->location,
            'Manager' => fn (Farm $farm): string => $farm->manager_name ?: '—',
            'Animals' => fn (Farm $farm): int => $farm->animals_count,
        ];
    }

    protected function countRelation(): ?string
    {
        return 'animals';
    }

    protected function details(Model $record): array
    {
        return ['Farm name' => $record->name, 'Location' => $record->location, 'Manager' => $record->manager_name ?: '—', 'Phone' => $record->phone ?: '—', 'Notes' => $record->description ?: '—', 'Animals' => $record->animals()->count()];
    }

    protected function rules(?int $recordId = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('farms', 'name')->ignore($recordId)],
            'location' => ['required', 'string', 'max:255'],
            'manager_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
