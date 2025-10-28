{{-- resources/views/components/kalender.blade.php --}}
<div x-data="calendar()" class="p-4">
    {{-- Header Bulan --}}
    <div class="flex items-center justify-between mb-3">
        <button @click="prevMonth" type="button" class="px-3 py-1 rounded hover:bg-white/10">
            &lt;
        </button>

        <h2 class="font-bold text-xl" x-text="monthNames[month] + ' ' + year"></h2>

        <button @click="nextMonth" type="button" class="px-3 py-1 rounded hover:bg-white/10">
            &gt;
        </button>
    </div>

    {{-- Nama Hari (Minggu - Sabtu) --}}
    <div class="grid grid-cols-7 gap-1 text-lg font-bold text-center mb-1">
        <template x-for="(d, i) in days" :key="i">
            <div x-text="d"></div>
        </template>
    </div>

    {{-- Tanggal (grid 7 kolom) --}}
    <div class="grid grid-cols-7 gap-1 mt-1 text-lg">
        <!-- blanks: kotak kosong sebelum tanggal 1 -->
        <template x-for="b in blanks" :key="'b-'+b">
            <div class="aspect-square"></div>
        </template>

        <!-- tanggal di bulan -->
        <template x-for="date in daysArray" :key="date">
            <div
                class="aspect-square flex items-center justify-center rounded-md select-none"
                :class="{
                    'bg-indigo-300 font-semibold': isToday(date),
                    'bg-blue-50 text-blue-900 font-bold': isSelected(date),
                    'hover:bg-blue-900 hover:text-blue-50 cursor-pointer': !isSelected(date) && !isPast(date) && !isBeyondLimit(date),
                    'opacity-50 cursor-not-allowed pointer-events-none': isPast(date) || isBeyondLimit(date)
                }"
                x-text="date"
                @click="!isPast(date) && !isBeyondLimit(date) && selectDate(date)">
            </div>
        </template>
    </div>

    {{-- Output tanggal terpilih --}}
    <div class="mt-3 text-xs" x-show="selectedDate">
        <span class="font-semibold">Tanggal Kedatangan: </span>
        <span x-text="selectedDate ? selectedDate.toLocaleDateString('id-ID', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        }) : ''"></span>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
<script>
function calendar() {
    return {
        month: new Date().getMonth(),
        year: new Date().getFullYear(),
        selectedDate: null,
        startDay: 'sunday',

        init() {
            const savedDate = localStorage.getItem('selectedDate');
            if (savedDate) {
                this.formattedDate = savedDate; // biar dikirim ke backend
                const [year, month, day] = savedDate.split('-').map(Number);
                this.year = year;
                this.month = month - 1;
                this.selectedDate = new Date(year, month - 1, day);
            }
        },

        // 🔒 Batas tanggal: mulai hari ini sampai 30 hari ke depan
        minDate: new Date(),
        maxDate: new Date(new Date().setDate(new Date().getDate() + 30)),

        formattedDate: '',

        selectDate(day) {
            const date = new Date(this.year, this.month, day);
            if (date < this.minDate || date > this.maxDate) return;

            this.selectedDate = date;

            // Format ke yyyy-mm-dd
            const iso = [
                date.getFullYear(),
                String(date.getMonth() + 1).padStart(2, '0'),
                String(date.getDate()).padStart(2, '0')
            ].join('-');

            // simpan ke hidden input
            this.formattedDate = iso;

            // Simpan ke localStorage juga
            localStorage.setItem('selectedDate', iso);

            this.$dispatch('date-selected', { date: iso });
        },


        get days() {
            return this.startDay === 'monday'
                ? ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']
                : ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        },

        monthNames: [
            'Januari','Februari','Maret','April','Mei','Juni',
            'Juli','Agustus','September','Oktober','November','Desember'
        ],

        get daysInMonthCount() {
            return new Date(this.year, this.month + 1, 0).getDate();
        },

        get daysArray() {
            return Array.from({ length: this.daysInMonthCount }, (_, i) => i + 1);
        },

        get blanks() {
            let firstDay = new Date(this.year, this.month, 1).getDay();
            if (this.startDay === 'monday') {
                return Array.from({ length: (firstDay + 6) % 7 }, (_, i) => i);
            }
            return Array.from({ length: firstDay }, (_, i) => i);
        },

        isToday(day) {
            let t = new Date();
            return day === t.getDate() && this.month === t.getMonth() && this.year === t.getFullYear();
        },

        isSelected(day) {
            return this.selectedDate &&
                day === this.selectedDate.getDate() &&
                this.month === this.selectedDate.getMonth() &&
                this.year === this.selectedDate.getFullYear();
        },

        // 🚫 Batas bawah (tanggal sebelum hari ini)
        isPast(day) {
            const check = new Date(this.year, this.month, day);
            return check < new Date(this.minDate.getFullYear(), this.minDate.getMonth(), this.minDate.getDate());
        },

        // 🚫 Batas atas (lebih dari 30 hari ke depan)
        isBeyondLimit(day) {
            const check = new Date(this.year, this.month, day);
            return check > this.maxDate;
        },

        prevMonth() {
            const lastDatePrevMonth = new Date(this.year, this.month, 0); 

            if (lastDatePrevMonth < this.minDate) return;

            if (this.month === 0) {
                this.month = 11;
                this.year--;
            } else {
                this.month--;
            }
        },

        nextMonth() {
            const next = new Date(this.year, this.month + 1, 1);
            // ❌ Jangan maju kalau semua tanggal di bulan itu > maxDate
            if (next > this.maxDate) return;
            if (this.month === 11) { this.month = 0; this.year++; }
            else { this.month++; }
        }
    }
}
</script>

