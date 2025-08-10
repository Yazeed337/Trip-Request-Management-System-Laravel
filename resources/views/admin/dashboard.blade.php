@extends('layouts.app')
@section('title', 'لوحة التحكم')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs mb-4" id="dashboardTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="trip-requests-tab" data-bs-toggle="tab" 
                            data-bs-target="#trip-requests" type="button" role="tab">
                        طلبات الرحلات
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-messages-tab" data-bs-toggle="tab" 
                            data-bs-target="#contact-messages" type="button" role="tab">
                        رسائل التواصل
                    </button>
                </li>
            </ul>
            
            <!-- Tabs Content -->
            <div class="tab-content" id="dashboardTabsContent">
                <!-- Trip Requests Tab -->
                <div class="tab-pane fade show active" id="trip-requests" role="tabpanel">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h3 class="mb-0">طلبات الرحلات</h3>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>المستخدم</th>
                                            <th>الوجهة</th>
                                            <th>تاريخ السفر</th>
                                            <th>المدة (أيام)</th>
                                            <th>عدد المسافرين</th>
                                            <th>ملاحظات</th>
                                            <th>الحالة</th>
                                            <th>تاريخ الطلب</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tripRequests as $tripRequest)
                                        <tr>
                                            <td>{{ $tripRequest->id }}</td>
                                            <td>{{ $tripRequest->user->name }}</td>
                                            <td>{{ $tripRequest->destination->name_ar }}</td>
                                            <td>{{ $tripRequest->travel_date }}</td>
                                            <td>{{ $tripRequest->duration_days }}</td>
                                            <td>{{ $tripRequest->travelers_count }}</td>
                                            <td>{{ $tripRequest->notes ?? '-' }}</td>
                                            <td>
                                                <span class="badge bg-{{ 
                                                    $tripRequest->status == 'approved' ? 'success' : 
                                                    ($tripRequest->status == 'rejected' ? 'danger' : 'warning') 
                                                }}">
                                                    {{ $tripRequest->status == 'approved' ? 'مقبول' : 
                                                    ($tripRequest->status == 'rejected' ? 'مرفوض' : 'قيد الانتظار') }}
                                                </span>
                                            </td>
                                            <td>{{ $tripRequest->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <form method="POST" action="{{ route('admin.trip-requests.update-status', $tripRequest) }}">
                                                    @csrf
                                                    <div class="btn-group">
                                                        <button type="submit" name="status" value="approved" class="btn btn-sm btn-success">
                                                            قبول
                                                        </button>
                                                        <button type="submit" name="status" value="rejected" class="btn btn-sm btn-danger">
                                                            رفض
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Messages Tab -->
                <div class="tab-pane fade" id="contact-messages" role="tabpanel">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h3 class="mb-0">رسائل التواصل</h3>
                        </div>
                        <div class="card-body">
                            @if (session('message_success'))
                                <div class="alert alert-success">
                                    {{ session('message_success') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>الاسم</th>
                                            <th>البريد الإلكتروني</th>
                                            <th>الموضوع</th>
                                            <th>الرسالة</th>
                                            <th>الحالة</th>
                                            <th>تاريخ الإرسال</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contactMessages as $message)
                                        <tr>
                                            <td>{{ $message->id }}</td>
                                            <td>{{ $message->name }}</td>
                                            <td>{{ $message->email }}</td>
                                            <td>{{ $message->subject }}</td>
                                            <td>{{ Str::limit($message->message, 50) }}</td>
                                            <td>
                                                <span class="badge bg-{{ 
                                                    $message->replied_at ? 'success' : 
                                                    ($message->is_read ? 'info' : 'warning') 
                                                }}">
                                                    {{ $message->replied_at ? 'تم الرد' : 
                                                    ($message->is_read ? 'مقروء' : 'جديد') }}
                                                </span>
                                            </td>
                                            <td>{{ $message->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <!-- View Message Button -->
                                                    <button type="button" class="btn btn-sm btn-primary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#messageModal{{ $message->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    
                                                    <!-- Mark as Read Button -->
                                                    @if(!$message->is_read)
                                                    <form method="POST" action="{{ route('admin.contact-mark-read', $message) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-info">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                    
                                                    <!-- Mark as Replied Button -->
                                                    @if(!$message->replied_at)
                                                    <form method="POST" action="{{ route('admin.contact-mark-replied', $message) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="fas fa-reply"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Message Detail Modals -->
@foreach ($contactMessages as $message)
<div class="modal fade" id="messageModal{{ $message->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">تفاصيل الرسالة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong>الاسم:</strong>
                    <p>{{ $message->name }}</p>
                </div>
                <div class="mb-3">
                    <strong>البريد الإلكتروني:</strong>
                    <p>{{ $message->email }}</p>
                </div>
                <div class="mb-3">
                    <strong>الموضوع:</strong>
                    <p>{{ $message->subject }}</p>
                </div>
                <div class="mb-3">
                    <strong>الرسالة:</strong>
                    <p>{{ $message->message }}</p>
                </div>
                <div class="mb-3">
                    <strong>تاريخ الإرسال:</strong>
                    <p>{{ $message->created_at->format('Y-m-d H:i') }}</p>
                </div>
                <div class="mb-3">
                    <strong>الحالة:</strong>
                    <p>
                        <span class="badge bg-{{ 
                            $message->replied_at ? 'success' : 
                            ($message->is_read ? 'info' : 'warning') 
                        }}">
                            {{ $message->replied_at ? 'تم الرد' : 
                            ($message->is_read ? 'مقروء' : 'جديد') }}
                        </span>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <a href="mailto:{{ $message->email }}?subject=رد على: {{ $message->subject }}" 
                   class="btn btn-primary">
                    <i class="fas fa-reply me-2"></i>الرد عبر البريد
                </a>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('styles')
<style>
    .nav-tabs .nav-link {
        font-weight: bold;
        color: #495057;
        border: none;
        border-bottom: 3px solid transparent;
    }
    
    .nav-tabs .nav-link.active {
        color: var(--primary-color);
        border-bottom: 3px solid var(--primary-color);
        background-color: transparent;
    }
    
    .nav-tabs .nav-link:hover {
        border-bottom: 3px solid #dee2e6;
    }
</style>
@endpush