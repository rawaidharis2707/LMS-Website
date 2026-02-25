/**
 * Salary Management Functions
 * Handles Staff Data, Attendance-based Deductions, and Slip Generation
 */

const SALARY_KEYS = {
    STAFF: 'lms_staff_data',
    SALARY_HISTORY: 'lms_salary_history',
    ATTENDANCE: 'lms_teacher_attendance' // Shared key ideally
};

// 1. Mock Candidates Pool for Auto-Fill
const CANDIDATE_POOL = [
    { name: "Robert Fox", id: "EMP101", role: "Teacher", dept: "Physics", salary: 48000, allow: 5000, bank: "Wells Fargo", acc: "987612345", title: "Robert Fox" },
    { name: "Jenny Wilson", id: "EMP102", role: "Teacher", dept: "Chemistry", salary: 47000, allow: 4500, bank: "Chase", acc: "123498765", title: "Jenny Wilson" },
    { name: "Kristin Watson", id: "EMP103", role: "Support Staff", dept: "Maintenance", salary: 25000, allow: 1000, bank: "Bank of America", acc: "456789123", title: "Kristin Watson" },
    { name: "Cody Fisher", id: "EMP104", role: "Admin", dept: "Registrar", salary: 40000, allow: 3000, bank: "Citi", acc: "789123456", title: "Cody Fisher" },
    { name: "Esther Howard", id: "EMP105", role: "Teacher", dept: "English", salary: 46000, allow: 4000, bank: "PNC Bank", acc: "321654987", title: "Esther Howard" }
];

// Mock Staff Data
function initSalaryData() {
    if (!localStorage.getItem(SALARY_KEYS.STAFF)) {
        const dummyStaff = [
            {
                id: 'EMP001', name: 'Sarah Johnson', role: 'Teacher', department: 'Science',
                baseSalary: 45000, allowances: 5000, status: 'Active',
                bank: { name: 'Chase Bank', account: '123456789', title: 'Sarah Johnson' }
            },
            {
                id: 'EMP002', name: 'Michael Chen', role: 'Teacher', department: 'Math',
                baseSalary: 42000, allowances: 4000, status: 'Active',
                bank: { name: 'Bank of America', account: '987654321', title: 'Michael Chen' }
            },
            {
                id: 'EMP003', name: 'Emily Davis', role: 'Admin', department: 'Administration',
                baseSalary: 35000, allowances: 2000, status: 'Active',
                bank: null
            }
        ];
        localStorage.setItem(SALARY_KEYS.STAFF, JSON.stringify(dummyStaff));
    }
}

document.addEventListener('DOMContentLoaded', function () {
    if (window.location.pathname.includes('salary.html')) {
        initSalaryData();
        loadSalaryDashboard(); // Default tab
        loadStaffTable(); // Initial load
        initAutoFill(); // Setup suggestions

        // Tab Event Listeners (if needed for specific refreshes)
        const tabs = document.querySelectorAll('button[data-bs-toggle="tab"]');
        tabs.forEach(tab => {
            tab.addEventListener('shown.bs.tab', (e) => {
                const target = e.target.getAttribute('data-bs-target');
                if (target === '#staff') loadStaffTable();
                if (target === '#attendance') loadAttendanceReview(); // Future implementation
                if (target === '#payroll') loadPayrollTable();
                if (target === '#history') loadSalaryHistory();
            });
        });
    }
});

/**
 * 1. Staff Structure Tab
 */
function loadStaffTable() {
    const staff = JSON.parse(localStorage.getItem(SALARY_KEYS.STAFF)) || [];
    const tbody = document.getElementById('staffTableBody');
    if (!tbody) return;

    tbody.innerHTML = staff.map(s => `
        <tr>
            <td class="fw-bold">${s.id}</td>
            <td>${s.name}</td>
            <td><span class="badge bg-light text-dark">${s.role}</span></td>
            <td>$${formatNumber(parseFloat(s.baseSalary))}</td>
            <td>$${formatNumber(parseFloat(s.allowances))}</td>
            <td>
                <button class="btn btn-sm btn-outline-primary me-2" onclick="openEditStaffModal('${s.id}')"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-outline-danger" onclick="deleteStaff('${s.id}')"><i class="fas fa-trash-alt"></i></button>
            </td>
        </tr>
    `).join('');
}

function handleStaffSubmit(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    const newStaff = {
        id: formData.get('id'),
        name: formData.get('name'),
        role: formData.get('role'),
        department: formData.get('department'),
        baseSalary: parseFloat(formData.get('baseSalary')),
        allowances: parseFloat(formData.get('allowances')),
        status: 'Active',
        joinedAt: new Date().toISOString(),
        bank: {
            name: formData.get('bankName'),
            account: formData.get('accountNumber'),
            title: formData.get('accountTitle')
        }
    };

    const staff = JSON.parse(localStorage.getItem(SALARY_KEYS.STAFF)) || [];
    // Check ID conflict
    if (staff.some(s => s.id === newStaff.id)) {
        alert("Employee ID already exists!");
        return;
    }
    staff.push(newStaff);
    localStorage.setItem(SALARY_KEYS.STAFF, JSON.stringify(staff));

    // Reset and Close
    e.target.reset();
    const modalEl = document.getElementById('addStaffModal');
    const modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) modal.hide();

    // showToast('Staff Added Successfully', 'success'); // Assuming showToast is global or need to import
    alert('Staff Added Successfully');
    loadStaffTable();
}

/**
 * Edit & Delete Functions
 */
function deleteStaff(id) {
    if (!confirm('Are you sure you want to delete this staff member? This cannot be undone.')) return;

    let staff = JSON.parse(localStorage.getItem(SALARY_KEYS.STAFF)) || [];
    staff = staff.filter(s => s.id !== id);
    localStorage.setItem(SALARY_KEYS.STAFF, JSON.stringify(staff));

    loadStaffTable();
    // Also re-load payroll table if they were removed from calculation candidates
    loadPayrollTable();
}

function openEditStaffModal(id) {
    const staff = JSON.parse(localStorage.getItem(SALARY_KEYS.STAFF)) || [];
    const s = staff.find(st => st.id === id);
    if (!s) return;

    document.getElementById('editEmpId').value = s.id;
    document.getElementById('editEmpIdDisplay').value = s.id;
    document.getElementById('editName').value = s.name;
    document.getElementById('editRole').value = s.role;
    document.getElementById('editDepartment').value = s.department;
    document.getElementById('editBaseSalary').value = s.baseSalary;
    document.getElementById('editAllowances').value = s.allowances || 0;

    // Banking
    if (s.bank) {
        document.getElementById('editBankName').value = s.bank.name || '';
        document.getElementById('editAccountNumber').value = s.bank.account || '';
        document.getElementById('editAccountTitle').value = s.bank.title || '';
    } else {
        document.getElementById('editBankName').value = '';
        document.getElementById('editAccountNumber').value = '';
        document.getElementById('editAccountTitle').value = '';
    }

    new bootstrap.Modal(document.getElementById('editStaffModal')).show();
}

function handleEditStaffSubmit(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    const id = formData.get('id');

    let staff = JSON.parse(localStorage.getItem(SALARY_KEYS.STAFF)) || [];
    const index = staff.findIndex(s => s.id === id);

    if (index === -1) return;

    staff[index].name = formData.get('name');
    staff[index].role = formData.get('role');
    staff[index].department = formData.get('department');
    staff[index].baseSalary = parseFloat(formData.get('baseSalary'));
    staff[index].allowances = parseFloat(formData.get('allowances'));
    staff[index].bank = {
        name: formData.get('bankName'),
        account: formData.get('accountNumber'),
        title: formData.get('accountTitle')
    };

    localStorage.setItem(SALARY_KEYS.STAFF, JSON.stringify(staff));

    const modalEl = document.getElementById('editStaffModal');
    const modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) modal.hide();

    alert('Staff Details Updated Successfully');
    loadStaffTable();
    loadPayrollTable();
}

function editStaff(id) {
    // Deprecated, redirected to new function
    openEditStaffModal(id);
}

/**
 * 2. Attendance Review & Calculation Logic
 */
function getAttendanceStats(empId, month) {
    // In a real app, query database. Here we mock random attendance for demo.
    // Logic: 30 days - 4 Sundays = 26 workings days.
    // Random absents between 0-3.
    const totalDays = 26;
    // Utilize empId to seed random so it stays consistent per load if possible, 
    // or just fetch from localStorage if "Attendance Module" was fully linked.
    // For demo:
    const absents = Math.floor(Math.random() * 3); // 0 to 2
    const lates = Math.floor(Math.random() * 3); // 0 to 2

    // Fine Rules: 
    const finePerAbsent = 500;
    const finePerLate = 200;

    const deduction = (absents * finePerAbsent) + (lates * finePerLate);

    return { totalDays, present: totalDays - absents, absents, lates, deduction };
}

/**
 * 3. Payroll Generation
 */
function loadPayrollTable() {
    const staff = JSON.parse(localStorage.getItem(SALARY_KEYS.STAFF)) || [];
    const history = JSON.parse(localStorage.getItem(SALARY_KEYS.SALARY_HISTORY)) || [];
    const tbody = document.getElementById('payrollTableBody');
    if (!tbody) return;

    // Use current month selector if exists, else default
    const month = document.getElementById('payrollMonth')?.value || 'December 2024';

    tbody.innerHTML = staff.map(s => {
        // Check if already paid for this month
        const paidRecord = history.find(h => h.empId === s.id && h.month === month && h.status === 'Paid');

        if (paidRecord) {
            const gross = parseFloat(s.baseSalary) + parseFloat(s.allowances);
            const net = paidRecord.amount;
            const deduction = gross - net;

            return `
            <tr class="table-success">
                <td>${s.name} <br> <small class="text-muted">${s.role}</small></td>
                <td>$${formatNumber(gross)}</td>
                <td class="text-danger">-$${formatNumber(deduction)}</td>
                <td class="fw-bold text-success">$${formatNumber(net)}</td>
                <td><span class="badge bg-success">Paid</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-secondary" onclick="printSlipMock('${s.id}', '${month}')"><i class="fas fa-print"></i> Slip</button>
                </td>
            </tr>
            `;
        }

        const stats = getAttendanceStats(s.id, month);
        const gross = parseFloat(s.baseSalary) + parseFloat(s.allowances);
        const net = gross - stats.deduction;

        return `
            <tr>
                <td>${s.name} <br> <small class="text-muted">${s.role}</small></td>
                <td>$${formatNumber(gross)}</td>
                <td class="text-danger">-$${formatNumber(stats.deduction)} <br> <small>(${stats.absents} Abs, ${stats.lates} Late)</small></td>
                <td class="fw-bold text-success">$${formatNumber(net)}</td>
                <td><span class="badge bg-warning">Pending</span></td>
                <td>
                    <button class="btn btn-sm btn-success" onclick="openPaymentModal('${s.id}', '${s.name}', ${net}, '${month}')">Pay</button>
                </td>
            </tr>
        `;
    }).join('');
}

/**
 * 4. Actions
 */
function openPaymentModal(empId, empName, amount, month) {
    document.getElementById('payEmpId').value = empId;
    document.getElementById('payMonth').value = month;
    document.getElementById('payAmount').value = amount;

    document.getElementById('payEmpName').textContent = empName;
    document.getElementById('payAmountDisplay').textContent = '$' + formatNumber(amount);

    // Show Bank Details if available
    const staff = JSON.parse(localStorage.getItem(SALARY_KEYS.STAFF)) || [];
    const emp = staff.find(s => s.id === empId);
    const bankEl = document.getElementById('bankDetailsDisplay');

    if (emp && emp.bank && emp.bank.name) {
        document.getElementById('bdName').textContent = `${emp.bank.name} - ${emp.bank.title}`;
        document.getElementById('bdNumber').textContent = `Acc#: ${emp.bank.account}`;
        bankEl.classList.remove('d-none');
        // Auto-select Bank Transfer
        document.getElementById('payMethod').value = 'Bank Transfer';
    } else {
        bankEl.classList.add('d-none');
        document.getElementById('payMethod').value = 'Cash';
    }

    new bootstrap.Modal(document.getElementById('paymentModal')).show();
}

function processSalaryPayment() {
    const empId = document.getElementById('payEmpId').value;
    const month = document.getElementById('payMonth').value;
    const amount = parseFloat(document.getElementById('payAmount').value);
    const method = document.getElementById('payMethod').value;
    const ref = document.getElementById('payRef').value;

    const payment = {
        id: Date.now(),
        empId,
        amount,
        month,
        method,
        ref,
        date: new Date().toISOString().split('T')[0],
        status: 'Paid',
        audit: { paidBy: 'Super Admin', timestamp: new Date().toISOString() }
    };

    // Save to Salary History
    const history = JSON.parse(localStorage.getItem(SALARY_KEYS.SALARY_HISTORY)) || [];
    history.push(payment);
    localStorage.setItem(SALARY_KEYS.SALARY_HISTORY, JSON.stringify(history));

    // Integration: Log as Expense in Finance Module
    // Direct write since window.addTransaction might not be available in salary context
    const FINANCE_KEY = 'lms_finance_transactions';
    const financeParams = JSON.parse(localStorage.getItem(FINANCE_KEY)) || [];

    // Lookup Employee Name for description
    const staffRef = JSON.parse(localStorage.getItem(SALARY_KEYS.STAFF)) || [];
    const empData = staffRef.find(s => s.id === empId);
    const empDisplayName = empData ? empData.name : empId;

    const newTransaction = {
        id: Date.now().toString(),
        date: new Date().toISOString().split('T')[0],
        type: 'debit',
        category: 'Salaries',
        description: `Salary Payment - ${empDisplayName} (${month})`,
        amount: amount,
        method: method,
        status: 'Completed',
        audit: { createdBy: 'Super Admin', createdAt: new Date().toISOString() }
    };

    financeParams.push(newTransaction);
    localStorage.setItem(FINANCE_KEY, JSON.stringify(financeParams));

    /* 
    // Old Logic - Failed because finance-functions.js not loaded
    if (typeof window.addTransaction === 'function') {
         // ...
    } */

    // Close Modal
    const modalEl = document.getElementById('paymentModal');
    const modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) modal.hide();

    // alert('Salary Paid Successfully');
    loadPayrollTable(); // Refresh UI
    loadSalaryDashboard();
}


function loadSalaryHistory() {
    const history = JSON.parse(localStorage.getItem(SALARY_KEYS.SALARY_HISTORY)) || [];
    const tbody = document.getElementById('historyTableBody');
    if (!tbody) return;

    tbody.innerHTML = history.reverse().map(h => `
        <tr>
            <td>${h.date}</td>
            <td>${h.empId}</td>
            <td>${h.month}</td>
            <td class="fw-bold">$${formatNumber(h.amount)}</td>
            <td><span class="badge bg-success">Paid</span> via ${h.method}</td>
            <td><button class="btn btn-sm btn-outline-dark" onclick="printSlipMock('${h.empId}', '${h.month}')"><i class="fas fa-print"></i></button></td>
        </tr>
    `).join('');
}

/**
 * Dashboard Summary
 */
function loadSalaryDashboard() {
    const history = JSON.parse(localStorage.getItem(SALARY_KEYS.SALARY_HISTORY)) || [];
    const staff = JSON.parse(localStorage.getItem(SALARY_KEYS.STAFF)) || [];

    const totalPaid = history.reduce((sum, h) => sum + h.amount, 0);

    safeSetText('statTotalStaff', staff.length);
    safeSetText('statTotalPaid', `$${formatNumber(totalPaid)}`);
}


function formatNumber(num) {
    if (!num) return '0.00';
    return num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function safeSetText(id, text) {
    const el = document.getElementById(id);
    if (el) el.innerText = text;
}

function printSlipMock(empId, month) {
    const staff = JSON.parse(localStorage.getItem(SALARY_KEYS.STAFF)) || [];
    const emp = staff.find(s => s.id === empId);

    const history = JSON.parse(localStorage.getItem(SALARY_KEYS.SALARY_HISTORY)) || [];
    const pay = history.find(h => h.empId === empId && h.month === month);

    if (!emp || !pay) return alert("Details not found for print.");

    const slipWindow = window.open('', 'PRINT', 'height=600,width=800');
    slipWindow.document.write(`
        <html>
        <head>
            <title>Salary Slip - ${emp.name}</title>
            <style>
                body { font-family: 'Segoe UI', sans-serif; padding: 40px; }
                .slip-box { border: 2px solid #ccc; padding: 30px; max-width: 700px; margin: 0 auto; }
                .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
                .row { display: flex; justify-content: space-between; margin-bottom: 10px; }
                .label { font-weight: bold; width: 150px; }
                .net-pay { background: #e0f2f1; padding: 15px; text-align: right; font-size: 20px; border: 1px solid #009688; margin-top:20px;}
            </style>
        </head>
        <body>
            <div class="slip-box">
                <div class="header">
                    <h2>EduPro Institute</h2>
                    <p>Salary Slip for ${month}</p>
                </div>
                <div class="row">
                    <div><span class="label">Employee:</span> ${emp.name} (${emp.id})</div>
                    <div><span class="label">Designation:</span> ${emp.role}</div>
                </div>
                <div class="row">
                    <div><span class="label">Department:</span> ${emp.department}</div>
                    <div><span class="label">Date Paid:</span> ${pay.date}</div>
                </div>
                <hr>
                <div class="row">
                    <div><span class="label">Base Salary:</span> $${formatNumber(parseFloat(emp.baseSalary))}</div>
                </div>
                 <div class="row">
                    <div><span class="label">Allowances:</span> $${formatNumber(parseFloat(emp.allowances))}</div>
                </div>
                 <div class="row">
                    <div><span class="label">Payment Method:</span> ${pay.method}</div>
                </div>
                
                <div class="net-pay">
                    <strong>NET PAID: $${formatNumber(pay.amount)}</strong>
                </div>
                <br>
                 <p style="text-align:center; font-size:12px">Authorized Signature</p>
            </div>
            <script>window.onload = function() { window.print(); window.close(); }</script>
        </body>
        </html>
    `);
}

// Global Export
window.loadStaffTable = loadStaffTable;
window.loadPayrollTable = loadPayrollTable;
window.handleStaffSubmit = handleStaffSubmit;
window.openPaymentModal = openPaymentModal;
window.processSalaryPayment = processSalaryPayment;
window.printSlipMock = printSlipMock;
window.openEditStaffModal = openEditStaffModal;
window.handleEditStaffSubmit = handleEditStaffSubmit;
window.deleteStaff = deleteStaff;
// Auto-Fill Logic
function initAutoFill() {
    const dataList = document.getElementById('staffSuggestions');
    if (!dataList) return;

    // Filter out already added staff
    const currentStaff = JSON.parse(localStorage.getItem(SALARY_KEYS.STAFF)) || [];
    const addedIds = currentStaff.map(s => s.id);

    const available = CANDIDATE_POOL.filter(c => !addedIds.includes(c.id));

    dataList.innerHTML = available.map(c => `<option value="${c.name}">`).join('');
}

function checkAutoFill(val) {
    const candidate = CANDIDATE_POOL.find(c => c.name.toLowerCase() === val.toLowerCase());
    if (candidate) {
        document.getElementById('addEmpId').value = candidate.id;
        document.getElementById('addRole').value = candidate.role;
        document.getElementById('addDepartment').value = candidate.dept;
        document.getElementById('addBaseSalary').value = candidate.salary;
        document.getElementById('addAllowances').value = candidate.allow;
        document.getElementById('addBankName').value = candidate.bank;
        document.getElementById('addAccountNumber').value = candidate.acc;
        document.getElementById('addAccountTitle').value = candidate.title;

        // Highlight effect
        document.getElementById('addStaffForm').classList.add('shadow-sm', 'bg-light');
        setTimeout(() => document.getElementById('addStaffForm').classList.remove('shadow-sm', 'bg-light'), 500);
    }
}

window.initAutoFill = initAutoFill;
window.checkAutoFill = checkAutoFill; // Needed if re-implementing export logic properly
function exportSalaryHistory() {
    const history = JSON.parse(localStorage.getItem(SALARY_KEYS.SALARY_HISTORY)) || [];
    if (history.length === 0) return alert("No history found to export.");

    let csv = "Date,Employee ID,Month,Amount,Method,Status\n";
    history.forEach(h => {
        csv += `${h.date},${h.empId},${h.month},${h.amount},${h.method},${h.status}\n`;
    });

    triggerDownload(csv, `salary_history_${new Date().toISOString().split('T')[0]}.csv`);
}

function exportStaffStructure() {
    const staff = JSON.parse(localStorage.getItem(SALARY_KEYS.STAFF)) || [];
    if (staff.length === 0) return alert("No staff found to export.");

    let csv = "ID,Name,Role,Department,Base Salary,Allowances,Status\n";
    staff.forEach(s => {
        csv += `${s.id},"${s.name}",${s.role},${s.department},${s.baseSalary},${s.allowances},${s.status}\n`;
    });

    triggerDownload(csv, `staff_structure_${new Date().toISOString().split('T')[0]}.csv`);
}

function triggerDownload(content, fileName) {
    const blob = new Blob([content], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement("a");
    if (link.download !== undefined) {
        const url = URL.createObjectURL(blob);
        link.setAttribute("href", url);
        link.setAttribute("download", fileName);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

window.exportSalaryHistory = exportSalaryHistory;
window.exportStaffStructure = exportStaffStructure;
