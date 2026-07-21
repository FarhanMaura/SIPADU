function toggleKeterangan(val) {
    if(val === 'izin' || val === 'sakit') {
        document.getElementById('div-keterangan').style.display = 'block';
        document.querySelector('input[name="keterangan"]').required = true;
    } else {
        document.getElementById('div-keterangan').style.display = 'none';
        document.querySelector('input[name="keterangan"]').required = false;
    }
}
