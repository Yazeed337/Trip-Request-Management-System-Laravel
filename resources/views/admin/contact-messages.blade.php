@extends('layouts.app')

@section('title', 'رسائل التواصل')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">رسائل التواصل</h3>
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
                                @foreach ($messages as $message)
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
                                            <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" 
                                               data-bs-target="#messageModal{{ $message->id }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(!$message->is_read)
                                            <form method="POST" action="{{ route('admin.contact-mark-read', $message) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-info">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            @endif
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
                                
                                <!-- Message Modal -->
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection