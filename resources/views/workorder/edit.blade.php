<form id="editForm" action="{{ route('workorder.update', encrypt($workorder->id)) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')
    
    <!-- Product Name Input -->
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="product_name">
            Product Name<span class="text-red-500">*</span>
        </label>
        @if(auth()->user()->role === 'manager')
            <input 
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('product_name') border-red-500 @enderror"
                id="product_name"
                type="text"
                name="product_name"
                value="{{ old('product_name', $workorder->product_name) }}"
                placeholder="Enter product name"
            >
        @else
            <input 
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('product_name') border-red-500 @enderror"
                id="product_name"
                type="text"
                name="product_name"
                value="{{ old('product_name', $workorder->product_name) }}"
                disabled
                title="Only managers can edit product name"
            >
            <p class="text-gray-500 text-xs italic mt-1">Note: Only managers can edit the product name</p>
        @endif
        @error('product_name')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>

    <!-- Quantity Input -->
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="quantity">
            Quantity<span class="text-red-500">*</span>
        </label>
        <input 
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('quantity') border-red-500 @enderror"
            id="quantity"
            type="number"
            name="quantity"
            value="{{ old('quantity', $workorder->quantity) }}"
            placeholder="Enter quantity"
        >
        @error('quantity')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>

    <!-- Deadline Input -->
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="deadline">
            Deadline Production<span class="text-red-500">*</span>
        </label>
        @if(auth()->user()->role === 'manager')
            <input 
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('deadline') border-red-500 @enderror"
                id="deadline"
                type="date"
                name="deadline"
                value="{{ old('deadline', $workorder->deadline ? \Carbon\Carbon::parse($workorder->deadline)->format('Y-m-d') : '') }}"
            >
        @else
            <input 
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('deadline') border-red-500 @enderror"
                id="deadline"
                type="date"
                name="deadline"
                value="{{ old('deadline', $workorder->deadline ? \Carbon\Carbon::parse($workorder->deadline)->format('Y-m-d') : '') }}"
                disabled
                title="Only managers can edit deadline"
            >
            <p class="text-gray-500 text-xs italic mt-1">Note: Only managers can edit the deadline</p>
        @endif
        @error('deadline')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>

    <!-- Status Select -->
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="status">
            Status<span class="text-red-500">*</span>
        </label>
        <select 
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('status') border-red-500 @enderror"
            id="status"
            name="status"
        >
            <option value="">Select Status</option>
            @php
                $statusOrder = ['pending' => 1, 'in_progress' => 2, 'completed' => 3, 'canceled' => 4];
                $currentStatus = $workorder->status;
                $currentStatusOrder = $statusOrder[$currentStatus] ?? 0;
            @endphp
            @foreach(['pending', 'in_progress', 'completed', 'canceled'] as $status)
                @php
                    $disabled = auth()->user()->role !== 'manager' && (
                        $statusOrder[$status] < $currentStatusOrder || 
                        ($currentStatus === 'completed' && $status === 'canceled') ||
                        ($currentStatus === 'canceled')
                    );
                @endphp
                <option 
                    value="{{ $status }}" 
                    {{ old('status', $workorder->status) == $status ? 'selected' : '' }}
                    {{ $disabled ? 'disabled' : '' }}
                >
                    {{ ucwords(str_replace('_', ' ', $status)) }}
                </option>
            @endforeach
        </select>
        @error('status')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>

    <!-- Assigned Select -->
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="assigned">
            Assigned<span class="text-red-500">*</span>
        </label>
        @if(auth()->user()->role === 'manager')
            <select 
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('assigned') border-red-500 @enderror"
                id="assigned"
                name="assigned"
            >
                <option value="">Select Operator</option>
                @foreach($operators as $operator)
                    <option 
                        value="{{ $operator->id }}" 
                        {{ old('assigned', $workorder->assigned) == $operator->id ? 'selected' : '' }}
                    >
                        {{ $operator->name }}
                    </option>
                @endforeach
            </select>
        @else
            <select 
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('assigned') border-red-500 @enderror"
                id="assigned"
                name="assigned"
                disabled
                title="Only managers can assign operators"
            >
                <option value="">Select Operator</option>
                @foreach($operators as $operator)
                    <option 
                        value="{{ $operator->id }}" 
                        {{ old('assigned', $workorder->assigned) == $operator->id ? 'selected' : '' }}
                    >
                        {{ $operator->name }}
                    </option>
                @endforeach
            </select>
            <p class="text-gray-500 text-xs italic mt-1">Note: Only managers can assign operators</p>
        @endif
        @error('assigned')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>

    <!-- Description -->
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
            Description
        </label>
        <textarea 
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror"
            id="description"
            name="description"
            placeholder="Enter description"
        >{{ old('description', $workorder->description) }}</textarea>
        @error('description')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>

     <!-- Update Form Actions -->
     <div class="flex justify-end space-x-4">
        <button 
            type="submit"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        >
            Update
        </button>
        <button 
            type="button"
            onclick="closeEditModal()"
            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
        >
            Cancel
        </button>
    </div>
</form>

<script>
document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    fetch(this.action, {
        method: 'POST',
        body: new FormData(this),
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeEditModal();
            window.location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
});
</script>