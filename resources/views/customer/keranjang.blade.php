@extends('layouts.guest')

@section('title', 'Keranjang')

@section('content')
<div class="p-8">
    <h1 class="pb-0 text-3xl font-bold text-blue-900">Pilih Tiket & Tanggal</h1>
    <p class="font-thin text-gray-700">Notes: Jangan lupa tambahkan jenis kendaraan bila membawa ya!</p>

    {{-- content kanan kiri --}}
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Kolom kiri (kalender + keranjang) --}}
        <div class="space-y-6">

            {{-- Kalender --}}
            <div class="bg-indigo-900 text-white rounded-xl p-2">
                @include('components.kalender')
            </div>

            {{-- Keranjang --}}
            <div class="bg-white rounded-xl shadow p-4">
                <h2 class="font-bold text-gray-800">Keranjang</h2>
                <p class="text-sm text-gray-500">Belum ada tiket dipilih.</p>
            </div>
        </div>

        {{-- Kolom kanan --}}
        <div>
            <div>
                {{-- tiket list di sini --}}
            </div>
        </div>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
<script>
function calendar() {
    return {
        month: new Date().getMonth(),
        year: new Date().getFullYear(),
        selectedDate: null,
        days: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
        monthNames: [
            'Januari','Februari','Maret','April','Mei','Juni',
            'Juli','Agustus','September','Oktober','November','Desember'
        ],

        get daysInMonth() {
            return new Date(this.year, this.month + 1, 0).getDate();
        },
        get blanks() {
            let firstDay = new Date(this.year, this.month, 1).getDay();
            return Array.from({ length: (firstDay + 6) % 7 });
        },
        isToday(day) {
            let today = new Date();
            return day === today.getDate() &&
                   this.month === today.getMonth() &&
                   this.year === today.getFullYear();
        },
        isSelected(day) {
            return this.selectedDate &&
                   day === this.selectedDate.getDate() &&
                   this.month === this.selectedDate.getMonth() &&
                   this.year === this.selectedDate.getFullYear();
        },
        selectDate(day) {
            this.selectedDate = new Date(this.year, this.month, day);
        },
        prevMonth() {
            if (this.month === 0) { this.month = 11; this.year--; }
            else { this.month--; }
        },
        nextMonth() {
            if (this.month === 11) { this.month = 0; this.year++; }
            else { this.month++; }
        }
    }
}
</script>

@endsection
