// Check copy type and paid status
const copyType = urlParams.get('copyType') || 'all';
const isPaid = urlParams.get('paid') === 'true';
const vouchers = document.querySelectorAll('.voucher-copy');

if (copyType === 'student') {
    vouchers[0].style.display = 'none';
    vouchers[2].style.display = 'none';
    document.querySelector('.vouchers-container').style.gridTemplateColumns = '1fr';
    document.querySelector('.vouchers-container').style.maxWidth = '600px';
    document.querySelector('.vouchers-container').style.margin = '0 auto';
    vouchers[1].style.fontSize = '10px';
    vouchers[1].querySelectorAll('.voucher-header h2').forEach(h => h.style.fontSize = '18px');
    vouchers[1].querySelectorAll('.voucher-header p').forEach(p => h.style.fontSize = '10px');
    vouchers[1].querySelectorAll('.detail-row').forEach(row => row.style.fontSize = '11px');
    vouchers[1].querySelectorAll('table').forEach(table => table.style.fontSize = '10px');
    vouchers[1].querySelectorAll('.voucher-type').forEach(type => type.style.fontSize = '12px');
    vouchers[1].querySelectorAll('.paid-watermark').forEach(mark => mark.style.fontSize = '60px');
}

if (isPaid) {
    document.querySelectorAll('.voucher-copy').forEach(copy => copy.classList.add('paid'));
    document.title = 'Payment Receipt - EduPro LMS';
    document.querySelectorAll('.voucher-type').forEach(type => {
        type.innerHTML += ' <span class="paid-badge">PAID</span>';
    });
}
