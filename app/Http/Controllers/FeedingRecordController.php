<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\FeedingRecord;
use Illuminate\Database\Eloquent\Model;

class FeedingRecordController extends CrudController
{
    protected string $modelClass = FeedingRecord::class;

    protected string $resource = 'feeding-records';

    protected string $title = 'Feeding record';

    protected function fields(): array
    {
        return [
            ['name' => 'animal_id', 'label' => 'Animal', 'type' => 'select', 'required' => true, 'options' => Animal::orderBy('tag_number')->get()->mapWithKeys(fn (Animal $animal): array => [$animal->id => $animal->tag_number.($animal->name ? ' · '.$animal->name : '')])->all()],
            ['name' => 'feed_type', 'label' => 'Feed type', 'required' => true],
            ['name' => 'quantity_kg', 'label' => 'Quantity (kg)', 'type' => 'number', 'step' => '0.01', 'min' => '0.01', 'required' => true],
            ['name' => 'fed_at', 'label' => 'Date and time', 'type' => 'datetime-local', 'required' => true],
            ['name' => 'notes', 'label' => 'Notes', 'type' => 'textarea'],
        ];
    }

    protected function columns(): array
    {
        return [
            'Animal' => fn (FeedingRecord $record): string => $record->animal->tag_number,
            'Feed' => fn (FeedingRecord $record): string => $record->feed_type,
            'Quantity' => fn (FeedingRecord $record): string => $record->quantity_kg.' kg',
            'Fed at' => fn (FeedingRecord $record): string => $record->fed_at->format('M j, Y g:i A'),
        ];
    }

    protected function relations(): array
    {
        return ['animal'];
    }

    protected function details(Model $record): array
    {
        return ['Animal' => $record->animal->tag_number.($record->animal->name ? ' · '.$record->animal->name : ''), 'Feed type' => $record->feed_type, 'Quantity' => $record->quantity_kg.' kg', 'Date and time' => $record->fed_at->format('M j, Y g:i A'), 'Notes' => $record->notes ?: '—'];
    }

    protected function rules(?int $recordId = null): array
    {
        return [
            'animal_id' => ['required', 'integer', 'exists:animals,id'],
            'feed_type' => ['required', 'string', 'max:255'],
            'quantity_kg' => ['required', 'numeric', 'gt:0', 'max:999999.99'],
            'fed_at' => ['required', 'date', 'before_or_equal:now'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
