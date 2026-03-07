@props(['items' => [], 'changes' => null, 'color' => 'primary'])

<td class="px-3 py-2 text-xs">

    @forelse ($items as $item)

        <span class="badge 
            {{ $changes ? 'badge-light-success' : "badge-light-$color" }}">
            {{ ucfirst(str_replace('_',' ',$item)) }}
        </span>

    @empty
        <span class="text-gray-400">N/A</span>
    @endforelse

    @if($changes)
        <div class="text-xs text-gray-500 mt-1">
            Antes:

            @foreach((array) ($changes['old'] ?? []) as $old)
                <span class="badge badge-light-danger">
                    <s>{{ ucfirst(str_replace('_',' ',$old)) }}</s>
                </span>
            @endforeach

        </div>
    @endif

</td>