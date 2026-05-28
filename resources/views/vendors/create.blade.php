<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ isset($vendor) ? 'Edit Vendor' : 'Add Vendor' }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ isset($vendor) ? route('vendors.update', $vendor) : route('vendors.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if(isset($vendor)) @method('PATCH') @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Business Name *</label>
                            <input type="text" name="business_name" value="{{ old('business_name', $vendor->business_name ?? '') }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $vendor->phone ?? '') }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status *</label>
                            <select name="status" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @foreach(['active','inactive','pending'] as $s)
                                    <option value="{{ $s }}" {{ old('status', $vendor->status ?? 'pending') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Linked User</label>
                            <select name="user_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">— None —</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $vendor->user_id ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Logo</label>
                            <input type="file" name="logo" accept="image/*" class="mt-1 w-full border border-gray-300 rounded-md p-2">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" name="address" value="{{ old('address', $vendor->address ?? '') }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" rows="3" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $vendor->description ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            {{ isset($vendor) ? 'Update Vendor' : 'Add Vendor' }}
                        </button>
                        <a href="{{ route('vendors.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
