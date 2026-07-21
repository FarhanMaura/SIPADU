// admin/pengajuan.js - Modal reject handler
function showRejectModal(pengajuanId) {
    const form = document.getElementById('rejectForm');
    form.action = '/admin/pengajuan/' + pengajuanId + '/reject';
    $('#rejectModal').modal('show');
}
