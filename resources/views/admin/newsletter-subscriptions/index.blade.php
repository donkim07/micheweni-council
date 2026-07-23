@extends('admin.layouts.app')

@section('title', 'Newsletter Subscriptions')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Newsletter Subscriptions</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Newsletter Subscriptions</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-envelope-open-text me-1"></i>
                    Manage Newsletter Subscriptions
                </div>
                <div>
                    <a href="{{ route('admin.newsletter-subscriptions.export') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-download me-1"></i> Export CSV
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Date Subscribed</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptions as $subscription)
                            <tr>
                                <td>{{ $subscription->email }}</td>
                                <td>{{ $subscription->name ?? 'Not provided' }}</td>
                                <td>
                                    @if($subscription->status === 'subscribed')
                                        <span class="badge bg-success">Subscribed</span>
                                    @elseif($subscription->status === 'unsubscribed')
                                        <span class="badge bg-secondary">Unsubscribed</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $subscription->subscribed_at ? $subscription->subscribed_at->format('M d, Y H:i') : $subscription->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <form action="{{ route('admin.newsletter-subscriptions.destroy', $subscription->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this subscription?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">No subscriptions found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $subscriptions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 