/**
 * Finance & Salary Management Functions
 * Handles Financial Dashboard, Fee Tracking, Expenses, and Salary Generation
 */

const STORAGE_KEYS = {
    TRANSACTIONS: 'lms_finance_transactions', // Unified storage for Income & Expense
    FEES: 'lms_fee_payments',
    SALARIES: 'lms_staff_salaries',
    SALARY_PAYMENTS: 'lms_salary_history'
};

document.addEventListener('DOMContentLoaded', function () {
    if (window.location.pathname.includes('finance.html')) {
        initFinanceData();
        loadFinanceDashboard();

        // Attach Event Listeners to Forms
        const incomeForm = document.getElementById('incomeForm');
        if (incomeForm) incomeForm.addEventListener('submit', handleAddIncome);

        const expenseForm = document.getElementById('expenseForm');
        if (expenseForm) expenseForm.addEventListener('submit', handleAddExpense);
    }
});

function initFinanceData() {
    if (!localStorage.getItem(STORAGE_KEYS.TRANSACTIONS)) {
        const dummyData = [
            { id: 1701, type: 'credit', category: 'Fee Collection', amount: 25000, date: '2024-12-01', method: 'Cash', description: 'Batch A Fees', status: 'Active', audit: { createdBy: 'System' } },
            { id: 1702, type: 'debit', category: 'Utilities', amount: 4500, date: '2024-12-05', method: 'Bank Transfer', description: 'Electricity Bill', status: 'Active', audit: { createdBy: 'System' } },
            { id: 1703, type: 'credit', category: 'Grant', amount: 10000, date: '2024-12-10', method: 'Cheque', description: 'Government Grant', status: 'Active', audit: { createdBy: 'System' } }
        ];
        localStorage.setItem(STORAGE_KEYS.TRANSACTIONS, JSON.stringify(dummyData));
    }
}

function loadFinanceDashboard() {
    const transactions = JSON.parse(localStorage.getItem(STORAGE_KEYS.TRANSACTIONS)) || [];

    // Calculate Totals
    let totalRevenue = 0;
    let totalExpenses = 0;

    transactions.forEach(t => {
        if (t.type === 'credit') totalRevenue += parseFloat(t.amount);
        if (t.type === 'debit') totalExpenses += parseFloat(t.amount);
    });

    const netProfit = totalRevenue - totalExpenses;

    // Update KPIs
    safeSetText('kpiRevenue', `$${formatCurrency(totalRevenue)}`);
    safeSetText('kpiExpenses', `$${formatCurrency(totalExpenses)}`);
    safeSetText('kpiProfit', `$${formatCurrency(netProfit)}`);

    // Render Charts
    renderFinanceChart(totalRevenue, totalExpenses);

    // Render Tables
    renderTransactionsTable(transactions);
}

function handleAddIncome(e) {
    e.preventDefault();
    addTransaction(e.target, 'credit');
}

function handleAddExpense(e) {
    e.preventDefault();
    addTransaction(e.target, 'debit');
}

function addTransaction(form, type) {
    const formData = new FormData(form);
    const newTrx = {
        id: Date.now(),
        type: type,
        category: formData.get('category'),
        amount: parseFloat(formData.get('amount')),
        date: formData.get('date'),
        description: formData.get('description')
    };

    const transactions = JSON.parse(localStorage.getItem(STORAGE_KEYS.TRANSACTIONS)) || [];
    transactions.push(newTrx);
    localStorage.setItem(STORAGE_KEYS.TRANSACTIONS, JSON.stringify(transactions));

    showToast(type === 'credit' ? 'Income Added' : 'Expense Added', 'success');

    // Close Modal
    const modalId = type === 'credit' ? 'addIncomeModal' : 'addExpenseModal';
    const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
    if (modal) modal.hide();

    form.reset();
    loadFinanceDashboard();
}

function renderTransactionsTable(transactions) {
    // Render in Expense Tab (showing all or just expenses? User asked for "Expense Management")
    // Let's show All Transactions in the 'Reports' or specific 'Expenses' tab. 
    // For now, populating the 'expenseTableBody' with just Debits as requested by "Expense Records" title.

    const expenseTable = document.getElementById('expenseTableBody');
    if (expenseTable) {
        const expenses = transactions.filter(t => t.type === 'debit');
        expenseTable.innerHTML = expenses.map(t => `
            <tr>
                <td>
                    <div class="fw-bold">${t.description}</div>
                    <small class="text-muted">${t.category}</small>
                </td>
                <td>$${formatCurrency(t.amount)}</td>
                <td>${t.date}</td>
                <td><span class="badge bg-light text-dark border">Debit</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteTransaction(${t.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    }
}

function deleteTransaction(id) {
    if (!confirm('Delete this record?')) return;

    let transactions = JSON.parse(localStorage.getItem(STORAGE_KEYS.TRANSACTIONS)) || [];
    transactions = transactions.filter(t => t.id !== id);
    localStorage.setItem(STORAGE_KEYS.TRANSACTIONS, JSON.stringify(transactions));

    loadFinanceDashboard();
    showToast('Record deleted', 'info');
}

// Helpers
function formatCurrency(num) {
    return num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}



// Helper to safely set text content
function safeSetText(id, text) {
    const el = document.getElementById(id);
    if (el) el.innerText = text;
}

function renderFinanceChart(revenue, expense) {
    // 1. Overview Chart
    const ctxOverview = document.getElementById('financeOverviewChart');
    if (ctxOverview) {
        if (window.financeChartInstance) window.financeChartInstance.destroy();

        const profit = Math.max(0, revenue - expense);
        window.financeChartInstance = new Chart(ctxOverview, {
            type: 'doughnut',
            data: {
                labels: ['Expenses', 'Net Profit'],
                datasets: [{
                    data: [expense, profit],
                    backgroundColor: ['#ef4444', '#10b981'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } },
                cutout: '70%'
            }
        });
    }

    // 2. Expense Breakdown Chart
    const ctxBreakdown = document.getElementById('expenseBreakdownChart');
    if (ctxBreakdown) {
        if (window.expenseChartInstance) window.expenseChartInstance.destroy();

        const transactions = JSON.parse(localStorage.getItem(STORAGE_KEYS.TRANSACTIONS)) || [];
        const expenses = transactions.filter(t => t.type === 'debit' && t.status !== 'Void');

        // Aggregate by Category
        const categoryTotals = {};
        expenses.forEach(t => {
            categoryTotals[t.category] = (categoryTotals[t.category] || 0) + parseFloat(t.amount);
        });

        const labels = Object.keys(categoryTotals);
        const data = Object.values(categoryTotals);
        const colors = ['#f87171', '#fb923c', '#fbbf24', '#a3e635', '#60a5fa', '#818cf8', '#c084fc'];

        window.expenseChartInstance = new Chart(ctxBreakdown, {
            type: 'pie',
            data: {
                labels: labels.length ? labels : ['No Data'],
                datasets: [{
                    data: data.length ? data : [1],
                    backgroundColor: data.length ? colors.slice(0, data.length) : ['#e5e7eb'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12 } }
                }
            }
        });
    }
}

// Export global for inline calls if needed
window.deleteTransaction = deleteTransaction;
window.openEditTransactionModal = openEditTransactionModal;
window.handleEditTransactionSubmit = handleEditTransactionSubmit;

/**
 * FEE MANAGEMENT
 */
function loadFeesTable() {
    console.log("Fee management removed");
}

function openCollectFeeModal(id) {
    console.log("Fee management removed");
}

// Hook up the form submission
document.addEventListener('DOMContentLoaded', () => {
    const collectForm = document.getElementById('collectFeeForm');
    if (collectForm) {
        // Remove existing listener to avoid duplicates if re-run (though DOMContentLoaded runs once)
        collectForm.removeEventListener('submit', handleFeeSubmit);
        collectForm.addEventListener('submit', handleFeeSubmit);
    }
});

function handleFeeSubmit(e) {
    e.preventDefault();
    processFeePayment();
}

function processFeePayment() {
    const id = parseInt(document.getElementById('feeId').value);
    const amount = parseFloat(document.getElementById('feeAmount').value);
    const method = document.getElementById('feeMethod').value;

    if (!amount || amount <= 0) return alert("Invalid Amount");

    let fees = JSON.parse(localStorage.getItem(STORAGE_KEYS.FEES)) || [];
    const index = fees.findIndex(f => f.id === id);
    if (index === -1) return;

    const fee = fees[index];
    const previousPaid = fee.paid || 0;
    const newPaid = previousPaid + amount;
    const total = fee.amount;

    if (newPaid > total + 0.01) return alert("Amount exceeds balance!"); // simple tolerance

    // Update Fee Record
    fees[index].paid = newPaid;
    if (newPaid >= total - 0.01) {
        fees[index].paid = total;
        fees[index].status = 'Paid';
    } else {
        fees[index].status = 'Partial';
    }
    localStorage.setItem(STORAGE_KEYS.FEES, JSON.stringify(fees));

    // Add Income Transaction WITH METHOD
    addTransaction(null, 'credit', {
        category: 'Fee Collection',
        amount: amount, // Only the collected amount
        date: new Date().toISOString().split('T')[0],
        method: method, // Pass the selected method
        description: `Fee Payment (${method}) - ${fee.student} (${fee.month})`
    });

    // Close Modal
    const modalEl = document.getElementById('collectFeeModal');
    const modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) modal.hide();

    document.getElementById('collectFeeForm').reset();
    loadFeesTable();
}

// Adjusted addTransaction to handle direct calls
function addTransaction(form, type, directData = null) {
    let data;
    if (directData) {
        data = { ...directData, id: Date.now(), type, status: 'Active' };
    } else {
        const formData = new FormData(form);
        data = {
            id: Date.now(),
            type: type,
            category: formData.get('category'),
            amount: parseFloat(formData.get('amount')),
            date: formData.get('date'),
            method: formData.get('method') || 'Cash',
            description: formData.get('description'),
            status: 'Active',
            audit: { createdBy: 'Super Admin', timestamp: new Date().toISOString() }
        };
    }

    const transactions = JSON.parse(localStorage.getItem(STORAGE_KEYS.TRANSACTIONS)) || [];
    transactions.push(data);
    localStorage.setItem(STORAGE_KEYS.TRANSACTIONS, JSON.stringify(transactions));

    if (!directData) {
        showToast(type === 'credit' ? 'Income Added' : 'Expense Added', 'success');
        const modalId = type === 'credit' ? 'addIncomeModal' : 'addExpenseModal';
        const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
        if (modal) modal.hide();
        form.reset();
    }

    loadFinanceDashboard();
}


/**
 * EXPORT FUNCTIONS
 */
function exportFinanceData() {
    const transactions = JSON.parse(localStorage.getItem(STORAGE_KEYS.TRANSACTIONS)) || [];

    // CSV Header
    let csvContent = "data:text/csv;charset=utf-8,";
    csvContent += "ID,Date,Type,Category,Description,Amount\n";

    // CSV Rows
    transactions.forEach(t => {
        const row = `${t.id},${t.date},${t.type},"${t.category}","${t.description}",${t.amount}`;
        csvContent += row + "\n";
    });

    // Download Logic
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", `finance_report_${new Date().toISOString().split('T')[0]}.csv`);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}



window.exportFinanceData = exportFinanceData;




function renderTransactionsTable(transactions) {
    const expenseTable = document.getElementById('expenseTableBody');
    if (expenseTable) {
        // Show Expenses (Debit)
        const expenses = transactions.filter(t => t.type === 'debit');

        expenseTable.innerHTML = expenses.map(t => {
            const isVoid = t.status === 'Void';
            return `
            <tr class="${isVoid ? 'table-secondary text-muted' : ''}">
                <td>
                    <div class="fw-bold">${t.description} ${isVoid ? '(VOID)' : ''}</div>
                    <small class="text-muted">${t.category}</small>
                </td>
                <td>$${formatCurrency(t.amount)}</td>
                <td>${t.date}</td>
                <td><span class="badge bg-light text-dark border">${t.method || 'Cash'}</span></td>
                <td>
                    ${!isVoid ? `
                        <button class="btn btn-sm btn-outline-primary me-1" onclick="openEditTransactionModal(${t.id})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteTransaction(${t.id})" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    ` : '<span class="badge bg-secondary">Voided</span>'}
                </td>
            </tr>
        `}).join('');
    }
}

function deleteTransaction(id) {
    if (!confirm('Are you sure you want to delete this record? This cannot be undone.')) return;

    let transactions = JSON.parse(localStorage.getItem(STORAGE_KEYS.TRANSACTIONS)) || [];
    transactions = transactions.filter(t => t.id !== id);
    localStorage.setItem(STORAGE_KEYS.TRANSACTIONS, JSON.stringify(transactions));

    loadFinanceDashboard();
    // Re-render report if on report page/modal? 
    // Usually this function is called from Dashboard. If called from report, we might need a refresh callback.
    // For now, simple reload of dashboard data.
    alert('Record deleted successfully');
}

function openEditTransactionModal(id) {
    const transactions = JSON.parse(localStorage.getItem(STORAGE_KEYS.TRANSACTIONS)) || [];
    const t = transactions.find(trx => trx.id === id);
    if (!t) return;

    document.getElementById('editTrxId').value = t.id;
    document.getElementById('editTrxType').value = t.type;
    document.getElementById('editTrxCategory').value = t.category;
    document.getElementById('editTrxDesc').value = t.description;
    document.getElementById('editTrxAmount').value = t.amount;
    document.getElementById('editTrxDate').value = t.date;
    document.getElementById('editTrxMethod').value = t.method || 'Cash';

    new bootstrap.Modal(document.getElementById('editTransactionModal')).show();
}

function handleEditTransactionSubmit(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    const id = parseInt(formData.get('id'));

    let transactions = JSON.parse(localStorage.getItem(STORAGE_KEYS.TRANSACTIONS)) || [];
    const index = transactions.findIndex(t => t.id === id);

    if (index > -1) {
        transactions[index].category = formData.get('category');
        transactions[index].description = formData.get('description');
        transactions[index].amount = parseFloat(formData.get('amount'));
        transactions[index].date = formData.get('date');
        transactions[index].method = formData.get('method');
        transactions[index].audit = transactions[index].audit || {};
        transactions[index].audit.updatedAt = new Date().toISOString();

        localStorage.setItem(STORAGE_KEYS.TRANSACTIONS, JSON.stringify(transactions));

        const modal = bootstrap.Modal.getInstance(document.getElementById('editTransactionModal'));
        if (modal) modal.hide();

        alert('Transaction Updated');
        loadFinanceDashboard();
        // If we were in a report view, we might want to refresh that too.
        // But mainly this is for the dashboard list.
    }
}

// ------------------
// REPORT GENERATION
// ------------------
function toggleReportDates() {
    const type = document.getElementById('reportType').value;
    document.querySelectorAll('.report-date').forEach(el => el.classList.add('d-none'));

    if (type === 'daily') document.getElementById('dateExactBox').classList.remove('d-none');
    if (type === 'monthly') document.getElementById('dateMonthBox').classList.remove('d-none');
    if (type === 'yearly') document.getElementById('dateYearBox').classList.remove('d-none');
    if (type === 'custom') document.getElementById('dateCustomBox').classList.remove('d-none');
}

function generateReport() {
    const type = document.getElementById('reportType').value;
    const transactions = JSON.parse(localStorage.getItem(STORAGE_KEYS.TRANSACTIONS)) || [];
    let filtered = [];
    let startDate, endDate;

    if (type === 'daily') {
        const date = document.getElementById('reportDate').value;
        if (!date) return alert("Select Date");
        filtered = transactions.filter(t => t.date === date);
    }
    else if (type === 'monthly') {
        const monthStr = document.getElementById('reportMonth').value; // YYYY-MM
        if (!monthStr) return alert("Select Month");
        filtered = transactions.filter(t => t.date.startsWith(monthStr));
    }
    else if (type === 'yearly') {
        const year = document.getElementById('reportYear').value;
        filtered = transactions.filter(t => t.date.startsWith(year));
    }
    else if (type === 'custom') {
        startDate = document.getElementById('reportStartDate').value;
        endDate = document.getElementById('reportEndDate').value;
        if (!startDate || !endDate) return alert("Select Date Range");
        filtered = transactions.filter(t => t.date >= startDate && t.date <= endDate);
    }

    const activeTrx = filtered.filter(t => t.status !== 'Void');

    const totalIncome = activeTrx.filter(t => t.type === 'credit').reduce((sum, t) => sum + parseFloat(t.amount), 0);
    const totalExpense = activeTrx.filter(t => t.type === 'debit').reduce((sum, t) => sum + parseFloat(t.amount), 0);
    const netProfit = totalIncome - totalExpense;

    // Render Summary
    document.getElementById('repIncome').textContent = `$${formatCurrency(totalIncome)}`;
    document.getElementById('repExpense').textContent = `$${formatCurrency(totalExpense)}`;
    document.getElementById('repProfit').textContent = `$${formatCurrency(netProfit)}`;
    document.getElementById('repCount').textContent = filtered.length;

    // Render Table
    const tbody = document.querySelector('#reportTable tbody');
    tbody.innerHTML = filtered.map(t => `
        <tr class="${t.status === 'Void' ? 'table-secondary' : ''}">
            <td>${t.date}</td>
            <td><span class="badge bg-${t.type === 'credit' ? 'success' : 'danger'}">${t.type.toUpperCase()}</span></td>
            <td>${t.category}</td>
            <td>${t.description} ${t.status === 'Void' ? '(VOID)' : ''}</td>
            <td>${t.method || '-'}</td>
            <td>$${formatCurrency(t.amount)}</td>
            <td>
                 ${t.status !== 'Void' ? `
                    <button class="btn btn-sm btn-outline-primary" onclick="openEditTransactionModal(${t.id})"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteTransaction(${t.id})"><i class="fas fa-trash"></i></button>
                 ` : ''}
            </td>
        </tr>
    `).join('');

    document.getElementById('reportResult').classList.remove('d-none');
}

// Export CSV for the CURRENT filtered report
function exportReportCSV() {
    // Re-run generation logic or grab from table? Let's grab table for simplicity
    const rows = Array.from(document.querySelectorAll('#reportTable tbody tr'));
    let csv = "Date,Type,Category,Description,Method,Amount\n";

    rows.forEach(row => {
        const cols = row.querySelectorAll('td');
        const data = Array.from(cols).map(c => c.innerText.replace(',', ' ')); // clean commas
        csv += data.join(',') + "\n";
    });

    const link = document.createElement("a");
    link.href = "data:text/csv;charset=utf-8," + encodeURI(csv);
    link.download = "financial_report.csv";
    link.click();
}

function printReport() {
    window.print();
}

function printVoucher(id) {
    const transactions = JSON.parse(localStorage.getItem(STORAGE_KEYS.TRANSACTIONS)) || [];
    const trx = transactions.find(t => t.id === id);
    if (!trx) return;

    const voucherWindow = window.open('', 'PRINT', 'height=600,width=800');
    voucherWindow.document.write(`
        <html>
        <head>
            <title>Transaction Voucher - ${trx.id}</title>
            <style>
                body { font-family: 'Segoe UI', sans-serif; padding: 40px; }
                .voucher-box { border: 2px solid #333; padding: 30px; max-width: 700px; margin: 0 auto; }
                .header { text-align: center; border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 20px; }
                .header h2 { margin: 0; color: #2c3e50; }
                .row { display: flex; justify-content: space-between; margin-bottom: 15px; }
                .label { font-weight: bold; color: #666; }
                .value { font-weight: 500; }
                .amount-box { background: #f8f9fa; padding: 15px; text-align: right; margin-top: 20px; border-radius: 5px; }
                .footer { margin-top: 40px; font-size: 12px; color: #999; text-align: center; border-top: 1px solid #eee; padding-top: 10px; }
                .stamp { position: absolute; right: 100px; top: 150px; border: 3px solid #ef4444; color: #ef4444; padding: 10px; transform: rotate(-15deg); font-weight: bold; font-size: 24px; display: ${trx.status === 'Void' ? 'block' : 'none'}; }
            </style>
        </head>
        <body>
            <div class="voucher-box">
                <div class="stamp">VOID</div>
                <div class="header">
                    <h2>EduPro Institute</h2>
                    <p>Official Transaction Voucher</p>
                </div>
                <div class="row">
                    <div><span class="label">Voucher No:</span> <span class="value">#${trx.id}</span></div>
                    <div><span class="label">Date:</span> <span class="value">${trx.date}</span></div>
                </div>
                <div class="row">
                    <div><span class="label">Type:</span> <span class="value" style="text-transform: uppercase;">${trx.type}</span></div>
                    <div><span class="label">Method:</span> <span class="value">${trx.method || 'Cash'}</span></div>
                </div>
                <hr style="border: 0; border-top: 1px solid #eee;">
                <div class="row">
                    <div><span class="label">Category:</span> <span class="value">${trx.category}</span></div>
                </div>
                <div class="row">
                    <div><span class="label">Description:</span> <span class="value">${trx.description}</span></div>
                </div>
                
                <div class="amount-box">
                    <span class="label" style="font-size: 18px;">Total Amount:</span>
                    <span class="value" style="font-size: 24px; color: #2c3e50;">$${formatCurrency(trx.amount)}</span>
                </div>

                <div class="footer">
                    <p>Generated by Super Admin System | ${trx.audit?.timestamp || ''}</p>
                    <p>This is a computer-generated document and does not require a signature.</p>
                </div>
            </div>
            <script>
                window.onload = function() { window.print(); window.close(); }
            </script>
        </body>
        </html>
    `);
}

window.voidTransaction = voidTransaction;
window.printVoucher = printVoucher;
window.generateReport = generateReport;
window.exportReportCSV = exportReportCSV;
window.printReport = printReport;
window.openCollectFeeModal = null;
window.processFeePayment = null;
window.addTransaction = addTransaction;
