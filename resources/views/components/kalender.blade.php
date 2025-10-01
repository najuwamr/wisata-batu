<div x-data="calendar()" class="py-4 max-w-xs mx-auto">
    {{-- Header Bulan --}}
    <div class="flex items-center justify-between mb-2">
        <button @click="prevMonth" class="px-2">&lt;</button>
        <h2 class="font-semibold text-lg" x-text="monthNames[month] + ' ' + year"></h2>
        <button @click="nextMonth" class="px-2">&gt;</button>
    </div>

    {{-- Nama Hari --}}
    <div class="grid grid-cols-7 gap-1 text-xs font-semibold">
        <template x-for="day in days" :key="day">
            <div x-text="day"></div>
        </template>
    </div>

    {{-- Tanggal --}}
    <div class="grid grid-cols-7 gap-1 mt-1 text-sm">
        <template x-for="blank in blanks" :key="blank">
            <div class="aspect-square"></div>
        </template>
        <template x-for="day in daysInMonth" :key="day">
            <div
                class="aspect-square flex items-center justify-center rounded-md cursor-pointer"
                :class="isSelected(day) 
                    ? 'bg-white text-indigo-900 font-bold' 
                    : (isToday(day) ? 'bg-indigo-300 font-semibold' : 'hover:bg-indigo-700')"
                x-text="day"
                @click="selectDate(day)">
            </div>
        </template>
    </div>

    {{-- Output tanggal terpilih --}}
    <div class="mt-3 text-xs" x-show="selectedDate">
        <span class="font-semibold">Tanggal dipilih:</span>
        <span x-text="selectedDate.toLocaleDateString('id-ID', { 
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' 
        })"></span>
    </div>
</div>
