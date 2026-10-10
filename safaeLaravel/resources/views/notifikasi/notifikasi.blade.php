@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Notifikasi</h4>

    @forelse ($notifications as $notif)
        <div class="card mb-2 {{ $notif->is_read ? '' : 'bg-light' }}">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1">{{ $notif->message }}</p>
                    <small class="text-muted">
                        {{ $notif->created_at->diffForHumans() }}
                    </small>
                </div>

                @if(!$notif->is_read)
                <form action="{{ route('notifikasi.read', $notif->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-outline-primary">
                        Tandai dibaca
                    </button>
                </form>
                @endif
            </div>
        </div>
    @empty
        <p>Tidak ada notifikasi</p>
    @endforelse
</div>
@endsection
