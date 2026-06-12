// script.js
document.getElementById('formEResume').addEventListener('submit', function(event) {
    // Menghentikan form submit sementara untuk dicek
    event.preventDefault(); 
    
    let tglMasuk = new Date(document.getElementById('tglMasuk').value);
    let tglPulang = new Date(document.getElementById('tglPulang').value);
    let icd10 = document.getElementById('icd10').value;

    // Aturan Validasi 1: Tanggal logika
    if (tglPulang < tglMasuk) {
        Swal.fire('Error!', 'Tanggal pulang tidak boleh mendahului tanggal masuk!', 'error');
        return false;
    }

    // Aturan Validasi 2: Format ICD-10 (Opsional)
    let icd10Pattern = /^[A-Z][0-9]{2}(\.[0-9]{1,2})?$/;
    if (!icd10Pattern.test(icd10)) {
        Swal.fire({
            title: 'Peringatan Kode!',
            text: 'Format ICD-10 sepertinya tidak sesuai standar. Tetap simpan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Lanjutkan submit ke PHP jika user menekan 'Ya'
                this.submit(); 
            }
        });
    } else {
        // Jika semua validasi lulus, lanjutkan pengiriman data ke PHP
        this.submit();
    }
});