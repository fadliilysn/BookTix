@extends('layouts.admin')

@section('title', 'Edit Event')

@section('content')

<style>
    .form-page-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 28px;
    }

    .back-btn {
        display: flex; align-items: center; justify-content: center;
        width: 38px; height: 38px;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        color: #6b7280;
        text-decoration: none;
        transition: all 0.15s;
        flex-shrink: 0;
    }

    .back-btn:hover {
        background: #f9fafb;
        color: #374151;
        border-color: #d1d5db;
    }

    .form-page-title {
        font-family: 'Syne', sans-serif;
        font-size: 22px;
        font-weight: 700;
        color: #111827;
        letter-spacing: -0.3px;
    }

    .form-page-sub {
        font-size: 13px;
        color: #6b7280;
        margin-top: 3px;
    }

    .event-id-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        background: #f3f4f6;
        border-radius: 20px;
        font-size: 12px;
        color: #6b7280;
        font-weight: 500;
        margin-top: 5px;
    }

    .form-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 20px;
        align-items: start;
    }

    .form-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
    }

    .form-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-card-icon {
        width: 32px; height: 32px;
        border-radius: 8px;
        background: #eef2ff;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px;
    }

    .form-card-title {
        font-family: 'Syne', sans-serif;
        font-size: 14px;
        font-weight: 600;
        color: #111827;
    }

    .form-card-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .field { display: flex; flex-direction: column; gap: 6px; }
    .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    label {
        font-size: 13px;
        font-weight: 500;
        color: #374151;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    label .required { color: #ef4444; font-size: 12px; }

    .input, .textarea {
        width: 100%;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 14px;
        color: #111827;
        font-family: 'DM Sans', sans-serif;
        transition: all 0.15s;
        outline: none;
    }

    .input:focus, .textarea:focus {
        background: white;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
    }

    .input.is-invalid, .textarea.is-invalid {
        border-color: #ef4444;
        background: #fff5f5;
    }

    .textarea { resize: vertical; min-height: 100px; line-height: 1.5; }

    .input-prefix {
        display: flex;
        align-items: center;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.15s;
    }

    .input-prefix:focus-within {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        background: white;
    }

    .prefix-label {
        padding: 10px 14px;
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
        border-right: 1px solid #e5e7eb;
        background: #f3f4f6;
        white-space: nowrap;
    }

    .prefix-input {
        flex: 1;
        border: none;
        background: transparent;
        padding: 10px 14px;
        font-size: 14px;
        color: #111827;
        font-family: 'DM Sans', sans-serif;
        outline: none;
    }

    .field-error { font-size: 12px; color: #ef4444; display: flex; align-items: center; gap: 4px; }

    .sidebar-card { background: white; border: 1px solid #e5e7eb; border-radius: 16px; overflow: hidden; }
    .sidebar-card-body { padding: 20px; }

    .submit-btn {
        width: 100%;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        background: #6366f1;
        color: white;
        padding: 12px 20px;
        border-radius: 10px;
        font-size: 14px; font-weight: 500;
        border: none; cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: all 0.2s;
        box-shadow: 0 2px 8px rgba(99,102,241,0.3);
    }

    .submit-btn:hover {
        background: #4f46e5;
        box-shadow: 0 4px 16px rgba(99,102,241,0.4);
        transform: translateY(-1px);
    }

    .cancel-btn {
        width: 100%; display: flex; align-items: center; justify-content: center;
        padding: 11px 20px; border-radius: 10px;
        font-size: 14px; font-weight: 500;
        border: 1px solid #e5e7eb; background: white; color: #6b7280;
        text-decoration: none; transition: all 0.15s;
        font-family: 'DM Sans', sans-serif; margin-top: 8px; cursor: pointer;
    }

    .cancel-btn:hover { background: #f9fafb; color: #374151; }

    .danger-zone {
        border: 1px solid #fecaca;
        border-radius: 16px;
        overflow: hidden;
        background: white;
    }

    .danger-zone-header {
        padding: 16px 20px;
        background: #fff5f5;
        border-bottom: 1px solid #fecaca;
        display: flex; align-items: center; gap: 8px;
        font-family: 'Syne', sans-serif;
        font-size: 13px; font-weight: 600; color: #dc2626;
    }

    .danger-zone-body { padding: 18px 20px; }
    .danger-zone-desc { font-size: 12px; color: #6b7280; margin-bottom: 12px; line-height: 1.5; }

    .delete-btn {
        width: 100%; display: flex; align-items: center; justify-content: center; gap: 7px;
        padding: 10px;
        background: white;
        border: 1px solid #fca5a5;
        border-radius: 8px;
        color: #dc2626;
        font-size: 13px; font-weight: 500;
        cursor: pointer; font-family: 'DM Sans', sans-serif;
        transition: all 0.15s;
    }

    .delete-btn:hover { background: #fee2e2; }

    .last-updated {
        display: flex; align-items: center; gap: 6px;
        font-size: 12px; color: #9ca3af;
        padding: 14px 20px;
        border-top: 1px solid #f3f4f6;
    }

    .alert-error-box {
        background: #fff5f5; border: 1px solid #fecaca;
        border-radius: 10px; padding: 14px 16px;
        margin-bottom: 20px; font-size: 13px; color: #dc2626;
    }

    .alert-error-box ul { margin: 6px 0 0 16px; }

    .changed-indicator {
        display: none;
        font-size: 11px;
        color: #f59e0b;
        font-weight: 500;
        margin-left: auto;
    }
</style>

<div class="form-page-header">
    <a href="{{ route('admin.events.index') }}" class="back-btn">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path d="M19 12H5M12 5l-7 7 7 7"/>
        </svg>
    </a>
    <div>
        <div class="form-page-title">Edit Event</div>
        <div style="display:flex;align-items:center;gap:8px;margin-top:4px;">
            <span class="event-id-badge"># {{ $event->id }}</span>
            <span style="font-size:13px;color:#6b7280;">{{ $event->title }}</span>
        </div>
    </div>
</div>

@if($errors->any())
<div class="alert-error-box">
    <strong>Please fix the following errors:</strong>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.events.update', $event) }}" method="POST" id="editForm">
@csrf
@method('PUT')

<div class="form-layout">

    <!-- Main Form -->
    <div style="display:flex;flex-direction:column;gap:20px;">

        <!-- Basic Info -->
        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-icon">📋</div>
                <div class="form-card-title">Basic Information</div>
            </div>
            <div class="form-card-body">
                <div class="field">
                    <label for="title">Title <span class="required">*</span></label>
                    <input id="title" type="text" name="title"
                           class="input {{ $errors->has('title') ? 'is-invalid' : '' }}"
                           value="{{ old('title', $event->title) }}"
                           placeholder="e.g. Tech Summit 2025">
                    @error('title')
                        <span class="field-error">⚠ {{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"
                              class="textarea {{ $errors->has('description') ? 'is-invalid' : '' }}"
                              placeholder="Describe your event...">{{ old('description', $event->description) }}</textarea>
                    @error('description')
                        <span class="field-error">⚠ {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-icon">📍</div>
                <div class="form-card-title">Event Details</div>
            </div>
            <div class="form-card-body">
                <div class="field">
                    <label for="location">Location <span class="required">*</span></label>
                    <input id="location" type="text" name="location"
                           class="input {{ $errors->has('location') ? 'is-invalid' : '' }}"
                           value="{{ old('location', $event->location) }}"
                           placeholder="e.g. Jakarta Convention Center">
                    @error('location')
                        <span class="field-error">⚠ {{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label for="event_date">Date & Time <span class="required">*</span></label>
                    <input id="event_date" type="datetime-local" name="event_date"
                           class="input {{ $errors->has('event_date') ? 'is-invalid' : '' }}"
                           value="{{ old('event_date', $event->event_date ? \Carbon\Carbon::parse($event->event_date)->format('Y-m-d\TH:i') : '') }}">
                    @error('event_date')
                        <span class="field-error">⚠ {{ $message }}</span>
                    @enderror
                </div>

                <div class="field-row">
                    <div class="field">
                        <label for="price">Price <span class="required">*</span></label>
                        <div class="input-prefix">
                            <span class="prefix-label">Rp</span>
                            <input id="price" type="number" name="price"
                                   class="prefix-input"
                                   value="{{ old('price', $event->price) }}"
                                   placeholder="0" min="0">
                        </div>
                        @error('price')
                            <span class="field-error">⚠ {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="quota">Max Attendees <span class="required">*</span></label>
                        <input id="quota" type="number" name="quota"
                               class="input {{ $errors->has('quota') ? 'is-invalid' : '' }}"
                               value="{{ old('quota', $event->quota) }}"
                               placeholder="100" min="1">
                        @error('quota')
                            <span class="field-error">⚠ {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            @if($event->updated_at)
            <div class="last-updated">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                </svg>
                Last updated {{ $event->updated_at->diffForHumans() }}
            </div>
            @endif
        </div>

    </div>

    <!-- Sidebar -->
    <div style="display:flex;flex-direction:column;gap:16px;position:sticky;top:0;">
        <div class="sidebar-card">
            <div class="form-card-header">
                <div class="form-card-icon">💾</div>
                <div class="form-card-title">Update Event</div>
            </div>
            <div class="sidebar-card-body">
                <button type="submit" class="submit-btn">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v14a2 2 0 01-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Save Changes
                </button>
                <a href="{{ route('admin.events.index') }}" class="cancel-btn">
                    Discard Changes
                </a>
            </div>
        </div>

        <!-- Danger Zone placeholder — form ada di luar form utama -->
        <div class="danger-zone">
            <div class="danger-zone-header">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
                Danger Zone
            </div>
            <div class="danger-zone-body">
                <p class="danger-zone-desc">Deleting this event is permanent and cannot be undone. All registrations will also be removed.</p>
                {{-- Tombol ini trigger form delete yang ada di luar form utama --}}
                <button type="submit" form="deleteForm" class="delete-btn"
                        onclick="return confirm('Are you sure? This action cannot be undone.')">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                        <path d="M10 11v6M14 11v6M9 6V4h6v2"/>
                    </svg>
                    Delete This Event
                </button>
            </div>
        </div>
    </div>

</div>

</form>

{{-- ✅ Form delete HARUS di luar form edit agar tidak nested --}}
<form id="deleteForm"
      action="{{ route('admin.events.destroy', $event) }}"
      method="POST"
      style="display:none;">
    @csrf
    @method('DELETE')
</form>

@endsection