import './bootstrap';

import '@popperjs/core';

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import 'admin-lte/dist/js/adminlte.min.js';

import '@fortawesome/fontawesome-free/css/all.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import Swal from 'sweetalert2';
import jQuery from 'jquery';
import DataTable from 'datatables.net-bs5';

window.Swal = Swal;

window.$ = window.jQuery = jQuery;
window.DataTable = DataTable;
$.extend(true, $.fn.dataTable.defaults, {
    responsive: true,
    language: {
        "sEmptyTable": "Tidak ada data yang tersedia pada tabel ini",
        "sProcessing": "Sedang memproses...",
        "sLengthMenu": "Tampilkan _MENU_ data",
        "sZeroRecords": "Tidak ditemukan data yang sesuai",
        "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
        "sInfoFiltered": "(disaring dari _MAX_ data keseluruhan)",
        "sSearch": "Cari:",
        "oPaginate": {
            "sFirst": "Pertama",
            "sPrevious": "Sebelumnya",
            "sNext": "Selanjutnya",
            "sLast": "Terakhir"
        }
    },
    columnDefs: [
        {orderable: false, targets: -1}
    ]
});

