<div
    x-data="{
        toasts: [],
        add(type, message) {
            const id = Date.now();
            this.toasts.push({ id, type, message, visible: false });
            this.$nextTick(() => {
                const t = this.toasts.find(t => t.id === id);
                if (t) t.visible = true;
            });
            setTimeout(() => this.remove(id), 4500);
        },
        remove(id) {
            const t = this.toasts.find(t => t.id === id);
            if (t) t.visible = false;
            setTimeout(() => this.toasts = this.toasts.filter(t => t.id !== id), 400);
        }
    }"
    x-init="
        @if(session('success')) add('success', {{ Js::from(session('success')) }}); @endif
        @if(session('error'))   add('error',   {{ Js::from(session('error')) }});   @endif
        @if(session('info'))    add('info',     {{ Js::from(session('info')) }});    @endif
        $el.addEventListener('toast', e => add(e.detail.type || 'info', e.detail.message));
        window.addEventListener('toast', e => add(e.detail.type || 'info', e.detail.message));
    "
    class="fixed bottom-5 right-5 z-50 flex flex-col gap-3 pointer-events-none"
    style="min-width: 300px; max-width: 420px;"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="toast.visible"
            x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="translate-x-full opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transform transition ease-in duration-300"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="translate-x-full opacity-0"
            class="flex items-start gap-3 rounded-xl shadow-2xl px-4 py-3 pointer-events-auto border"
            :class="{
                'bg-green-50 border-green-200 text-green-900': toast.type === 'success',
                'bg-red-50 border-red-200 text-red-900':     toast.type === 'error',
                'bg-blue-50 border-blue-200 text-blue-900':  toast.type === 'info',
                'bg-yellow-50 border-yellow-200 text-yellow-900': toast.type === 'warning',
            }"
        >
            {{-- Icon --}}
            <div class="shrink-0 mt-0.5 text-xl">
                <span x-show="toast.type === 'success'">✅</span>
                <span x-show="toast.type === 'error'">❌</span>
                <span x-show="toast.type === 'info'">ℹ️</span>
                <span x-show="toast.type === 'warning'">⚠️</span>
            </div>
            {{-- Message --}}
            <p class="flex-1 text-sm font-medium leading-snug" x-text="toast.message"></p>
            {{-- Close --}}
            <button @click="remove(toast.id)" class="shrink-0 opacity-50 hover:opacity-100 transition text-lg leading-none">&times;</button>
        </div>
    </template>
</div>
