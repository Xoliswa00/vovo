@props(['inputName' => 'images[]'])

<div
    x-data="{
        previews: [],
        dragging: false,
        addFiles(fileList) {
            const dt = new DataTransfer();
            Array.from($refs.input.files).forEach(f => dt.items.add(f));
            Array.from(fileList).forEach(f => { if (f.type.startsWith('image/')) dt.items.add(f); });
            $refs.input.files = dt.files;
            this.refreshPreviews();
        },
        refreshPreviews() {
            this.previews = Array.from($refs.input.files).map(f => ({ name: f.name, url: URL.createObjectURL(f) }));
        },
        removeFile(index) {
            const dt = new DataTransfer();
            Array.from($refs.input.files).forEach((f, i) => { if (i !== index) dt.items.add(f); });
            $refs.input.files = dt.files;
            this.refreshPreviews();
        }
    }"
>
    <label
        @dragover.prevent="dragging = true"
        @dragleave.prevent="dragging = false"
        @drop.prevent="dragging = false; addFiles($event.dataTransfer.files)"
        :class="dragging ? 'border-accent bg-accent/5' : 'border-gray-300'"
        class="flex flex-col items-center justify-center gap-2 border-2 border-dashed rounded-xl p-6 text-center cursor-pointer transition-colors hover:border-accent"
    >
        <i class="bi bi-cloud-arrow-up text-3xl text-muted"></i>
        <span class="text-sm text-gray-600">Drag photos here or <span class="text-accent font-semibold">browse</span></span>
        <span class="text-xs text-gray-400">JPG, PNG, WEBP — max 2MB each</span>
        <input x-ref="input" type="file" name="{{ $inputName }}" multiple accept="image/*" class="hidden" @change="refreshPreviews()">
    </label>

    <div class="flex gap-2 mt-3 flex-wrap" x-show="previews.length" x-cloak>
        <template x-for="(file, index) in previews" :key="index">
            <div class="relative w-20 h-20 rounded-lg overflow-hidden border">
                <img :src="file.url" class="w-full h-full object-cover">
                <button type="button" @click="removeFile(index)" class="absolute top-0.5 right-0.5 w-5 h-5 rounded-full bg-black/60 text-white text-xs flex items-center justify-center" aria-label="Remove">&times;</button>
            </div>
        </template>
    </div>
</div>
