// Initialize Leaflet Map


// Function to show wisata detail
function showWisataDetail(id_wisata) {
    fetch(`get_wisata_detail.php?id=${id_wisata}`)
        .then(response => response.json())
        .then(wisata => {
            const modalContent = `
                <div class="modal fade" id="wisataModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">${wisata.nama_wisata}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <img src="assets/images/wisata/${wisata.foto_wisata}" class="img-fluid mb-3" alt="${wisata.nama_wisata}">
                                <h6>Alamat:</h6>
                                <p>${wisata.alamat}</p>
                                <h6>Deskripsi:</h6>
                                <p>${wisata.deskripsi}</p>
                                <h6>Harga Tiket:</h6>
                                <p>${wisata.harga_tiket}</p>
                                <h6>Jumlah Pengunjung:</h6>
                                <p>${wisata.banyak_pengunjung}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Remove existing modal if any
            const existingModal = document.getElementById('wisataModal');
            if (existingModal) {
                existingModal.remove();
            }

            // Add new modal to document
            document.body.insertAdjacentHTML('beforeend', modalContent);

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('wisataModal'));
            modal.show();
        })
        .catch(error => console.error('Error:', error));
};

// Navbar scroll effect
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        navbar.classList.add('navbar-scrolled');
    } else {
        navbar.classList.remove('navbar-scrolled');
    }
});