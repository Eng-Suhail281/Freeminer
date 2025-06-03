document.addEventListener('DOMContentLoaded', () => {
    let mining = false;
    let hashes = parseFloat(localStorage.getItem('miningHashes')) || 0;
    let miningInterval, syncInterval;

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const totalPower = 1000 + user_gpu_power;
    const hashesPerSecond = totalPower / 3600000;
    const updateInterval = 50;
    const incrementRate = hashesPerSecond * (updateInterval / 1000);
    const MINING_DURATION = 12 * 60 * 60 * 1000; // 12 ساعة

    function updateDisplays() {
        const h = hashes.toFixed(5);
        document.getElementById('hashes').innerText = h + ' Hashes';
        document.getElementById('minedHashes').innerText = h;
    }

    function startMining() {
        if (mining) return;
        mining = true;

        const now = Date.now();
        const startedAt = parseInt(localStorage.getItem('miningStartedAt'));
        const gpuPowerAtStart = parseFloat(localStorage.getItem('gpuPowerAtStart'));

        if (!startedAt || !gpuPowerAtStart) {
            // نحفظ القيم في localStorage لأول مرة فقط
            localStorage.setItem('miningStartedAt', now);
            localStorage.setItem('gpuPowerAtStart', totalPower);

            // نحدث السيرفر
            fetch('/start-mining', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ telegram_id })
            });
        }

        document.getElementById('mining-status').innerText = 'MINING STARTED';
        document.getElementById('mining-status').style.color = 'green';
        document.getElementById('startBtn').disabled = true;

        const endTime = startedAt
            ? startedAt + MINING_DURATION
            : now + MINING_DURATION;

        miningInterval = setInterval(() => {
            const currentTime = Date.now();
            if (currentTime >= endTime) {
                mining = false;
                clearInterval(miningInterval);
                clearInterval(syncInterval);
                document.getElementById('mining-status').innerText = 'MINING ENDED';
                document.getElementById('mining-status').style.color = 'red';
                document.getElementById('startBtn').disabled = false;
                localStorage.removeItem('miningStartedAt');
                localStorage.removeItem('gpuPowerAtStart');
                return;
            }

            hashes += incrementRate;
            localStorage.setItem('miningHashes', hashes);
            updateDisplays();
        }, updateInterval);

        syncInterval = setInterval(() => {
            fetch('/update-hashes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    telegram_id,
                    hashes: Math.floor(hashes)
                })
            });
        }, 5000);
    }

    // ✅ عند تحميل الصفحة: نحسب إذا كان يجب استئناف التعدين تلقائيًا
    const savedStartedAt = parseInt(localStorage.getItem('miningStartedAt'));
    const savedGpuPower = parseFloat(localStorage.getItem('gpuPowerAtStart'));

    if (savedStartedAt && savedGpuPower) {
        const now = Date.now();
        const elapsed = now - savedStartedAt;

        if (elapsed < MINING_DURATION) {
            const hashesWhileAway = (savedGpuPower / 3600000) * (elapsed / 1000);
            
            localStorage.setItem('miningHashes', hashes);
            updateDisplays();
            startMining(); // ⚠️ سيقرأ من localStorage ولن يرسل طلب start-mining مرة أخرى
        } else {
            localStorage.removeItem('miningStartedAt');
            localStorage.removeItem('gpuPowerAtStart');
            document.getElementById('startBtn').disabled = false;
            document.getElementById('mining-status').innerText = 'MINING ENDED';
            document.getElementById('mining-status').style.color = 'red';
        }
    } else {
        updateDisplays();
    }

    document.getElementById('startBtn').addEventListener('click', startMining);

    window.addEventListener('beforeunload', () => {
        localStorage.setItem('miningHashes', hashes);
        navigator.sendBeacon('/update-hashes', new Blob([
            JSON.stringify({ telegram_id, hashes: Math.floor(hashes) })
        ], { type: 'application/json' }));
    });

    window.addEventListener('focus', () => {
        hashes = parseFloat(localStorage.getItem('miningHashes')) || 0;
        updateDisplays();
    });

    window.showExchangeModal = () => {
        if (hashes < 3) return alert('At least 3 hashes required');
        const fmt = (hashes / 100).toFixed(5);
        document.getElementById('modalMessage').innerText =
            `You have ${hashes.toFixed(5)} hashes\nReceive ${fmt} FMT?`;
        document.getElementById('exchangeModal').style.display = 'flex';
    };

    window.closeExchangeModal = () => {
        document.getElementById('exchangeModal').style.display = 'none';
    };

    window.confirmExchange = () => {
        fetch('/exchange-hashes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ hashes: Math.floor(hashes) })
        })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                document.getElementById('currentBalance').innerText = parseFloat(d.balance).toFixed(2);
                hashes = 0;
                localStorage.setItem('miningHashes', hashes);
                updateDisplays();
            } else {
                alert(d.error || 'Exchange failed');
            }
            closeExchangeModal();   
        })
        .catch(console.error);
    };
});
