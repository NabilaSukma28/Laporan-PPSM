$(document).ready(function () {
  $("#dataTables-example").DataTable({
    language: {
      decimal: "",
      emptyTable: "Tidak ada data yang tersedia",
      info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
      infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
      infoFiltered: "(disaring dari _MAX_ total data)",
      infoPostFix: "",
      thousands: ".",
      lengthMenu: "Tampilkan _MENU_ data per halaman",
      loadingRecords: "Memuat...",
      processing: "Memproses...",
      search: "Cari:",
      zeroRecords: "Tidak ditemukan data yang sesuai",
      paginate: {
        first: "Pertama",
        last: "Terakhir",
        next: "Selanjutnya",
        previous: "Sebelumnya",
      },
      aria: {
        sortAscending: ": aktifkan untuk mengurutkan kolom naik",
        sortDescending: ": aktifkan untuk mengurutkan kolom turun",
      },
    },
  });
});

