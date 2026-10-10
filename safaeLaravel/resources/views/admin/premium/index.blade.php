@extends('layouts.layoutsAdmin')

@section('content')
<div class="container-fluid py-4 text-light">

    {{-- Header & Counter --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0 fw-semibold text-white">
            <i class="bi bi-shield-check me-2 text-primary"></i>Verifikasi Buku Premium
        </h4>
        <span class="badge bg-dark border border-secondary text-white-50 rounded-pill px-3 py-2">
            {{ $requests->count() }} Pengajuan
        </span>
    </div>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success bg-success bg-opacity-10 text-success d-flex align-items-center gap-2 border border-success border-opacity-25 rounded-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- Tabel Utama --}}
    <div class="card bg-dark border-secondary rounded-3 shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0" style="font-size: 14px;">
                    <thead>
                        <tr class="border-bottom border-secondary">
                            <th class="px-4 py-3 text-uppercase text-white-50 fw-semibold" style="font-size:12px; letter-spacing:.5px;">Penulis</th>
                            <th class="px-4 py-3 text-uppercase text-white-50 fw-semibold" style="font-size:12px; letter-spacing:.5px;">Judul Buku</th>
                            <th class="px-4 py-3 text-uppercase text-white-50 fw-semibold" style="font-size:12px; letter-spacing:.5px;">Status</th>
                            <th class="px-4 py-3 text-uppercase text-white-50 fw-semibold" style="font-size:12px; letter-spacing:.5px;">Harga Poin</th>
                            <th class="px-4 py-3 text-uppercase text-white-50 fw-semibold" style="font-size:12px; letter-spacing:.5px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $request)
                        <tr class="border-bottom border-secondary border-opacity-50">
                            
                            {{-- Kolom Penulis dengan Avatar Inisial --}}
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-20 text-primary fw-bold"
                                         style="width:34px; height:34px; font-size:12px; flex-shrink:0;">
                                        {{ strtoupper(substr($request->user->username, 0, 2)) }}
                                    </div>
                                    <span class="text-white fw-medium">{{ $request->user->username }}</span>
                                </div>
                            </td>

                            {{-- Kolom Judul Buku --}}
                            <td class="px-4 py-3">
                                <div class="fw-semibold text-white">{{ $request->book->title }}</div>
                            </td>

                            {{-- Kolom Status Badge --}}
                            <td class="px-4 py-3">
                                @if($request->status == 'pending')
                                    <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25" style="font-size:12px; padding:5px 12px;">
                                        <span class="d-inline-block bg-warning rounded-circle me-1" style="width:6px; height:6px; vertical-align:middle;"></span>
                                        Pending
                                    </span>
                                @elseif($request->status == 'approved')
                                    <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-25" style="font-size:12px; padding:5px 12px;">
                                        <span class="d-inline-block bg-success rounded-circle me-1" style="width:6px; height:6px; vertical-align:middle;"></span>
                                        Disetujui
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25" style="font-size:12px; padding:5px 12px;">
                                        <span class="d-inline-block bg-danger rounded-circle me-1" style="width:6px; height:6px; vertical-align:middle;"></span>
                                        Ditolak
                                    </span>
                                @endif
                            </td>

                            {{-- Kolom Harga Poin (Input disatukan dengan Form Approve menggunakan atribut 'form') --}}
                            <td class="px-4 py-3">
                                @if($request->status == 'pending')
                                    <div class="d-flex align-items-center gap-2">
                                        <input
                                            type="number"
                                            name="premium_point"
                                            form="form-approve-{{ $request->id }}"
                                            class="form-control form-control-sm bg-dark text-white border-secondary"
                                            style="width:100px;"
                                            placeholder="Contoh: 500"
                                            min="1"
                                            required>
                                        <span class="text-white-50" style="font-size:12px;">Poin</span>
                                    </div>
                                @elseif($request->premium_point)
                                    <span class="fw-semibold text-white">{{ number_format($request->premium_point) }}</span>
                                    <span class="text-white-50 ms-1" style="font-size:12px;">Poin</span>
                                @else
                                    <span class="text-white-50">—</span>
                                @endif
                            </td>

                            {{-- Kolom Tombol Aksi --}}
                            <td class="px-4 py-3">
                                @if($request->status == 'pending')
                                    <div class="d-flex align-items-center gap-2">
                                        {{-- Form Approve --}}
                                        <form
                                            id="form-approve-{{ $request->id }}"
                                            action="{{ route('admin.premium.approve', $request->id) }}"
                                            method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-success d-flex align-items-center gap-1"
                                                style="font-size:13px;">
                                                <i class="bi bi-check-lg"></i> Setuju
                                            </button>
                                        </form>

                                        {{-- Form Reject --}}
                                        <form
                                            action="{{ route('admin.premium.reject', $request->id) }}"
                                            method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1"
                                                style="font-size:13px;">
                                                <i class="bi bi-x-lg"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-white-50">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-white-50">
                                <i class="bi bi-inbox d-block mb-2 text-secondary" style="font-size:32px;"></i>
                                Belum ada pengajuan buku premium saat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection