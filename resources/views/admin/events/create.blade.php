@extends('layouts.admin')

@section('title', 'Create Event')

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

    .field {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .field-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    label {
        font-size: 13px;
        font-weight: 500;
        color: #374151;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    label .required {
        color: #ef4444;
        font-size: 12px;
    }

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

    .textarea {
        resize: vertical;
        min-height: 100px;
        line-height: 1.5;
    }

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

    .field-hint {
        font-size: 12px;
        color: #9ca3af;
    }

    .field-error {
        font-size: 12px;
        color: #ef4444;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Sidebar card */
    .sidebar-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
    }

    .sidebar-card-body { padding: 20px; }

    .submit-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #6366f1;
        color: white;
        padding: 12px 20px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: all 0.2s;
        box-shadow: 0 2px 8px rgba(99,102,241,0.3);
    }

    .submit-btn:hover {
        background: #4f46e5;
        box-shadow: 0 4px 16px rgba(99,102,241,0.4);
        transform: translateY(-1px);
    }

    .submit-btn:active { transform: translateY(0); }

    .cancel-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 11px 20px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        border: 1px solid #e5e7eb;
        background: white;
        color: #6b7280;
        text-decoration: none;
        transition: all 0.15s;
        font-family: 'DM Sans', sans-serif;
        margin-top: 8px;
        cursor: pointer;
    }

    .cancel-btn:hover {
        background: #f9fafb;
        color: #374151;
    }

    .tip-box {
        background: #f5f3ff;
        border: 1px solid #e0d9ff;
        border-radius: 10px;
        padding: 14px;
        margin-top: 16px;
    }

    .tip-title {
        font-size: 12px;
        font-weight: 600;
        color: #6366f1;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .tip-list {
        font-size: 12px;
        color: #6b7280;
        line-height: 1.7;
        list-style: none;
        padding: 0;
    }

    .tip-list li::before {
        content: '→ ';
        color: #6366f1;
    }

    /* Validation errors */
    .alert-error-box {
        background: #fff5f5;
        border: 1px solid #fecaca;
        border-radius: 10px;
        padding: 14px 16px;
        margin-bottom: 20px;
        font-size: 13px;
        color: #dc2626;
    }

    .alert-error-box ul {
        margin: 6px 0 0 16px;
    }
</style>

<div class="form-page-header">
    <a href="{{ route('admin.events.index') }}" class="back-btn">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path d="M19 12H5M12 5l-7 7 7 7"/>
        </svg>
    </a>
    <div>
        <div class="form-page-title">Create New Event</div>
        <div class="form-page-sub">Fill in the details to publish a new event</div>
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

<form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
@csrf

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
                           value="{{ old('title') }}"
                           placeholder="e.g. Tech Summit 2025">
                    @error('title')
                        <span class="field-error">⚠ {{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"
                              class="textarea {{ $errors->has('description') ? 'is-invalid' : '' }}"
                              placeholder="Describe your event...">{{ old('description') }}</textarea>
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
                           value="{{ old('location') }}"
                           placeholder="e.g. Jakarta Convention Center">
                    @error('location')
                        <span class="field-error">⚠ {{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label for="event_date">Date & Time <span class="required">*</span></label>
                    <input id="event_date" type="datetime-local" name="event_date"
                           class="input {{ $errors->has('event_date') ? 'is-invalid' : '' }}"
                           value="{{ old('event_date') }}">
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
                                   value="{{ old('price') }}"
                                   placeholder="0"
                                   min="0">
                        </div>
                        @error('price')
                            <span class="field-error">⚠ {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="quota">Max Attendees <span class="required">*</span></label>
                        <input id="quota" type="number" name="quota"
                               class="input {{ $errors->has('quota') ? 'is-invalid' : '' }}"
                               value="{{ old('quota') }}"
                               placeholder="100"
                               min="1">
                        @error('quota')
                            <span class="field-error">⚠ {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Image Upload -->
        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-icon">🖼️</div>
                <div class="form-card-title">Event Image</div>
            </div>
            <div class="form-card-body">
                <div class="field">
                    <label for="image">Poster / Banner Event</label>
                    <div id="dropZone" style="border:2px dashed #e5e7eb;border-radius:12px;padding:32px;text-align:center;cursor:pointer;transition:all 0.2s;background:#f9fafb;" onclick="document.getElementById('image').click()">
                        <div id="previewWrap" style="display:none;margin-bottom:12px;">
                            <img id="imagePreview" src="" style="max-height:200px;border-radius:8px;max-width:100%;">
                        </div>
                        <div id="uploadPrompt">
                            <div style="font-size:32px;margin-bottom:8px;">📸</div>
                            <div style="font-size:14px;font-weight:500;color:#374151;">Klik untuk upload gambar</div>
                            <div style="font-size:12px;color:#9ca3af;margin-top:4px;">PNG, JPG, WEBP — Maks. 2MB</div>
                        </div>
                        <input id="image" type="file" name="image" accept="image/*" style="display:none;" onchange="previewImage(this)">
                    </div>
                    <span class="field-hint">Recommended size: 1200x600px (landscape)</span>
                    @error('image')
                        <span class="field-error">⚠ {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

    </div>

    <!-- Sidebar -->
    <div style="display:flex;flex-direction:column;gap:16px;position:sticky;top:0;">
        <div class="sidebar-card">
            <div class="form-card-header">
                <div class="form-card-icon">🚀</div>
                <div class="form-card-title">Publish</div>
            </div>
            <div class="sidebar-card-body">
                <button type="submit" class="submit-btn">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7"/>
                    </svg>
                    Save & Publish Event
                </button>
                <a href="{{ route('admin.events.index') }}" class="cancel-btn">
                    Cancel
                </a>
            </div>
        </div>

        <div class="sidebar-card">
            <div class="sidebar-card-body">
                <div class="tip-box">
                    <div class="tip-title">💡 Tips</div>
                    <ul class="tip-list">
                        <li>Use a clear, descriptive title</li>
                        <li>Set quota to limit registrations</li>
                        <li>Enter 0 for a free event</li>
                        <li>Double-check the date & time</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

</form>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('previewWrap').style.display = 'block';
            document.getElementById('uploadPrompt').style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
        document.getElementById('dropZone').style.borderColor = '#6366f1';
    }
}
</script>
@endsection