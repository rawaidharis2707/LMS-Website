// Discount Management System Functions

async function getAllDiscounts(userId = null) {
    try {
        let url = '/api/discounts';
        if (userId) url += `?user_id=${userId}`;
        const response = await fetch(url);
        return await response.json();
    } catch (error) {
        console.error('Error fetching discounts:', error);
        return [];
    }
}

async function applyDiscount(discountData) {
    try {
        const response = await fetch('/api/discounts', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            body: JSON.stringify(discountData)
        });

        return await response.json();
    } catch (error) {
        console.error('Error applying discount:', error);
        return { success: false };
    }
}

async function deleteDiscount(id) {
    try {
        const response = await fetch(`/api/discounts/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        });

        return await response.json();
    } catch (error) {
        console.error('Error deleting discount:', error);
        return { success: false };
    }
}

async function updateDiscount(id, data) {
    try {
        const response = await fetch(`/api/discounts/${id}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            body: JSON.stringify(data)
        });

        return await response.json();
    } catch (error) {
        console.error('Error updating discount:', error);
        return { success: false };
    }
}

// Global Exports
window.getAllDiscounts = getAllDiscounts;
window.applyDiscount = applyDiscount;
window.deleteDiscount = deleteDiscount;
window.updateDiscount = updateDiscount;
