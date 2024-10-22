@extends('admin.layouts.master')

@section('judul', 'Dashboard Admin')

@section('content')
    <div class="container-fluid mt-1">
        <h3 class="text-center text-danger mt-4 mb-1">Denah Locker</h3>
        <div class="card border-0">
            <div class="card-body">
                <div class="container">
                    <div class="row justify-content-center">
                        @foreach ($lockers as $index => $item)
                            @if ($index % 10 === 0 && $index != 0)
                    </div>
                    <div class="row justify-content-center">
                        @endif
                        <div class="col-1 p-0">
                            <div class="text-center">
                                <div class="p-1">
                                    <a href="#" onclick="event.preventDefault()"
                                        class="btn locker {{ $item->is_available ? 'btn-secondary' : 'btn-danger' }} w-100">
                                        {{ $item->locker_code }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <form action="{{ route('admin.locker.reserve') }}" method="POST">
                    @csrf
                    <div class="container">
                        <div class="row mt-5">
                            <div class="col">
                                <label for="locker">Pilih Loker (Maksimal 5)</label>
                                <select name="lockers[]" id="locker" class="form-control" multiple required>
                                    @foreach ($lockers as $locker)
                                        @if ($locker->is_available)
                                            <option value="{{ $locker->locker_code }}">{{ $locker->locker_code }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="keterangan" class="mb-4 text-start">Keterangan:</label>
                                <br>
                                <div class="text-center ">
                                    <button class="btn btn-secondary" style="width: 40px; height: 40px;"></button>
                                    <span class="ms-2 text-dark">Kosong</span>
                                    <button class="btn btn-danger ms-4" style="width: 40px; height: 40px;"></button>
                                    <span class="ms-2 text-dark">Terisi</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="name">Nama</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="col">
                            <label for="item_name">Nama Barang</label>
                            <input type="text" name="item_name" id="item_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Nomor Telepon</label>
                        <input type="tel" name="phone_number" id="phone_number" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="deposit_time">Jam Penitipan</label>
                            <input type="time" name="deposit_time" id="deposit_time" class="form-control" required>
                        </div>
                        <div class="col">
                            <label for="pickup_time">Jam Pengambilan</label>
                            <input type="time" name="pickup_time" id="pickup_time" class="form-control" required>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mt-2">Konfirmasi Penitipan</button>
                    </div>
                </form>
            </div>
        </div>
    @endsection
