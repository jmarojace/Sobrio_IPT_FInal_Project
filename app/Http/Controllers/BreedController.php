<?php

namespace App\Http\Controllers;

use App\Models\Breed;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class BreedController extends CrudController
{
    protected string $modelClass = Breed::class;

    protected string $resource = 'breeds';

    protected string $title = 'Breed';

    protected function fields(): array
    {
        return [
            ['name' => 'name', 'label' => 'Breed name', 'required' => true],
            ['name' => 'species', 'label' => 'Species', 'required' => true],
            ['name' => 'description', 'label' => 'Notes', 'type' => 'textarea'],
        ];
    }

    protected function columns(): array
    {
        return ['Breed' => fn (Breed $breed): string => $breed->name, 'Species' => fn (Breed $breed): string => $breed->species, 'Animals' => fn (Breed $breed): int => $breed->animals_count];
    }

    protected function countRelation(): ?string
    {
        return 'animals';
    }

    protected function details(Model $record): array
    {
        return ['Breed name' => $record->name, 'Species' => $record->species, 'Notes' => $record->description ?: '—', 'Animals' => $record->animals()->count()];
    }

    protected function rules(?int $recordId = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('breeds', 'name')->ignore($recordId)],
            'species' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
