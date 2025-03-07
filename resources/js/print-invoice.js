document.addEventListener('DOMContentLoaded', function() {
    const printInvoiceBtn = document.getElementById('printInvoiceBtn');
    if (printInvoiceBtn) {
        printInvoiceBtn.addEventListener('click', function() {
            window.print();
        });
    }
});
