{{--
    Global confirm modal. Trigger by dispatching:
        $dispatch('open-confirm', { message: '...', action: '/route', method: 'DELETE' })

    Listens on window so works from any Alpine component.
--}}
<div
    x-data="{
        show: false,
        message: '',
        action: '',
        method: 'DELETE',
        open(detail) {
            this.message = detail.message || 'Are you sure?';
            this.action  = detail.action;
            this.method  = detail.method || 'DELETE';
            this.show    = true;
        },
        confirm() {
            this.$refs.hiddenForm.submit();
            this.show = false;
        }
    }"
    @open-confirm.window="open($event.detail)"
    @keydown.escape.window="show = false"
>
    {{-- Hidden form that fires on confirm --}}
    <form x-ref="hiddenForm" method="POST" :action="action">
        @csrf
        <input type="hidden" name="_method" :value="method">
    </form>

    {{-- Backdrop --}}
    <div
        x-show="show"
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900/60 z-40"
        @click="show = false"
        style="display:none"
    ></div>

    {{-- Modal panel --}}
    <div
        x-show="show"
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display:none"
    >
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6">
            <div class="flex items-start gap-4">
                <div class="shrink-0 w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 text-xl">
                    ⚠
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900 mb-1">Confirm Action</h3>
                    <p class="text-sm text-gray-500" x-text="message"></p>
                </div>
            </div>
            <div class="mt-5 flex justify-end gap-3">
                <button
                    @click="show = false"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition"
                >
                    Cancel
                </button>
                <button
                    @click="confirm()"
                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition"
                >
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>
