@extends('layouts.app', ['title' => $title.'s'])

@section('content')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-3 mb-4">
        <div><div class="eyebrow mb-2">Records</div><h1 class="h2 fw-bold mb-1">{{ $title }}s</h1><p class="text-muted-custom mb-0">Review and manage your {{ strtolower($title) }} records.</p></div>
        <div class="d-flex align-items-center gap-2"><span class="record-count"><strong>{{ $records->total() }}</strong> total</span><a href="{{ route($resource.'.create') }}" class="btn btn-success rounded-3 px-3 py-2">＋ Add {{ strtolower($title) }}</a></div>
    </div>
    <div class="card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr>@foreach ($columns as $label => $column)<th class="px-4 py-3">{{ $label }}</th>@endforeach<th class="text-end px-4 py-3">Actions</th></tr></thead>
                <tbody>
                    @forelse ($records as $record)
                        <tr>
                            @foreach ($columns as $column)<td class="px-4 py-3">{{ $column($record) }}</td>@endforeach
                            <td class="text-end px-4 py-3 text-nowrap">
                                <a href="{{ route($resource.'.show', $record) }}" class="btn btn-sm btn-light rounded-2">View</a>
                                <a href="{{ route($resource.'.edit', $record) }}" class="btn btn-sm btn-outline-success rounded-2">Edit</a>
                                <form action="{{ route($resource.'.destroy', $record) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this record? This action cannot be undone.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="{{ count($columns) + 1 }}" class="text-center text-muted-custom py-5">No records yet. Add the first {{ strtolower($title) }} to get started.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($records->hasPages())<div class="p-3 border-top">{{ $records->links() }}</div>@endif
    </div>
@endsection
