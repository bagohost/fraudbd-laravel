<button onclick="window.openFraudBdTerminal()" class="fixed bottom-8 right-8 z-[9999] bg-[#030712] border border-[#00f0ff]/50 hover:bg-[#00f0ff]/10 text-[#00f0ff] p-4 rounded-full shadow-[0_0_20px_rgba(0,240,255,0.4)] hover:shadow-[0_0_30px_rgba(0,240,255,0.7)] transition-all flex items-center justify-center group">
    <svg class="w-8 h-8 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
</button>

<div id="fraudbd-terminal-modal" class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/80 backdrop-blur-sm p-4 font-sans" style="font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
    <div class="bg-[#0a1128] w-full max-w-2xl rounded-3xl shadow-[0_0_40px_rgba(0,0,0,0.8)] border border-gray-800 overflow-hidden relative flex flex-col max-h-[90vh]">
        
        <div class="bg-gray-900 p-4 border-b border-gray-800 flex justify-between items-center shrink-0">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-[#00f0ff] animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path></svg>
                <h3 class="text-white font-black tracking-widest uppercase text-sm">Fraud.bd <span class="text-gray-500">Terminal</span></h3>
            </div>
            <button onclick="window.closeFraudBdTerminal()" class="text-gray-500 hover:text-red-400 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="p-6 bg-[#030712] shrink-0 border-b border-gray-800">
            <form id="fraudbd-search-form" onsubmit="window.submitFraudBdCheck(event)" class="flex gap-3">
                <input type="hidden" id="fraudbd-csrf" value="{{ csrf_token() }}">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#00f0ff]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <input type="tel" id="fraudbd-phone-input" required placeholder="Enter Customer Phone..." class="w-full bg-[#0a1128] border border-gray-700 text-white rounded-xl focus:ring-1 focus:ring-[#00f0ff] focus:border-[#00f0ff] block p-3 pl-11 outline-none transition-all placeholder-gray-600">
                </div>
                <button type="submit" id="fraudbd-search-btn" class="bg-transparent border border-[#00f0ff] hover:bg-[#00f0ff] hover:text-black text-[#00f0ff] font-bold px-6 rounded-xl transition-all shadow-[0_0_10px_rgba(0,240,255,0.1)] uppercase text-xs tracking-widest flex items-center">
                    <span id="fraudbd-btn-text">Verify</span>
                    <svg id="fraudbd-btn-spinner" class="animate-spin hidden ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>
            </form>
        </div>

        <div id="fraudbd-result-area" class="p-6 overflow-y-auto hidden flex-1 custom-scrollbar"></div>

        <div id="fraudbd-empty-state" class="p-10 flex flex-col items-center justify-center text-center flex-1">
            <div class="w-20 h-20 bg-gray-900 rounded-full flex items-center justify-center border border-gray-800 mb-4 shadow-inner">
                <svg class="w-10 h-10 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <p class="text-gray-500 text-sm font-medium">Enter a phone number above to calibrate trust score.</p>
        </div>

    </div>
</div>

<style>
    #fraudbd-result-area::-webkit-scrollbar { width: 6px; }
    #fraudbd-result-area::-webkit-scrollbar-track { background: #030712; border-radius: 4px; }
    #fraudbd-result-area::-webkit-scrollbar-thumb { background: #1f2937; border-radius: 4px; }
    #fraudbd-result-area::-webkit-scrollbar-thumb:hover { background: #00f0ff; }
</style>

<script>
    window.openFraudBdTerminal = function(phone = '') {
        document.getElementById('fraudbd-terminal-modal').classList.remove('hidden');
        document.getElementById('fraudbd-terminal-modal').classList.add('flex');
        if (phone) {
            document.getElementById('fraudbd-phone-input').value = phone;
            document.getElementById('fraudbd-search-form').dispatchEvent(new Event('submit'));
        }
    }

    window.closeFraudBdTerminal = function() {
        document.getElementById('fraudbd-terminal-modal').classList.add('hidden');
        document.getElementById('fraudbd-terminal-modal').classList.remove('flex');
    }

    window.submitFraudBdCheck = async function(e) {
        e.preventDefault();
        const phone = document.getElementById('fraudbd-phone-input').value;
        const btnText = document.getElementById('fraudbd-btn-text');
        const btnSpinner = document.getElementById('fraudbd-btn-spinner');
        const resultArea = document.getElementById('fraudbd-result-area');
        const emptyState = document.getElementById('fraudbd-empty-state');
        const csrf = document.getElementById('fraudbd-csrf').value;

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
                window.renderFraudBdResult(data.data);
            } else {
                resultArea.innerHTML = `<div class="text-red-400 text-center p-4 bg-red-500/10 border border-red-500/30 rounded-xl flex items-center justify-center"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg> Could not verify this number or API limits exceeded.</div>`;
                resultArea.classList.remove('hidden');
            }
        } catch (error) {
            resultArea.innerHTML = `<div class="text-red-400 text-center p-4 bg-red-500/10 border border-red-500/30 rounded-xl flex items-center justify-center"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg> Connection error. Please check your config.</div>`;
            resultArea.classList.remove('hidden');
        }

        btnText.innerText = 'Verify';
        btnSpinner.classList.add('hidden');
    }

    window.renderFraudBdResult = function(data) {
        const resultArea = document.getElementById('fraudbd-result-area');
        const stats = data.overall_stats || {};
        const successRate = stats.success_rate || 0;
        const couriers = data.courier_breakdown || data.history || [];
        
        let colorTheme = successRate >= 80 ? 'green' : (successRate >= 50 ? 'yellow' : 'red');
        let hexColor = successRate >= 80 ? '#22c55e' : (successRate >= 50 ? '#eab308' : '#ef4444');
        if (data.trust_tier === 'Elite') { colorTheme = 'blue'; hexColor = '#3b82f6'; }

        // FIXED Advice Box Logic: Handle if advice is an object or a string
        let adviceData = {};
        let apiAdviceMsg = null;
        
        // Extract advice text safely
        if (data.advice) {
            if (typeof data.advice === 'string') {
                apiAdviceMsg = data.advice;
            } else if (typeof data.advice === 'object' && data.advice.message) {
                 // Assuming the object might have a 'message' or 'text' property. Adjust if needed.
                apiAdviceMsg = data.advice.message || data.advice.text || JSON.stringify(data.advice);
            }
        }

        if (apiAdviceMsg && apiAdviceMsg !== '[object Object]') {
            adviceData = { msg: apiAdviceMsg, icon: 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' };
        } else if (data.trust_tier === 'Elite' || successRate >= 90) {
            adviceData = { 
                msg: 'এই কাস্টমারটি আমাদের সিস্টেমে এলিট হিসেবে চিহ্নিত। তবুও চূড়ান্ত সিদ্ধান্তের আগে নিজস্ব যাচাই করার পরামর্শ দেওয়া হচ্ছে।', 
                icon: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' 
            };
        } else if (successRate >= 80) {
            adviceData = { 
                msg: 'কাস্টমারের ডেলিভারি সাকসেস রেট ভালো। সাধারণ প্রক্রিয়ায় অর্ডারটি সম্পন্ন করা যেতে পারে, তবে প্রয়োজনে নিজস্ব যাচাই রাখতে পারেন।', 
                icon: 'M5 13l4 4L19 7' 
            };
        } else if (successRate >= 50) {
            adviceData = { 
                msg: 'অর্ডারটি প্রসেস করার আগে কাস্টমারের সাথে নিশ্চিত হওয়া এবং প্রয়োজনে আংশিক অগ্রিম নেওয়ার বিষয়টি বিবেচনা করতে পারেন।', 
                icon: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z' 
            };
        } else {
            adviceData = { 
                msg: 'ডেলিভারি সাকসেস রেট তুলনামূলক কম। অর্ডারটি প্রসেস করার আগে অতিরিক্ত যাচাই বা অগ্রিম নেওয়ার বিষয়টি গুরুত্ব সহকারে বিবেচনা করা উচিত।', 
                icon: 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' 
            };
        }

        let html = `
            <div class="flex items-center justify-between gap-4 mb-4 bg-gray-900/50 p-5 rounded-2xl border border-gray-800">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-[#030712] rounded-full border border-${colorTheme}-500/50 flex items-center justify-center shadow-[0_0_15px_${hexColor}40]">
                        <svg class="w-7 h-7 text-${colorTheme}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
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

            <div class="mb-6 bg-${colorTheme}-500/10 border border-${colorTheme}-500/30 p-4 rounded-xl flex items-start gap-3">
                <div class="text-${colorTheme}-400 shrink-0 mt-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${adviceData.icon}"></path></svg>
                </div>
                <div>
                    <h4 class="text-[10px] uppercase tracking-widest text-${colorTheme}-500 font-bold mb-1">System Advice</h4>
                    <p class="text-gray-300 text-sm leading-snug">${adviceData.msg}</p>
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

        if (couriers.length > 0) {
            html += `<div class="mt-2 border-t border-gray-800 pt-5">
                        <h4 class="text-[10px] uppercase tracking-widest text-gray-500 font-bold mb-3 flex items-center"><svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg> Courier Breakdown</h4>
                        <div class="space-y-2">`;
            
            couriers.forEach(c => {
                let returnCount = (parseInt(c.returned) || 0) + (parseInt(c.cancelled) || 0);
                let perfColor = c.performance >= 80 ? 'bg-green-500' : (c.performance >= 50 ? 'bg-yellow-500' : 'bg-red-500');
                html += `
                    <div class="bg-[#030712] p-3.5 rounded-xl border border-gray-800 flex justify-between items-center hover:border-[#00f0ff]/30 transition-colors">
                        <div class="text-gray-300 text-sm font-bold flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full ${perfColor} shadow-[0_0_5px_currentColor]"></span>
                            ${c.courier}
                        </div>
                        <div class="flex gap-4 text-xs font-mono">
                            <span class="text-gray-500" title="Total Orders">T: <b class="text-white">${c.orders}</b></span>
                            <span class="text-green-500/80" title="Delivered">S: <b class="text-green-400">${c.delivered}</b></span>
                            <span class="text-red-500/80" title="Returned">R: <b class="text-red-400">${returnCount}</b></span>
                        </div>
                    </div>
                `;
            });
            html += `</div></div>`;
        }

        resultArea.innerHTML = html;
        resultArea.classList.remove('hidden');
    }
</script>
