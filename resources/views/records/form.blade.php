@extends('layouts.app', ['title' => ($record->exists ? 'Edit ' : 'Add ').$title])

@section('content')
    <div class="mb-4">
        <a href="{{ route($resource.'.index') }}" class="small text-decoration-none text-success">← Back to {{ strtolower($title) }}s</a>
        <div class="eyebrow mt-4 mb-2">{{ $record->exists ? 'Update record' : 'New record' }}</div>
        <h1 class="h2 fw-bold mb-1">{{ $record->exists ? 'Edit ' : 'Add ' }}{{ strtolower($title) }}</h1>
        <p class="text-muted-custom mb-0">Enter the details below. Required fields are marked.</p>
    </div>
    <div class="card p-4 p-lg-5">
        <div class="form-card-heading">
            <span class="form-card-icon"><svg><use href="#icon-leaf"></use></svg></span>
            <span><span class="fw-bold d-block">Record information</span><span class="small text-muted-custom">A few details help keep your farm organized.</span></span>
        </div>
        <form method="POST" action="{{ $record->exists ? route($resource.'.update', $record) : route($resource.'.store') }}">
            @csrf
            @if ($record->exists) @method('PUT') @endif
            <div class="row g-4">
                @foreach ($fields as $field)
                    @php
                        $name = $field['name'];
                        $type = $field['type'] ?? 'text';
                        $value = old($name, $record->{$name});
                        if ($type === 'datetime-local' && $value instanceof \DateTimeInterface) { $value = $value->format('Y-m-d\\TH:i'); }
                        if ($type === 'date' && $value instanceof \DateTimeInterface) { $value = $value->format('Y-m-d'); }
                    @endphp
                    <div class="col-md-{{ $type === 'textarea' ? '12' : '6' }}">
                        <label for="{{ $name }}" class="form-label fw-semibold">{{ $field['label'] }} @if (!empty($field['required']))<span class="text-danger">*</span>@endif</label>
                        @if ($type === 'textarea')
                            <textarea class="form-control @error($name) is-invalid @enderror" id="{{ $name }}" name="{{ $name }}" rows="4">{{ $value }}</textarea>
                        @elseif ($type === 'select')
                            <select class="form-select @error($name) is-invalid @enderror" id="{{ $name }}" name="{{ $name }}">
                                @unless (!empty($field['required']))<option value="">Select {{ strtolower($field['label']) }}</option>@endunless
                                @foreach ($field['options'] as $optionValue => $optionLabel)
                                    <option value="{{ $optionValue }}" @selected((string) $value === (string) $optionValue)>{{ $optionLabel }}</option>
                                @endforeach
                            </select>
                        @else
                            <input class="form-control @error($name) is-invalid @enderror" id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ $value }}" @if (!empty($field['required'])) required @endif @if (isset($field['step'])) step="{{ $field['step'] }}" @endif @if (isset($field['min'])) min="{{ $field['min'] }}" @endif>
                        @endif
                        @error($name)<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-end gap-2 mt-5 pt-4 border-top">
                <a href="{{ route($resource.'.index') }}" class="btn btn-light rounded-3 px-4">Cancel</a>
                <button type="submit" class="btn btn-success rounded-3 px-4">{{ $record->exists ? 'Save changes' : 'Save record' }}</button>
            </div>
        </form>
    </div>
@endsection
