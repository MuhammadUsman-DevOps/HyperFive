
function printCustomerReceipt() {
    // Get the HTML content of the modal body
    var receiptContent = document.getElementById('customer_invoice').innerHTML;

    // Define the CSS styles specific for thermal printing
    var printStyles = `
            <style>
                body {
                    width: 80mm;
                    margin: 0;
                    font-size: 12px;
                    font-family: 'Courier New', Courier, monospace;
                }
                /*.table {*/
                /*    width: 100%;*/
                /*    border-collapse: collapse;*/
                /*}*/
                /*.table th, .table td {*/
                /*    border: 1px solid black;*/
                /*    padding: 2px;*/
                /*}*/
                .table thead th {
                    border-bottom: 2px solid #000;
                }
                .table tbody tr {
                    border-bottom: 1px dashed #000;
                }
                .justify-content-between {
                    display: flex;
                    justify-content: space-between;
                }
            </style>
        `;

    // Create a new window for printing
    var printWindow = window.open('', '_blank', 'width=300,height=600');
    printWindow.document.write('<html><head><title>Print Receipt</title>');
    printWindow.document.write('<link href="{{ global_asset('static/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />');
    printWindow.document.write('<link href="{{ global_asset('static/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />');
    printWindow.document.write(printStyles); // Write the styles into the head of the document
    printWindow.document.write('</head><body>');
    printWindow.document.write(receiptContent); // Write the modal content into the body
    printWindow.document.write('</body></html>');
    printWindow.document.close(); // Necessary for IE >= 10
    printWindow.focus(); // Necessary for IE >= 10

    // Print the document and close the window after printing
    printWindow.print();
    // printWindow.close();
}
