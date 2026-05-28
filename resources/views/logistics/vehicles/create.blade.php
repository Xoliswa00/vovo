<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ isset($vehicle) ? 'Edit Vehicle' : 'Add Vehicle' }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ isset($vehicle) ? route('vehicles.update', $vehicle) : route('vehicles.store') }}">
                    @csrf
                    @if(isset($vehicle)) @method('PATCH') @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Vehicle Name *</label>
                            <input type="text" name="name" value="{{ old('name', $vehicle->name ?? '') }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Registration Plate *</label>
                            <input type="text" name="registration_plate" value="{{ old('registration_plate', $vehicle->registration_plate ?? '') }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            @error('registration_plate')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Type *</label>
                            <select name="type" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @foreach(['truck','van','motorcycle','flatbed','other'] as $t)
                                    <option value="{{ $t }}" {{ old('type', $vehicle->type ?? '') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status *</label>
                            <select name="status" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @foreach(['available','on_job','maintenance'] as $s)
                                    <option value="{{ $s }}" {{ old('status', $vehicle->status ?? '') === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Make</label>
                            <input type="text" name="make" value="{{ old('make', $vehicle->make ?? '') }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" placeholder="e.g. Mercedes-Benz">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Model</label>
                            <input type="text" name="model" value="{{ old('model', $vehicle->model ?? '') }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" placeholder="e.g. Actros">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Year</label>
                            <input type="number" name="year" value="{{ old('year', $vehicle->year ?? '') }}" min="1990" max="{{ date('Y')+1 }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Capacity (kg)</label>
                            <input type="number" name="capacity_kg" value="{{ old('capacity_kg', $vehicle->capacity_kg ?? '') }}" min="0" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" rows="3" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('notes', $vehicle->notes ?? '') }}</textarea>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ isset($vehicle) ? 'Update Vehicle' : 'Add Vehicle' }}
                        </button>
                        <a href="{{ route('vehicles.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
