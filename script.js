const modal = document.getElementById("modalForm");
const btnTambah = document.querySelector(".tambah");
const closeBtn = document.querySelector(".close");
const form = document.getElementById("formMahasiswa");

const modalTitle = document.getElementById("modalTitle");
const idInput = document.getElementById("id");
const npmInput = document.getElementById("npm");
const namaInput = document.getElementById("nama");
const jurusanInput = document.getElementById("jurusan");

const tbody = document.querySelector("tbody");

const API_URL = "http://localhost/Praktikum/api/";

// =======================
// READ DATA
// =======================
function loadData() {
    fetch(API_URL + "read.php")
        .then(response => response.json())
        .then(data => {
            tbody.innerHTML = "";
            let no = 1;

            data.forEach(item => {
                tbody.innerHTML += `
                    <tr>
                        <td>${no++}</td>
                        <td>${item.npm}</td>
                        <td>${item.nama}</td>
                        <td>${item.jurusan}</td>
                        <td>
                            <button class="btn edit" onclick="editData(${item.id}, '${item.npm}', '${item.nama}', '${item.jurusan}')">Edit</button>
                            <button class="btn hapus" onclick="deleteData(${item.id})">Hapus</button>
                        </td>
                    </tr>
                `;
            });
        });
}

loadData();

// =======================
// BUKA MODAL TAMBAH
// =======================
btnTambah.onclick = function() {
    modal.style.display = "block";
    modalTitle.innerText = "Tambah Mahasiswa";
    form.reset();
    idInput.value = "";
};

// =======================
// EDIT DATA
// =======================
window.editData = function(id, npm, nama, jurusan) {
    modal.style.display = "block";
    modalTitle.innerText = "Edit Mahasiswa";

    idInput.value = id;
    npmInput.value = npm;
    namaInput.value = nama;
    jurusanInput.value = jurusan;
};

// =======================
// DELETE DATA
// =======================
window.deleteData = function(id) {
    if (confirm("Yakin ingin menghapus data?")) {
        fetch(API_URL + "delete.php", {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(() => loadData());
    }
};

// =======================
// SIMPAN (CREATE / UPDATE)
// =======================
form.onsubmit = function(e) {
    e.preventDefault();

    const data = {
        id: idInput.value,
        npm: npmInput.value,
        nama: namaInput.value,
        jurusan: jurusanInput.value
    };

    let url = API_URL + "create.php";

    if (data.id !== "") {
        url = API_URL + "update.php";
    }

    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(() => {
        modal.style.display = "none";
        loadData();
    });
};

// =======================
// TUTUP MODAL
// =======================
closeBtn.onclick = function() {
    modal.style.display = "none";
};

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
};