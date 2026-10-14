<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Vaccination;
use Illuminate\Database\Eloquent\Model;

class VaccinationController extends CrudController
{
    protected string $modelClass = Vaccination::class;

    protected string $resource = 'vaccinations';

    protected string $title = 'Vaccination';

    protected function fields(): array
    {
        return [
            ['name' => 'animal_id', 'label' => 'Animal', 'type' => 'select', 'required' => true, 'options' => Animal::orderBy('tag_number')->get()->mapWithKeys(fn (Animal $animal): array => [$animal->id => $animal->tag_number.($animal->name ? ' · '.$animal->name : '')])->all()],
            ['name' => 'vaccine_name', 'label' => 'Vaccine', 'required' => true],
            ['name' => 'administered_on', 'label' => 'Date administered', 'type' => 'date', 'required' => true],
            ['name' => 'next_due_date', 'label' => 'Next due date', 'type' => 'date'],
            ['name' => 'veterinarian', 'label' => 'Veterinarian'],
            ['name' => 'notes', 'label' => 'Notes', 'type' => 'textarea'],
        ];
    }

    protected function columns(): array
    {
        return [
            'Animal' => fn (Vaccination $record): string => $record->animal->tag_number,
            'Vaccine' => fn (Vaccination $record): string => $record->vaccine_name,
            'Given' => fn (Vaccination $record): string => $record->administered_on->format('M j, Y'),
            'Next due' => fn (Vaccination $record): string => $record->next_due_date?->format('M j, Y') ?: '—',
        ];
    }

    protected function relations(): array
    {
        return ['animal'];
    }

    protected function details(Model $record): array
    {
        return ['Animal' => $record->animal->tag_number.($record->animal->name ? ' · '.$record->animal->name : ''), 'Vaccine' => $record->vaccine_name, 'Date administered' => $record->administered_on->format('M j, Y'), 'Next due date' => $record->next_due_date?->format('M j, Y') ?: '—', 'Veterinarian' => $record->veterinarian ?: '—', 'Notes' => $record->notes ?: '—'];
    }

    protected function rules(?int $recordId = null): array
    {
        return [
            'animal_id' => ['required', 'integer', 'exists:animals,id'],
            'vaccine_name' => ['required', 'string', 'max:255'],
            'administered_on' => ['required', 'date', 'before_or_equal:today'],
            'next_due_date' => ['nullable', 'date', 'after_or_equal:administered_on'],
            'veterinarian' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
