@extends('layouts.app', ['title' => $title.' details'])

@section('content')
    <div class="mb-4">
        <a href="{{ route($resource.'.index') }}" class="small text-decoration-none text-success">← Back to {{ strtolower($title) }}s</a>
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-3 mt-4">
            <div><div class="eyebrow mb-2">Record details</div><h1 class="h2 fw-bold mb-1">{{ $title }} details</h1><p class="text-muted-custom mb-0">Information saved in your livestock records.</p></div>
            <a href="{{ route($resource.'.edit', $record) }}" class="btn btn-outline-success rounded-3 px-3">Edit {{ strtolower($title) }}</a>
        </div>
    </div>
    <div class="card p-4 p-lg-5">
        <dl class="row mb-0">
            @foreach ($details as $label => $value)
                <dt class="detail-label col-sm-4 col-lg-3 fw-semibold py-3 border-bottom">{{ $label }}</dt>
                <dd class="detail-value col-sm-8 col-lg-9 py-3 border-bottom mb-0">{{ $value }}</dd>
            @endforeach
            <dt class="col-sm-4 col-lg-3 text-muted-custom fw-semibold py-3">Last updated</dt>
            <dd class="col-sm-8 col-lg-9 text-muted-custom py-3 mb-0">{{ $record->updated_at->format('M j, Y g:i A') }}</dd>
        </dl>
    </div>
@endsection
