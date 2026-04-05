@props(['phone'])

<button type="button" onclick="openFraudBdTerminal('{{ $phone }}')" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-[#00f0ff]/10 text-[#00f0ff] hover:bg-[#00f0ff] hover:text-black border border-[#00f0ff]/30 transition-all shadow-[0_0_10px_rgba(0,240,255,0.2)] ml-2" title="Verify Trust Score">
    <i class="fas fa-shield-alt text-xs"></i>
</button>