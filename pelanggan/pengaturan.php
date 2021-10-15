<?php
if (count(get_included_files()) == 1) exit("Direct access not permitted");
?>
<div class="page-heading">
    <h3>Pengaturan</h3>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Akun</h5>
                    <form>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Nama Perusahaan">
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Password Lama</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Password Baru</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="file" class="form-control" id="floatingInput" placeholder="Logo">
                            <label for="floatingInput">Foto Profil</label>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Simpan">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>