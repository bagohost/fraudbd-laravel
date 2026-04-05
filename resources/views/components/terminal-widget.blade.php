<button onclick="openFraudBdTerminal()" class="fixed bottom-6 left-6 z-[9999] bg-[#030712] border border-[#00f0ff]/50 hover:bg-[#00f0ff]/10 text-[#00f0ff] p-3 rounded-full shadow-[0_0_15px_rgba(0,240,255,0.3)] hover:shadow-[0_0_25px_rgba(0,240,255,0.6)] transition-all flex items-center justify-center group">
    <i class="fas fa-shield-alt text-2xl group-hover:scale-110 transition-transform"></i>
</button>

<div id="fraudbd-terminal-modal" class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/80 backdrop-blur-sm p-4 font-sans" style="font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
    <div class="bg-[#0a1128] w-full max-w-2xl rounded-3xl shadow-[0_0_40px_rgba(0,0,0,0.8)] border border-gray-800 overflow-hidden relative flex flex-col max-h-[90vh]">
        
        <div class="bg-gray-900 p-4 border-b border-gray-800 flex justify-between items-center shrink-0">
            <div class="flex items-center gap-3">
                <i class="fas fa-radar text-[#00f0ff] animate-pulse text-xl"></i>
                <h3 class="text-white font-black tracking-widest uppercase text-sm">Fraud.bd <span class="text-gray-500">Terminal</span></h3>
            </div>
            <button onclick="closeFraudBdTerminal()" class="text-gray-500 hover:text-red-400 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div class="p-6 bg-[#030712] shrink-0 border-b border-gray-800">
            <form id="fraudbd-search-form" onsubmit="submitFraudBdCheck(event)" class="flex gap-3">
                <input type="hidden" id="fraudbd-csrf" value="{{ csrf_token() }}">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#00f0ff]">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <input type="tel" id="fraudbd-phone-input" required placeholder="Enter Customer Phone..." class="w-full bg-[#0a1128] border border-gray-700 text-white rounded-xl focus:ring-1 focus:ring-[#00f0ff] focus:border-[#00f0ff] block p-3 pl-12 outline-none transition-all placeholder-gray-600">
                </div>
                <button type="submit" id="fraudbd-search-btn" class="bg-transparent border border-[#00f0ff] hover:bg-[#00f0ff] hover:text-black text-[#00f0ff] font-bold px-6 rounded-xl transition-all shadow-[0_0_10px_rgba(0,240,255,0.1)] uppercase text-xs tracking-widest flex items-center">
                    <span id="fraudbd-btn-text">Verify</span>
                    <i id="fraudbd-btn-spinner" class="fas fa-spinner fa-spin hidden ml-2"></i>
                </button>
            </form>
        </div>

        <div id="fraudbd-result-area" class="p-6 overflow-y-auto hidden flex-1 custom-scrollbar">
            </div>

        <div id="fraudbd-empty-state" class="p-10 flex flex-col items-center justify-center text-center flex-1">
            <div class="w-20 h-20 bg-gray-900 rounded-full flex items-center justify-center border border-gray-800 mb-4 shadow-inner">
                <i class="fas fa-fingerprint text-3xl text-gray-700"></i>
            </div>
            <p class="text-gray-500 text-sm font-medium">Enter a phone number above to calibrate trust score.</p>
        </div>

    </div>
</div>

<style>
    /* Scoped Scrollbar for Modal */
    #fraudbd-result-area::-webkit-scrollbar { width: 6px; }
    #fraudbd-result-area::-webkit-scrollbar-track { background: #030712; border-radius: 4px; }
    #fraudbd-result-area::-webkit-scrollbar-thumb { background: #1f2937; border-radius: 4px; }
    #fraudbd-result-area::-webkit-scrollbar-thumb:hover { background: #00f0ff; }
</style>

<script>
    function openFraudBdTerminal(phone = '') {
        document.getElementById('fraudbd-terminal-modal').classList.remove('hidden');
        document.getElementById('fraudbd-terminal-modal').classList.add('flex');
        if (phone) {
            document.getElementById('fraudbd-phone-input').value = phone;
            document.getElementById('fraudbd-search-form').dispatchEvent(new Event('submit'));
        }
    }

    function closeFraudBdTerminal() {
        document.getElementById('fraudbd-terminal-modal').classList.add('hidden');
        document.getElementById('fraudbd-terminal-modal').classList.remove('flex');
    }

    async function submitFraudBdCheck(e) {
        e.preventDefault();
        const phone = document.getElementById('fraudbd-phone-input').value;
        const btnText = document.getElementById('fraudbd-btn-text');
        const btnSpinner = document.getElementById('fraudbd-btn-spinner');
        const resultArea = document.getElementById('fraudbd-result-area');
        const emptyState = document.getElementById('fraudbd-empty-state');
        const csrf = document.getElementById('fraudbd-csrf').value;

        // UI Loading State
        btnText.innerText = 'Scanning...';
        btnSpinner.classList.remove('hidden');
        emptyState.classList.add('hidden');
        resultArea.classList.add('hidden');

        try {
            const response = await fetch('/fraudbd/ajax-check', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf
                },
                body: JSON.stringify({ phone: phone })
            });

            const data = await response.json();
            
            if (data && data.success && data.data) {
                renderFraudBdResult(data.data);
            } else {
                resultArea.innerHTML = `<div class="text-red-400 text-center p-4 bg-red-500/10 border border-red-500/30 rounded-xl"><i class="fas fa-exclamation-triangle mr-2"></i> Could not verify this number or API limits exceeded.</div>`;
                resultArea.classList.remove('hidden');
            }
        } catch (error) {
            resultArea.innerHTML = `<div class="text-red-400 text-center p-4 bg-red-500/10 border border-red-500/30 rounded-xl"><i class="fas fa-wifi mr-2"></i> Connection error. Please check your config.</div>`;
            resultArea.classList.remove('hidden');
        }

        // Reset UI State
        btnText.innerText = 'Verify';
        btnSpinner.classList.add('hidden');
    }

    function renderFraudBdResult(data) {
        const resultArea = document.getElementById('fraudbd-result-area');
        const stats = data.overall_stats || {};
        const successRate = stats.success_rate || 0;
        
        let colorTheme = successRate >= 80 ? 'green' : (successRate >= 50 ? 'yellow' : 'red');
        let hexColor = successRate >= 80 ? '#22c55e' : (successRate >= 50 ? '#eab308' : '#ef4444');
        if (data.trust_tier === 'Elite') { colorTheme = 'blue'; hexColor = '#3b82f6'; }

        let html = `
            <div class="flex items-center justify-between gap-4 mb-6 bg-gray-900/50 p-5 rounded-2xl border border-gray-800">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-[#030712] rounded-full border border-${colorTheme}-500/50 flex items-center justify-center shadow-[0_0_15px_${hexColor}40]">
                        <i class="fas fa-user-shield text-xl text-${colorTheme}-500"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-white tracking-tight">${data.phone}</h2>
                        <span class="text-[10px] uppercase font-bold tracking-widest text-${colorTheme}-400 bg-${colorTheme}-500/10 px-2 py-0.5 rounded border border-${colorTheme}-500/30">${data.trust_tier} Tier</span>
                    </div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-black text-white">${successRate}<span class="text-sm text-gray-500">%</span></div>
                    <div class="text-[9px] uppercase tracking-widest text-gray-500 font-bold">Trust Score</div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3 mb-6">
                <div class="bg-[#030712] p-4 rounded-xl border border-gray-800 text-center">
                    <div class="text-gray-400 text-[10px] uppercase tracking-widest font-bold mb-1">Total</div>
                    <div class="text-xl font-black text-white">${stats.total_orders || 0}</div>
                </div>
                <div class="bg-[#030712] p-4 rounded-xl border border-gray-800 text-center">
                    <div class="text-green-500 text-[10px] uppercase tracking-widest font-bold mb-1">Success</div>
                    <div class="text-xl font-black text-green-400">${stats.total_delivered || 0}</div>
                </div>
                <div class="bg-[#030712] p-4 rounded-xl border border-gray-800 text-center">
                    <div class="text-red-500 text-[10px] uppercase tracking-widest font-bold mb-1">Return</div>
                    <div class="text-xl font-black text-red-400">${(stats.total_returned || 0) + (stats.total_cancelled || 0)}</div>
                </div>
            </div>
        `;

        resultArea.innerHTML = html;
        resultArea.classList.remove('hidden');
    }
</script>