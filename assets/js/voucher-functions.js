// Fee Voucher Management System Functions
// To be appended to data.js

// =====================================================
// Fee Voucher Management System
// =====================================================

// Initialize voucher storage
function initVoucherStorage() {
    if (!localStorage.getItem('lms_vouchers')) {
        localStorage.setItem('lms_vouchers', JSON.stringify([]));
    }
    if (!localStorage.getItem('feeCategories')) {
        const defaultCategories = [
            { id: 1, name: 'Tuition Fee', defaultAmount: 400, active: true },
            { id: 2, name: 'Library Fee', defaultAmount: 30, active: true },
            { id: 3, name: 'Lab Fee', defaultAmount: 50, active: true },
            { id: 4, name: 'Sports Fee', defaultAmount: 20, active: true }
        ];
        localStorage.setItem('feeCategories', JSON.stringify(defaultCategories));
    }
    if (!localStorage.getItem('adminPermissions')) {
        localStorage.setItem('adminPermissions', JSON.stringify({
            canManageLateFees: true,
            canEditCategories: true,
            canDeleteVouchers: true
        }));
    }
}

// Fee Category Management
function getAllFeeCategories() {
    initVoucherStorage();
    return JSON.parse(localStorage.getItem('feeCategories') || '[]');
}

function addFeeCategory(name, defaultAmount = 0) {
    const categories = getAllFeeCategories();
    const newCategory = {
        id: Date.now(),
        name: name,
        defaultAmount: defaultAmount,
        active: true
    };
    categories.push(newCategory);
    localStorage.setItem('feeCategories', JSON.stringify(categories));
    return newCategory;
}

function removeFeeCategory(categoryId) {
    const categories = getAllFeeCategories();
    const updated = categories.filter(cat => cat.id !== categoryId);
    localStorage.setItem('feeCategories', JSON.stringify(updated));
    return true;
}

function updateFeeCategory(categoryId, name, defaultAmount) {
    const categories = getAllFeeCategories();
    const category = categories.find(cat => cat.id === categoryId);
    if (category) {
        category.name = name;
        category.defaultAmount = defaultAmount;
        localStorage.setItem('feeCategories', JSON.stringify(categories));
        return category;
    }
    return null;
}

// Permission Management
function getAdminPermissions() {
    return JSON.parse(localStorage.getItem('adminPermissions') || '{"canManageLateFees":false}');
}

function canManageLateFees() {
    const permissions = getAdminPermissions();
    return permissions.canManageLateFees === true;
}

// Voucher CRUD Operations
function getAllVouchers() {
    initVoucherStorage();
    return JSON.parse(localStorage.getItem('lms_vouchers') || '[]');
}

function getStudentVouchers(studentId) {
    const allVouchers = getAllVouchers();
    return allVouchers.filter(v => v.studentId === studentId);
}

function getVoucherById(voucherId) {
    const vouchers = getAllVouchers();
    return vouchers.find(v => v.id === voucherId);
}

function createVoucher(voucherData) {
    const vouchers = getAllVouchers();
    const newVoucher = {
        id: voucherData.id || 'FEE-' + Date.now(),
        studentId: voucherData.studentId,
        studentName: voucherData.studentName,
        fatherName: voucherData.fatherName || '',
        class: voucherData.class,
        rollNo: voucherData.rollNo || '',
        period: voucherData.period,
        issueDate: voucherData.issueDate,
        dueDate: voucherData.dueDate,
        fees: voucherData.fees || [],
        linkedFineIds: voucherData.linkedFineIds || [],
        totalAmount: voucherData.totalAmount || 0,
        discount: voucherData.discount || 0,
        lateFine: voucherData.lateFine || 0,
        status: voucherData.status || 'unpaid',
        paymentDate: voucherData.paymentDate || null,
        paymentMethod: voucherData.paymentMethod || null,
        transactionId: voucherData.transactionId || null,
        customFields: voucherData.customFields || {},
        notes: voucherData.notes || '',
        createdBy: voucherData.createdBy || 'admin',
        createdAt: new Date().toISOString(),
        updatedAt: new Date().toISOString()
    };
    vouchers.push(newVoucher);
    localStorage.setItem('lms_vouchers', JSON.stringify(vouchers));
    return newVoucher;
}

function updateVoucher(voucherId, updates) {
    const vouchers = getAllVouchers();
    const voucherIndex = vouchers.findIndex(v => v.id === voucherId);

    if (voucherIndex !== -1) {
        vouchers[voucherIndex] = {
            ...vouchers[voucherIndex],
            ...updates,
            updatedAt: new Date().toISOString()
        };
        localStorage.setItem('lms_vouchers', JSON.stringify(vouchers));
        return vouchers[voucherIndex];
    }
    return null;
}

function deleteVoucher(voucherId) {
    const vouchers = getAllVouchers();
    const filtered = vouchers.filter(v => v.id !== voucherId);
    localStorage.setItem('lms_vouchers', JSON.stringify(filtered));
    return true;
}

function markVoucherPaid(voucherId, paymentData = {}) {
    return updateVoucher(voucherId, {
        status: 'paid',
        paymentDate: paymentData.paymentDate || new Date().toISOString(),
        paymentMethod: paymentData.paymentMethod || 'Cash',
        transactionId: paymentData.transactionId || null
    });
}

function markVoucherUnpaid(voucherId) {
    return updateVoucher(voucherId, {
        status: 'unpaid',
        paymentDate: null,
        paymentMethod: null,
        transactionId: null
    });
}

// Calculate totals and statistics
function getVoucherStatistics() {
    const vouchers = getAllVouchers();
    return {
        total: vouchers.length,
        paid: vouchers.filter(v => v.status === 'paid').length,
        unpaid: vouchers.filter(v => v.status === 'unpaid').length,
        overdue: vouchers.filter(v => v.status === 'unpaid' && new Date(v.dueDate) < new Date()).length,
        totalAmount: vouchers.reduce((sum, v) => sum + v.totalAmount, 0),
        paidAmount: vouchers.filter(v => v.status === 'paid').reduce((sum, v) => sum + v.totalAmount, 0),
        pendingAmount: vouchers.filter(v => v.status === 'unpaid').reduce((sum, v) => sum + v.totalAmount, 0)
    };
}

function getStudentVoucherStatistics(studentId) {
    const vouchers = getStudentVouchers(studentId);
    return {
        total: vouchers.length,
        paid: vouchers.filter(v => v.status === 'paid').length,
        unpaid: vouchers.filter(v => v.status === 'unpaid').length,
        overdue: vouchers.filter(v => v.status === 'unpaid' && new Date(v.dueDate) < new Date()).length,
        totalAmount: vouchers.reduce((sum, v) => sum + v.totalAmount, 0),
        paidAmount: vouchers.filter(v => v.status === 'paid').reduce((sum, v) => sum + v.totalAmount, 0),
        pendingAmount: vouchers.filter(v => v.status === 'unpaid').reduce((sum, v) => sum + v.totalAmount, 0)
    };
}
