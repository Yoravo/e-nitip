@extends('admin.layouts.master')

@section('judul', 'Aktivitas')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('alert'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('alert') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('debug'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('debug') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container-fluid mt-1">
        <h3 class="text-center text-danger mt-4">Aktivitas</h3>
        <div class="row">
            @if ($reservations->isEmpty())
                <div class="d-flex align-items-center justify-content-center">
                    <p class="text-center">No data available</p>
                </div>
            @else
                @foreach ($reservations as $reservation)
                    <div class="col-md-4">
                        <div class="card mb-4" style="border-radius: 8px; border: 1px solid #696565;">
                            <div class="card-body">
                                <p><strong>Nama:</strong> {{ $reservation->name }}</p>
                                <p><strong>Jumlah Locker:</strong> {{ count($reservation->locker_codes) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- Lihat Button triggers modal -->
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#detailModal-{{ $reservation->id }}">
                                        Lihat <i class="fas fa-eye"></i>
                                    </button>
                                    <!-- Total Price -->
                                    <span class="text-primary">
                                        @if (is_numeric($reservation->total_price))
                                            Rp. {{ number_format($reservation->total_price, 2, ',', '.') }}
                                        @else
                                            <span class="text-danger">Error: Invalid price</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for showing details -->
                    <div class="modal fade" id="detailModal-{{ $reservation->id }}" tabindex="-1"
                        aria-labelledby="detailModalLabel-{{ $reservation->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailModalLabel-{{ $reservation->id }}">Detail Transaksi
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Nama:</strong> {{ $reservation->name }}</p>
                                    <p><strong>No Telepon:</strong> {{ $reservation->phone_number }}</p>
                                    <p><strong>Barang:</strong> {{ $reservation->item_name }}</p>
                                    <p><strong>Jam Penyimpanan:</strong> {{ $reservation->deposit_time }}</p>
                                    <p><strong>Jam Pengambilan:</strong> {{ $reservation->pickup_time }}</p>

                                    <!-- Locker and Price Details -->
                                    <table class="table mt-3">
                                        <thead>
                                            <tr>
                                                <th>Jumlah Locker</th>
                                                <th>Kode</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ count($reservation->locker_codes) }}</td>
                                                <td>{{ implode(', ', $reservation->locker_codes) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="text-end">
                                        <strong>Total Harga:</strong>
                                        <span class="text-primary">Rp.
                                            {{ number_format($reservation->total_price, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <!-- Tombol Finish -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#confirmFinishModal-{{ $reservation->id }}">
                                        Finish
                                    </button>
                                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal"><i class="fas fa-print"></i> Print</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal konfirmasi sebelum finish -->
                    <div class="modal fade" id="confirmFinishModal-{{ $reservation->id }}" tabindex="-1"
                        aria-labelledby="confirmFinishLabel-{{ $reservation->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmFinishLabel-{{ $reservation->id }}">Konfirmasi Pengambilan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah waktu pengambilan sesuai dengan yang dijadwalkan?</p>
                                </div>
                                <div class="modal-footer">
                                    <form method="POST" action="{{ route('admin.activity.finish.confirm', $reservation->id) }}">
                                        @csrf
                                        <input type="hidden" name="pickup_time" value="{{ $reservation->pickup_time }}">
                                        <input type="hidden" name="deposit_time" value="{{ $reservation->deposit_time }}">
                                        <button type="submit" class="btn btn-success">Ya, sesuai</button>
                                    </form>
                                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal"
                                        data-bs-toggle="modal" data-bs-target="#penaltyModal-{{ $reservation->id }}">
                                        Tidak, hitung ulang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal denda -->
                    <div class="modal fade" id="penaltyModal-{{ $reservation->id }}" tabindex="-1"
                        aria-labelledby="penaltyModalLabel-{{ $reservation->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="penaltyModalLabel-{{ $reservation->id }}">Harga dan Denda</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Harga Awal:</strong> Rp. {{ number_format($reservation->total_price, 2, ',', '.') }}</p>
                                    <p><strong>Denda Tambahan:</strong> Rp. {{ number_format($reservation->penalty, 2, ',', '.') }}</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="{{ route('admin.activity.finish', $reservation->id) }}" class="btn btn-danger">Selesaikan</a>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal('{{ $reservation->id }}')">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
