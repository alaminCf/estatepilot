@extends('Accounts.app')

@section('content')
<div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 60vh;">
    <div class="text-center">
        <iconify-icon icon="solar:shield-warning-outline" class="text-danger-600" style="font-size: 80px;"></iconify-icon>
        <h3 class="fw-bold mt-16 mb-8">Access Denied</h3>
        <p class="text-secondary-light mb-24">{{ $exception->getMessage() ?: 'You do not have permission to access this section.' }}</p>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary px-24 py-12 radius-8">
            <iconify-icon icon="solar:home-smile-angle-outline" class="icon me-4"></iconify-icon>
            Back to Dashboard
        </a>
    </div>
</div>
@endsection
