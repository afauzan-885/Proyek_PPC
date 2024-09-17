<div class="d-flex align-items-center">
    <button wire:click="togglePing" class="btn btn-primary btn-sm">
        {{ $showPing ? 'Stop Ping' : 'Cek Ping' }}
    </button>
    @if ($downloadSpeed)
        <span class="ms-2">Speed: {{ $downloadSpeed }}</span>
    @endif
    @if ($latency)
        <span class="ms-2">{{ $latency }}
            @if ((float) str_replace(' ms', '', $latency) < 25)
                <i class="bi bi-reception-4" style="color: rgb(0, 255, 0)"></i>
            @elseif ((float) str_replace(' ms', '', $latency) < 50)
                <i class="bi bi-reception-3" style="color: rgb(166, 255, 0)"></i>
            @elseif ((float) str_replace(' ms', '', $latency) < 100)
                <i class="bi bi-reception-2" style="color: rgb(255, 247, 0)"></i>
            @elseif ((float) str_replace(' ms', '', $latency) < 200)
                <i class="bi bi-reception-1" style="color: rgb(255, 153, 0)"></i>
            @else
                <i class="bi bi-reception-0" style="color: rgb(255, 81, 0)"></i>
            @endif
        </span>
    @endif

    @if ($showPing)
        <div wire:poll.1000ms="ping"></div>
    @endif
</div>
