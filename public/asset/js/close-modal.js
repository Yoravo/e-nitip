function closeModal(modalId) {
    $('#penaltyModal-' + modalId).modal('hide'); // Tutup modal secara manual
    $('body').removeClass('modal-open'); // Pastikan overlay abu-abu dihapus
    $('.modal-backdrop').remove(); // Hapus backdrop overlay
    $('#penaltyModal-' + modalId).on('hidden.bs.modal', function () {
        $(this).removeData('bs.modal'); // Reset modal setelah ditutup
    });
}
