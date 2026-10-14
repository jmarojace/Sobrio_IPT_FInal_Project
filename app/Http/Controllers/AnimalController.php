<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Breed;
use App\Models\Farm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class AnimalController extends CrudController
{
    protected string $modelClass = Animal::class;

    protected string $resource = 'animals';

    protected string $title = 'Animal';

    protected function fields(): array
    {
        return [
            ['name' => 'tag_number', 'label' => 'Tag number', 'required' => true],
            ['name' => 'name', 'label' => 'Name'],
            ['name' => 'breed_id', 'label' => 'Breed', 'type' => 'select', 'options' => Breed::orderBy('name')->pluck('name', 'id')->all()],
            ['name' => 'farm_id', 'label' => 'Farm', 'type' => 'select', 'options' => Farm::orderBy('name')->pluck('name', 'id')->all()],
            ['name' => 'sex', 'label' => 'Sex', 'type' => 'select', 'required' => true, 'options' => ['Female' => 'Female', 'Male' => 'Male']],
            ['name' => 'birth_date', 'label' => 'Birth date', 'type' => 'date'],
            ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'required' => true, 'options' => ['active' => 'Active', 'sold' => 'Sold', 'deceased' => 'Deceased']],
            ['name' => 'notes', 'label' => 'Notes', 'type' => 'textarea'],
        ];
    }

    protected function columns(): array
    {
        return [
            'Tag' => fn (Animal $animal): string => $animal->tag_number,
            'Name' => fn (Animal $animal): string => $animal->name ?: '—',
            'Breed' => fn (Animal $animal): string => $animal->breed?->name ?: '—',
            'Farm' => fn (Animal $animal): string => $animal->farm?->name ?: '—',
            'Status' => fn (Animal $animal): string => ucfirst($animal->status),
        ];
    }

    protected function relations(): array
    {
        return ['breed', 'farm'];
    }

    protected function details(Model $record): array
    {
        return [
            'Tag number' => $record->tag_number,
            'Name' => $record->name ?: '—',
            'Breed' => $record->breed?->name ?: '—',
            'Farm' => $record->farm?->name ?: '—',
            'Sex' => $record->sex,
            'Birth date' => $record->birth_date?->format('M j, Y') ?: '—',
            'Status' => ucfirst($record->status),
            'Notes' => $record->notes ?: '—',
            'Vaccinations' => $record->vaccinations()->count(),
            'Feeding records' => $record->feedingRecords()->count(),
        ];
    }

    protected function rules(?int $recordId = null): array
    {
        return [
            'tag_number' => ['required', 'string', 'max:100', Rule::unique('animals', 'tag_number')->ignore($recordId)],
            'name' => ['nullable', 'string', 'max:255'],
            'breed_id' => ['nullable', 'integer', 'exists:breeds,id'],
            'farm_id' => ['nullable', 'integer', 'exists:farms,id'],
            'sex' => ['required', Rule::in(['Female', 'Male'])],
            'birth_date' => ['nullable', 'date', 'before_or_equal:today'],
            'status' => ['required', Rule::in(['active', 'sold', 'deceased'])],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
