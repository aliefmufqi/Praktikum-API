<!DOCTYPE html>
<html>
<head>
    <title>CRUD Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">CRUD Mahasiswa</h2>

    <button class="btn btn-primary mb-3" onclick="openModal()">Tambah</button>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>NPM</th>
                <th>Nama</th>
                <th>Jurusan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="data"></tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Mahasiswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id">
        <input type="text" id="npm" class="form-control mb-2" placeholder="NPM">
        <input type="text" id="nama" class="form-control mb-2" placeholder="Nama">
        <input type="text" id="jurusan" class="form-control mb-2" placeholder="Jurusan">
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" onclick="saveData()">Simpan</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
let modal = new bootstrap.Modal(document.getElementById('formModal'));

function openModal(data=null){
    document.getElementById("id").value = data?data.id:"";
    document.getElementById("npm").value = data?data.npm:"";
    document.getElementById("nama").value = data?data.nama:"";
    document.getElementById("jurusan").value = data?data.jurusan:"";
    modal.show();
}

async function loadData(){
    let res = await fetch("api/read.php");
    let data = await res.json();
    let rows = "";
    data.forEach(d=>{
        rows += `
        <tr>
            <td>${d.id}</td>
            <td>${d.npm}</td>
            <td>${d.nama}</td>
            <td>${d.jurusan}</td>
            <td>
                <button class="btn btn-warning btn-sm" onclick='openModal(${JSON.stringify(d)})'>Edit</button>
                <button class="btn btn-danger btn-sm" onclick='deleteData(${d.id})'>Hapus</button>
            </td>
        </tr>`;
    });
    document.getElementById("data").innerHTML = rows;
}

async function saveData(){
    let id = document.getElementById("id").value;
    let url = id ? "api/update.php" : "api/create.php";

    await fetch(url,{
        method:"POST",
        headers:{"Content-Type":"application/json"},
        body:JSON.stringify({
            id:id,
            npm:document.getElementById("npm").value,
            nama:document.getElementById("nama").value,
            jurusan:document.getElementById("jurusan").value
        })
    });

    modal.hide();
    loadData();
}

async function deleteData(id){
    if(confirm("Yakin hapus?")){
        await fetch("api/delete.php",{
            method:"POST",
            headers:{"Content-Type":"application/json"},
            body:JSON.stringify({id:id})
        });
        loadData();
    }
}

window.onload = loadData;
</script>
</body>
</html>